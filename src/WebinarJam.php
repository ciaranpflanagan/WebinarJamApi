<?php

namespace ciaranpflanagan\WebinarJamApi;

use Exception;

class WebinarJam {

    protected $api_key;
    protected $webinar;

    public function __construct(string $key) {
        $this->api_key = $key;
    }

    /**
     * Returns a list of all webinars
     *
     * @return mixed
     */
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

    /**
     * Returns details about one individual webinar
     *
     * @return mixed
     */
    public function webinarDetails (int $webinar_id) {
        if (!$webinar_id) throw new Exception('Webinar ID required', 1);

        $fields['api_key'] = $this->api_key;
        $fields['webinar_id'] = $webinar_id;
        $fields_string  = http_build_query($fields);

        try {
            $ch = curl_init('https://api.webinarjam.com/webinarjam/webinar');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $output = json_decode(curl_exec($ch), true);
            if ($output['status'] !== 'error') $this->webinar = $output['webinar'];

            return $output;
        } catch (\Exception $e) {

            throw new Exception($e->getMessage(), 1);
        }
    }

    /**
     * Registers a person to a webinar
     *
     * @return mixed
     */
    public function register (
        int $webinar_id,
        string $first_name,
        string $last_name = null,
        string $email,
        int $schedule,
        string $ip_address = null,
        string $phone_country_code = null,
        string $phone = null
    ) {
        $fields['api_key'] = $this->api_key;
        
        // Required fields
        $fields['webinar_id'] = $webinar_id;
        $fields['first_name'] = $first_name;
        $fields['email'] = $email;
        $fields['schedule'] = $schedule;

        // Optional fields
        if ($last_name !== null) $fields['last_name'] = $last_name;
        if ($ip_address !== null) $fields['ip_address'] = $ip_address;
        if ($phone_country_code !== null) $fields['phone_country_code'] = $phone_country_code;
        if ($phone !== null) $fields['phone'] = $phone;

        $fields_string  = http_build_query($fields);

        try {
            $ch = curl_init('https://api.webinarjam.com/webinarjam/webinar');
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

    /**
     * Returns the webinar schedule
     *
     * @param integer $webinar_id
     *
     * @return array
     */
    public function webinarSchedule (int $webinar_id = null) :array {
        if ($webinar_id !== null) {
            // Get schedule from webinar details
            $webinar = (new self($this->api_key))->webinarDetails($webinar_id);

            return $webinar['webinar']['schedules'];
        } else {
            // Check stored webinar
            return (isset($this->webinar)) ? $this->webinar['schedules'] : array() ;
        }
    }
}
