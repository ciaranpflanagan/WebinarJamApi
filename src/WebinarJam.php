<?php

namespace ciaranpflanagan\WebinarJamApi;

use Exception;

class WebinarJam {

    protected $api_key;

    public function __construct(string $key) {
        $this->api_key = $key;
    }

    public function webinars () {

        $fields['api_key'] = $this->api_key;
        $fields_string  = http_build_query($fields);

        try {
            $ch = curl_init('https://api.webinarjam.com/webinarjam/webinars');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            return json_decode(curl_exec($ch), true);
        } catch (\Exception $e) {

            throw new Exception($e->getMessage(), 1);

        }
    }
}
