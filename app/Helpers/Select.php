<?php

namespace Base\Helpers;

use SameerShelavale\PhpCountriesArray\CountriesArray;

class Select {
	
    public function title() {
        return [
            'Mr',
            'Mrs',
            'Ms',
            'Miss'
        ];
    }

    public function country() {
        return CountriesArray::get();
    }

    public function department() {
        return [
            'General Enquiry',
            'Order Enquiry',
            'Shipping Enquiry',
            'Other'
        ];
    }
	
}
