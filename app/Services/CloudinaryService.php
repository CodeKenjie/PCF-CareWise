<?php
namespace App\Services;
use CURLFile;

class CloudinaryService {
    private $cloud;
    private $key;
    private $secret;

    public function __construct(){
        $this->cloud =  getenv('CLOUDINARY_NAME');
        $this->key =  getenv('CLOUDINARY_KEY');
        $this->secret =  getenv('CLOUDINARY_SECRET');

    }

    public function upload($filePath){
        $timestamp = time();
        $signature = sha1("timestamp=$timestamp" . $this->secret);
        $postFields = [
            'file' => new CURLFile($filePath),
            'api_key' => $this->key,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ];

        $url = "https://api.cloudinary.com/v1_1/{$this->cloud}/image/upload";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function cloudinaryURL($publicId, $transform = ''){
        return "https://res.cloudinary.com/{$this->cloud}/image/upload/$transform/$publicId";
    }
}