<?php

/**
 * Sample Profile Data
 */
class SampleProfile {
    function __construct() {
        /** @var Object profile A Random User Profile */
        $this->data = call_user_func(function () {
            $result = $this->curl_download('http://jsonplaceholder.typicode.com/users');
            $result = json_decode($result);
            $result = $result[rand(0, 9)];
            return $result;
        });
    }

    /**
     * Fetch API Data
     *
     * @param String $url
     * @return Array
     */
    function curl_download(String $url){
        if (!function_exists('curl_init')){
            die('Sorry cURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}
