<?php

namespace Base\Services\NumberVerify;

use Numverify\Api;
use Base\Constructor\BaseConstructor;

class NumberVerify extends BaseConstructor {

    public function verify($number) {
        $accessKey = $this->config->get('number.verify.api');
        $useHttps = $this->config->get('number.verify.https');

        $api = new Api($accessKey, $useHttps);

        $validatedPhoneNumber = $api->validatePhoneNumber($number);

        if($validatedPhoneNumber->isValid()) {
            $numberIsValid = [
                $validatedPhoneNumber->isValid(),
                $validatedPhoneNumber->getNumber(),
                $validatedPhoneNumber->getLocalFormat(),
                $validatedPhoneNumber->getInternationalFormat(),
                $validatedPhoneNumber->getCountryPrefix(),
                $validatedPhoneNumber->getCountryCode(),
                $validatedPhoneNumber->getCountryName(),
                $validatedPhoneNumber->getLocation(),
                $validatedPhoneNumber->getCarrier(),
                $validatedPhoneNumber->getLineType()
            ];

            return implode(', ', $numberIsValid);
        }

        return $number;
    }
	
}