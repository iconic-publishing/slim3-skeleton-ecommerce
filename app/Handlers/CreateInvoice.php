<?php

namespace Base\Handlers;

use Base\Plugins\CreatePDF\OrderInvoice;
use Base\Handlers\Contracts\HandlerInterface;

class CreateInvoice implements HandlerInterface {
	
    public function handle($event) {
		$order = $event->order;
		$payment = $order->payment->where('failed', false)->first();
		
        $pdf = new OrderInvoice('P', 'mm', 'A4');
		$pdf->AddPage();
		$pdf->addLogo();
		$pdf->addInvoiceNumber('INVOICE ', $order->order_id);
		$pdf->addWatermarkPaid('**Invoice Paid**');
		$pdf->addCurrency('GBP');
		$pdf->addInvoiceDate(date('jS F, Y', strtotime($order->created_at)));
		$pdf->addClientAddress(
			$order->user->customer->getFullName() | upper . "\n" . 
			$order->user->address->address . "\n" . 
			$order->user->address->city . "\n" . 
			$order->user->address->county . "\n" . 
			$order->user->address->postcode . "\n" . 
			strtoupper($order->user->address->country)
		);
		$pdf->addCompanyAddress(
			getenv('INVOICE_NAME') . "\n" . 
			getenv('INVOICE_ADDRESS_1') . "\n" . 
			getenv('INVOICE_ADDRESS_2') . "\n" . 
			strtoupper(getenv('INVOICE_ADDRESS_3')) . "\n" . 
			strtoupper(getenv('INVOICE_ADDRESS_4')) . "\n" . 
			getenv('COMPANY_WEBSITE') . "\n" . 
			getenv('INVOICE_EMAIL')
		);
		$pdf->addPaidBy($payment->brand . ' ' . $payment->card);
		$pdf->addPaymentDate(date('jS F Y', strtotime($payment->created_at)));
		$pdf->addInvoiceTotal(number_format($order->total, 2) . ' (GBP)');
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
			$dicount = $product->normal_price - $product->sale_price;

			$line = [
				'ORDER ID'     => $order->order_id,
				'DESCRIPTION'  => $product->title,
				'QTY'          => $product->pivot->quantity,
				'PRICE' 	   => number_format($product->normal_price * $product->pivot->quantity, 2),
				'DISCOUNT' 	   => number_format($dicount * $product->pivot->quantity, 2),
				'TOTAL'        => number_format($product->sale_price * $product->pivot->quantity, 2)
			];

			$sizes = $pdf->addLine($y +=5, $line);
		}

		$pdf->addMessage('Thank you for choosing ' . getenv('COMPANY_NAME') . "\n\nFor our latest promotions visit our website " . getenv('COMPANY_WEBSITE'));
		$pdf->addBottomSubTotal(number_format($order->sub_total, 2));
		$pdf->addBottomShipping(number_format($order->shipping, 2));
		$pdf->addBottomTotal(number_format($order->total, 2));
		
		$folder = str_replace('CGB-', '', $order->order_id);
		$file = str_replace('CGB-', '', $order->order_id);
		$path = __DIR__ . '/../../public_html/layouts/_uploads/' . $folder . DIRECTORY_SEPARATOR . $file . '-I.pdf';
		
		$pdf->Output('F', $path, false);
	}
	
}