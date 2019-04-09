<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class CurlRequestDispatcher
{
    public function post($url, $data = [], array $headers = ["cache-control: no-cache", "content-type: application/json"])
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if (!empty($err) || $http_status == Response::HTTP_INTERNAL_SERVER_ERROR || $http_status == Response::HTTP_BAD_REQUEST) {
            echo($response);
            throw new RuntimeException($http_status . "/" . $response);
        } else {
            return json_decode($response);
        }
    }

    public function get($url, $headers = ["cache-control: no-cache"])
    {
        set_time_limit(0);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($err || $http_status == Response::HTTP_INTERNAL_SERVER_ERROR || $http_status == Response::HTTP_BAD_REQUEST) {
            throw new RuntimeException(json_decode($response));
        } else {
            return json_decode($response);
        }
    }

    public function delete($url, $headers)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($err || $http_status == Response::HTTP_INTERNAL_SERVER_ERROR || $http_status == Response::HTTP_BAD_REQUEST) {
            throw new RuntimeException(json_decode($response));
        } else {
            return json_decode($response);
        }
    }
}