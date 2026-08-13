<?php
namespace App\Services;

class ResendService {
    private $key;

    public function __construct(){
        $this->key = getenv('RESEND_KEY');
    }
    
    public function sendEmail(array $sent){
        if(!$this->key){
            return [ 'ok' => false, 'error' => 'missing key' ];
        }

        $data = [
            'from' => 'PCF:CareWise <onboarding@resend.dev>',
            'to' => $sent['to'],
            'subject' => $sent['subject'],
            'html' => $sent['html']
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.resend.com/emails');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->key,
            'Content-Type: application/json'
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        if($response === false){
            return [ 'ok' => false, 'error' => curl_error($ch)];
        }
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if(curl_errno($ch)){
            $error = curl_error($ch);
            curl_close($ch);
            return [ 'ok' => false, 'error' => $error];
        }

        curl_close($ch);
        return [ 'ok' => $status >= 200 && $status < 300, 'status' => $status, 'response' => json_decode($response, true) ];
    }
}
