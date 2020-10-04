<?php

namespace Base\Controllers\Web\Order;

use Stripe\Card;
use Stripe\Charge;
use Base\Helpers\Filter;
use ReCaptcha\ReCaptcha;
use Base\Models\User\User;
use Base\Handlers\MarkGDPR;
use Base\Handlers\EmptyBasket;
use Base\Handlers\UpdateStock;
use Base\Events\OrderWasCreated;
use Base\Handlers\MarkOrderPaid;
use Stripe\Error\InvalidRequest;
use Base\Handlers\MarkTermsAccepted;
use Base\Constructor\BaseConstructor;
use Base\Handlers\RecordFailedPayment;
use Psr\Http\Message\ResponseInterface;
use Base\Handlers\RecordSuccessfulPayment;
use Psr\Http\Message\ServerRequestInterface;
use Base\Services\Mail\Build\Auth\Activation;
use Base\Services\Mail\Build\Admin\AdminFailedPayment;
use Base\Services\Mail\Build\Web\WebOrderConfirmation;
use Base\Services\Mail\Build\Admin\AdminOrderConfirmation;

class OrderController extends BaseConstructor {

    public function getOrder(ServerRequestInterface $request, ResponseInterface $response) {
        $this->basket->refresh();

        if(!$this->basket->subTotal()) {
            return $response->withRedirect($this->router->pathFor('getCart'));
        }
        
        return $this->view->render($response, 'pages/web/order/order.php');
    }

