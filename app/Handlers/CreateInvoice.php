<?php

namespace Base\Handlers;

use Base\Plugins\CreatePDF\OrderInvoice;
use Base\Handlers\Contracts\HandlerInterface;

class CreateInvoice implements HandlerInterface {
	
    public function handle($event) {
		$order = $event->order;
		$payment = $order->payment->where('failed', false)->first();
		$currency = getenv('STRIPE_CURRENCY', 'GBP');
		
        $pdf = new OrderInvoice('P', 'mm', 'A4');
		$pdf->AddPage();
		$pdf->addLogo();
		$pdf->addInvoiceNumber('INVOICE ', $order->order_id);
		$pdf->addWatermarkPaid('**Invoice Paid**');
		$pdf->addCurrency($currency);
		$pdf->addInvoiceDate(date('jS F, Y', strtotime($order->created_at)));
		$pdf->addClientAddress(
			strtoupper($order->user->customer->getFullName()) . "\n" . 
			strtoupper($order->user->address->address) . "\n" . 
			strtoupper($order->user->address->city) . "\n" . 
			strtoupper($order->user->address->county) . "\n" . 
			strtoupper($order->user->address->postcode) . "\n" . 
			strtoupper($order->user->address->country)
		);
		$pdf->addCompanyAddress(
			strtoupper(getenv('COMPANY_NAME')) . "\n" . 
			strtoupper(getenv('COMPANY_ADDRESS_1')) . "\n" . 
			strtoupper(getenv('COMPANY_ADDRESS_2')) . "\n" . 
			strtoupper(getenv('COMPANY_ADDRESS_3')) . "\n" . 
			strtoupper(getenv('COMPANY_ADDRESS_4')) . "\n" . 
			strtolower(getenv('COMPANY_WEBSITE')) . "\n" . 
			strtolower(getenv('COMPANY_EMAIL'))
		);
		$pdf->addPaidBy($payment->brand . ' ' . $payment->card);
		$pdf->addPaymentDate(date('jS F Y', strtotime($payment->created_at)));
		$pdf->addInvoiceTotal(number_format($order->total, 2) . ' (' . $currency . ')');
		$cols = [
			'ORDER ID'     => 40,
			'DESCRIPTION'  => 60,
			'QTY'     	   => 15,
			'PRICE'        => 25,
			'DISCOUNT'     => 25,
			'TOTAL'        => 25
		];

		$pdf->addCols($cols);

		$cols = [
			'ORDER ID'     => 'C',
			'DESCRIPTION'  => 'L',
			'QTY'          => 'C',
			'PRICE'        => 'C',
			'DISCOUNT'     => 'C',
			'TOTAL'        => 'C'
		];

		$pdf->addLineFormat($cols);
		
		$y = 105;
		
		foreach($order->products as $product) {
			$dicount = 0;

			$line = [
				'ORDER ID'     => $order->order_id,
				'DESCRIPTION'  => $product->title,
				'QTY'          => $product->pivot->quantity,
				'PRICE' 	   => number_format($product->price * $product->pivot->quantity, 2),
				'DISCOUNT' 	   => number_format($dicount * $product->pivot->quantity, 2),
				'TOTAL'        => number_format($product->price * $product->pivot->quantity, 2)
			];

			$sizes = $pdf->addLine($y += 5, $line);
		}

		$pdf->addMessage('Thank you for choosing ' . getenv('COMPANY_NAME') . "\n\nFor our latest promotions visit our website " . getenv('COMPANY_WEBSITE'));
		$pdf->addBottomSubTotal(number_format($order->sub_total, 2));
		$pdf->addBottomShipping(number_format($order->shipping, 2));
		$pdf->addBottomTotal(number_format($order->total, 2));
		
		$folder = $order->order_id;
		mkdir(__DIR__ . getenv('INVOICE_PATH') . $folder, 0755);
		$file = $order->order_id;
		$path = __DIR__ . getenv('INVOICE_PATH') . $folder . DIRECTORY_SEPARATOR . $file . '-I.pdf';
		
		$pdf->Output('F', $path, false);
	}
	
}