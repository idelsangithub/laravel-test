<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

trait ConnectionsTrait
{
    //conexion Easy
    public function easyMoney($data)
    {
        $url = 'http://localhost:3000/process';

        $response = Http::post($url, [
            'amount' => $data['amount'],
            'currency' => $data['currency']
        ]);
        return $response;
    }

    public function superWalletz($data){

        $url = 'http://localhost:3003/pay';
        $url_callback = 'https://laravel-test.local/webhooks/get-response';
        $response = Http::post($url, [
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'callback_url' => $url_callback
        ]);
        return $response;

    }

}
