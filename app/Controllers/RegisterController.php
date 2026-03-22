<?php
namespace App\Controllers;
use App\Core\Controller;

class RegisterController extends Controller {
    public function index(){
        $data = [
            'title' => 'PCF:CareWise - Register Account'
        ];

        $this->view('/register', $data);
    }
}