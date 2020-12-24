<?php

namespace Base\Plugins\CreatePDF;

use Base\Plugins\FPDF\FPDF;

class OrderInvoice extends FPDF {
	
	var $columns;
	var $format;
	var $angle = 0;

	protected function RoundedRect($x, $y, $w, $h, $r, $style = '') {
		$k = $this->k;
		$hp = $this->h;
		
		if($style == 'F') {
			$op='f';
		} elseif($style == 'FD' || $style == 'DF') {
			$op = 'B';
		} else {
			$op = 'S';
		}
		
		$MyArc = 4 / 3 * (sqrt(2) - 1);
		$this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
		$xc = $x + $w - $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
		$this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
		$xc = $x + $w - $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
		$xc = $x + $r;
		$yc = $y + $h - $r;
		$this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
		$this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
		$xc = $x + $r;
		$yc = $y + $r;
		$this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
		$this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
		$this->_out($op);
	}

	protected function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
		$h = $this->h;
		$this->_out(
			sprintf(
				'%.2F %.2F %.2F %.2F %.2F %.2F c', 
				$x1 * $this->k, 
				($h - $y1) * $this->k, 
				$x2 * $this->k, 
				($h - $y2) * $this->k, 
				$x3 * $this->k, 
				($h - $y3) * $this->k
			)
		);
	}
	
	protected function Rotate($angle, $x = -1, $y = -1) {
		if($x == -1) {
			$x = $this->x;
		}
		
		if($y == -1) {
			$y = $this->y;
		}
		
		if($this->angle != 0) {
			$this->_out('Q');
		}
		
		$this->angle = $angle;
		
		if($angle != 0) {
			$angle *= M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;
			$this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
		}
	}

	protected function _endpage() {
		if($this->angle != 0) {
			$this->angle = 0;
			$this->_out('Q');
		}
		
		parent::_endpage();
	}

	public function sizeOfText($text, $width) {
		$index = 0;
		$nb_lines = 0;
		$loop = true;
		
		while($loop) {
			$pos = strpos($text, "\n");
			
			if(!$pos) {
				$loop = false;
				$line = $text;
			} else {
				$line = substr($text, $index, $pos);
				$text = substr($text, $pos + 1);
			}
			
			$length = floor($this->GetStringWidth($line));
			$res = 1 + floor($length / $width) ;
			$nb_lines += $res;
		}
		
		return $nb_lines;
	}
	
	public function addWatermarkPaid($text) {
		$this->SetFont('Arial', '', 50);
		$this->SetTextColor(204, 204, 204);
		$this->Rotate(45, 55, 190);
		$this->Text(55, 190, $text);
		$this->Rotate(0);
		$this->SetTextColor(0, 0, 0);
	}
	
	public function addLogo($path) {
		$this->Image($path, 10, 6, 80);
		$this->Ln(20);
	}
	
	public function addCompanyAddress($details) {
		$r1 = $this->w - 80;
		$r2 = $r1 + 68;
		$y1 = 40;
		$this->SetXY($r1, $y1);
		$this->MultiCell(80, 4, $details);
	}
	
	public function addInvoiceNumber($wording, $num) {
		$r1  = $this->w - 80;
		$r2  = $r1 + 68;
		$y1  = 6;
		$y2  = $y1 + 2;
		$mid = ($r1 + $r2 ) / 2;

		$text  = $wording . $num;    
		$szfont = 12;
		$loop   = 0;

		while($loop == 0) {
		   $this->SetFont('Arial', 'B', $szfont);
		   $sz = $this->GetStringWidth($text);
		   if(($r1 + $sz) > $r2) {
			  $szfont --;
		   } else {
			  $loop ++;
		   }
		}

		$this->SetLineWidth(0.1);
		$this->SetFillColor(255);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
		$this->SetXY($r1 + 1, $y1 + 2);
		$this->Cell($r2 - $r1 - 1, 5, $text, 0, 0, 'C');
	}
	
	public function addCurrency($currency) {
		$r1 = $this->w - 80;
		$r2 = $r1 + 30;
		$y1 = 17;
		$y2 = $y1;
		$mid = $y1 + ($y2 / 2);
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1)/2 - 5, $y1 + 3);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 5, 'CURRENCY', 0, 0, 'C');
		$this->SetXY( $r1 + ($r2 - $r1)/2 - 5, $y1 + 9);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $currency, 0, 0, 'C');
	}
	
	public function addInvoiceDate($date) {
		$r1 = $this->w - 50;
		$r2 = $r1 + 38;
		$y1 = 17;
		$y2 = $y1 ;
		$mid = $y1 + ($y2 / 2);
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 5, 'INVOICE DATE', 0, 0, 'C');
		$this->SetXY( $r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $date, 0, 0, 'C');
	}

	public function addClient($ref) {
		$r1 = $this->w - 31;
		$r2 = $r1 + 19;
		$y1 = 17;
		$y2 = $y1;
		$mid = $y1 + ($y2 / 2);
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 5, 'AGENT ID', 0, 0, 'C');
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $ref, 0, 0, 'C');
	}

	public function addClientAddress($address) {
		$r1 = $this->w - 200;
		$r2 = $r1 + 68;
		$y1 = 40;
		$this->SetXY($r1, $y1);
		$this->MultiCell(80, 4, $address);
	}

	public function addPaidBy($mode) {
		$r1 = 10;
		$r2 = $r1 + 60;
		$y1 = 80;
		$y2 = $y1 + 10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5 , $y1 + 1);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 4, 'PAYMENT TYPE', 0, 0, 'C');
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $mode, 0, 0, 'C');
	}

	public function addPaymentDate($date) {
		$r1 = 80;
		$r2 = $r1 + 40;
		$y1 = 80;
		$y2 = $y1 + 10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(10, 4, 'PAYMENT DATE', 0, 0, 'C');
		$this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
		$this->SetFont('Arial', '', 10);
		$this->Cell(10, 5, $date, 0, 0, 'C');
	}

	public function addInvoiceTotal($total) {
		$this->SetFont('Arial', 'B', 10);
		$r1 = $this->w - 80;
		$r2 = $r1 + 70;
		$y1 = 80;
		$y2 = $y1+10;
		$mid = $y1 + (($y2 - $y1) / 2);
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
		$this->Line($r1, $mid, $r2, $mid);
		$this->SetXY($r1 + 16 , $y1 + 1);
		$this->Cell(40, 4, 'INVOICE TOTAL', '', '', 'C');
		$this->SetFont('Arial', '', 10);
		$this->SetXY($r1 + 16 , $y1 + 5);
		$this->Cell(40, 5, chr(163) . $total, '', '', 'C');
	}

	public function addCols($tab) {
		global $columns;

		$r1 = 10;
		$r2 = $this->w - ($r1 * 2) ;
		$y1 = 100;
		$y2 = $this->h - 50 - $y1;
		$this->SetXY($r1, $y1);
		$this->Rect($r1, $y1, $r2, $y2, 'D');
		$this->Line($r1, $y1 + 6, $r1 + $r2, $y1 + 6);
		$colX = $r1;
		$columns = $tab;
		
		while(list($lib, $pos) = each($tab)) {
			$this->SetXY($colX, $y1 + 2);
			$this->Cell($pos, 1, $lib, 0, 0, 'C');
			$colX += $pos;
			$this->Line($colX, $y1, $colX, $y1 + $y2);
		}
	}

	public function addLineFormat($tab) {
		global $format, $columns;

		while(list($lib, $pos) = each($columns)) {
			if(isset($tab[$lib])) {
				$format[$lib] = $tab[$lib];
			}
		}
	}

	public function lineVert($tab) {
		global $columns;

		reset($columns);
		$maxSize = 0;
		
		while(list($lib, $pos) = each($columns)) {
			$text = $tab[$lib];
			$longCell = $pos -2;
			$size = $this->sizeOfText($text, $longCell);
			
			if($size > $maxSize) {
				$maxSize = $size;
			}
		}
		
		return $maxSize;
	}

	public function addLine($line, $tab) {
		global $columns, $format;

		$order = 10;
		$maxSize = $line;

		reset($columns);
		
		while(list($lib, $pos) = each($columns)) {
			$longCell = $pos - 2;
			$text = $tab[$lib];
			$length = $this->GetStringWidth($text);
			$tailleTexte = $this->sizeOfText($text, $length);
			$formText = $format[$lib];
			$this->SetXY($order, $line - 1);
			$this->MultiCell($longCell, 4 , $text, 0, $formText);
			
			if($maxSize < ($this->GetY())) {
				$maxSize = $this->GetY() ;
			}
			
			$order += $pos;
		}
		
		return ($maxSize - $line);
	}
	
	public function addMessage($details) {
		$r1 = $this->w - 200;
		$r2 = $r1 + 120;
		$y1 = $this->h - 45;
		$y2 = $y1 + 15;
		$this->SetFont('Arial', 'I', 10);
		$this->SetXY($r1, $y1);
		$this->MultiCell(120, 4, $details);
	}
	
	public function addBottomSubTotal($shipping) {
		$r1 = $this->w - 70;
		$r2 = $r1 + 60;
		$y1 = $this->h - 48;
		$y2 = $y1 + 8;
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2);
		
		$this->SetFont('Arial', '', 10);
		$this->SetXY($r1, $y1 + 2);
		$this->Cell(32, 5, 'SUB TOTAL', 0, 0, 'R');
		
		$this->SetFont('Arial', '', 10);
		$this->SetXY($r1 + 28, $y1 + 2);
		$this->Cell(40, 5, chr(163) . $shipping, '', '', 'C');
	}
	
	public function addBottomShipping($shipping) {
		$r1 = $this->w - 70;
		$r2 = $r1 + 60;
		$y1 = $this->h - 38;
		$y2 = $y1 + 8;
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2);
		
		$this->SetFont('Arial', '', 10);
		$this->SetXY($r1, $y1 + 2);
		$this->Cell(32, 5, 'SHIPPING', 0, 0, 'R');
		
		$this->SetFont('Arial', '', 10);
		$this->SetXY($r1 + 28, $y1 + 2);
		$this->Cell(40, 5, chr(163) . $shipping, '', '', 'C');
	}
	
	public function addBottomTotal($total) {
		$r1 = $this->w - 70;
		$r2 = $r1 + 60;
		$y1 = $this->h - 28;
		$y2 = $y1 + 8;
		$this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
		$this->Line($r1 + 35, $y1, $r1 + 35, $y2);
		
		$this->SetFont('Arial', 'B', 10);
		$this->SetXY($r1, $y1 + 2);
		$this->Cell(32, 5, 'TOTAL AMOUNT', 0, 0, 'R');
		
		$this->SetFont('Arial', 'B', 10);
		$this->SetXY($r1 + 28, $y1 + 2);
		$this->Cell(40, 5, chr(163) . $total, '', '', 'C');
	}
	
}