    public function postOrder(ServerRequestInterface $request, ResponseInterface $response) {
        $ip = Filter::ip();
        
        $recaptcha = new ReCaptcha($this->config->get('recaptcha.invisible.secretKey'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->getParam('g-recaptcha-response', $ip));

        if($resp->isSuccess()) {
            $this->basket->refresh();
            
            $stripeToken = $request->getParam('stripeToken');

            if(!$stripeToken) {
                $this->flash->addMessage('error', $this->config->get('messages.payment.checkout.token'));
                return $response->withRedirect($this->router->pathFor('getOrder'));
            }

            $email = trim(strtolower($request->getParam('email_address')));
            $identifier = $this->hash->hashed($this->config->get('auth.register'));
            $password = $this->hash->password($request->getParam('password'));

            //$folder = str_replace('CGB-', '', $order_id);
            //mkdir($this->config->get('upload.path') . $folder, 0755);

            $user = User::where('email_address', $email)->first();

            if(!$user) {
                $user = User::create([
                    'username' => $username = mt_rand(100000, 999999),
                    'email_address' => $email,
                    'email_address_verified' => $identifier,
                    'password' => $this->hash->password($request->getParam('password')),
                    'active' => false,
                    'locked' => true,
                    'active_hash' => $identifier,
                    'register_ip' => $ip
                ]);

                $user->role()->attach(3);

                $user->customer()->create([
                    'title' => $request->getParam('title'),
                    'first_name' => ucwords(strtolower($request->getParam('first_name'))),
                    'last_name' => ucwords(strtolower($request->getParam('last_name'))),
                    'phone_number' => $request->getParam('phone_number'),
                    'mobile_number' => null,
                    'sms' => false,
                    'gdpr' => false
                ]);

                $user->address()->create([
                    'address' => ucwords(strtoupper($request->getParam('address'))),
                    'city' => ucwords(strtoupper($request->getParam('city'))),
                    'county' => ucwords(strtoupper($request->getParam('county'))),
                    'postcode' => strtoupper($request->getParam('postcode')),
                    'country' => strtoupper($request->getParam('country'))
				]);
                
                $this->mail->to($email, $this->config->get('mail.from.name'))->send(new Activation($user, $identifier));
            }

			$user->address()->update([
                'address' => ucwords(strtoupper($request->getParam('address'))),
                'city' => ucwords(strtoupper($request->getParam('city'))),
                'county' => ucwords(strtoupper($request->getParam('county'))),
                'postcode' => strtoupper($request->getParam('postcode')),
                'country' => strtoupper($request->getParam('country'))
            ]);

            $order_id = mt_rand(10000000000, 99999999999);
			$subTotal = $this->basket->subTotal();
			$shipping = $this->basket->shipping();
			$total = $this->basket->subTotal() + $this->basket->shipping();
			$hash = $this->hash->hashed($this->config->get('auth.order'));

            $order = $user->orders()->create([
                'order_id' => $order_id,
                'paid' => false,
                'terms_accepted' => false,
                'sub_total' => $subTotal,
                'shipping' => $shipping,
                'total' => $total,
                'total_saving' => null,
                'courier_name' => null,
                'tracking_number' => null,
                'tracking_number_added_on' => null,
                'complete' => false,
                'complete_on' => null,
                'completed_by' => null,
                'hash' => $hash
            ]);

			$order->products()->saveMany(
				$this->basket->all(),
				$this->getQuantities($this->basket->all())
            );
            
            try {
				$amount = number_format($total, 2);
				$amount = str_replace(',', '', $amount);
                $amount = str_replace('.', '', $amount);
                
                $charge = Charge::create([
					'amount' => $amount,
					'currency' => $this->config->get('stripe.currency'),
					'source' => $stripeToken,
					'description' => 'Online Order ' . $order->order_id
                ]);
                
                $event = new OrderWasCreated($order, $this->basket);
                $event->attach([
                    new RecordSuccessfulPayment(
                        $charge->id,
                        $charge->source->name,
                        $charge->source->last4,
                        $charge->source->brand,
                        $charge->source->address_zip_check,
                        $charge->source->cvc_check,
                        $charge->source->address_zip,
                        $charge->source->funding,
                        $charge->status,
                        $charge->failure_message,
                        $charge->outcome->risk_level
                    ),
                    new MarkOrderPaid,
                    new MarkTermsAccepted(
                        ($request->getParam('terms_accepted') === 'on') ?: false
                    ),
                    new MarkGDPR(
                        ($request->getParam('gdpr') === 'on') ?: false
                    ),
                    new UpdateStock,
                    new EmptyBasket
                ]);
                $event->dispatch();

                $this->mail->to($order->user->email_address, $this->config->get('mail.from.name'))->send(new WebOrderConfirmation($order));
				$this->mail->to($this->config->get('company.email'), $this->config->get('mail.from.name'))->send(new AdminOrderConfirmation($order));

                return $response->withRedirect($this->router->pathFor('getShowOrder', compact('hash')));
            } catch (InvalidRequest $e) {
				$this->flash->addMessage('error', $this->config->get('messages.payment.checkout.invalid'));
				return $response->withRedirect($this->router->pathFor('getOrder'));
			} catch (Card $e) {
				$id = Charge::all(['limit' => 1])->data[0]['id'];
				$name = Charge::all(['limit' => 1])->data[0]['source']['name'];
				$last4 = Charge::all(['limit' => 1])->data[0]['source']['last4'];
				$brand = Charge::all(['limit' => 1])->data[0]['source']['brand'];
				$address_zip_check = Charge::all(['limit' => 1])->data[0]['source']['address_zip_check'];
				$cvc_check = Charge::all(['limit' => 1])->data[0]['source']['cvc_check'];
				$zip = Charge::all(['limit' => 1])->data[0]['source']['address_zip'];
				$funding = Charge::all(['limit' => 1])->data[0]['source']['funding'];
				$status = Charge::all(['limit' => 1])->data[0]['status'];
				$failure_message = Charge::all(['limit' => 1])->data[0]['failure_message'];
				$risk_level = Charge::all(['limit' => 1])->data[0]['outcome']['risk_level'];
				
				$event = new OrderWasCreated($order, $this->basket);
				$event->attach(new RecordFailedPayment(
					$id,
					$name,
					$last4,
					$brand,
					$address_zip_check,
					$cvc_check,
					$zip,
					$funding,
					$status,
					$failure_message,
					$risk_level
				));
				$event->dispatch();
				
				$this->mail->to($this->config->get('company.email'), $this->config->get('mail.from.name'))->send(new AdminFailedPayment($order));

				$this->flash->addMessage('error', $e->getMessage());
				return $response->withRedirect($this->router->pathFor('order', compact('hash')));
			}
		} else {
			$this->flash->addMessage('error', $this->config->get('messages.recaptcha.error'));
			return $response->withRedirect($this->router->pathFor('getOrder'));
        }
    }

    protected function getQuantities($items) {
        $quantities = [];

        foreach($items as $item) {
            $quantities[] = ['quantity' => $item->quantity];
        }

        return $quantities;
    }

}