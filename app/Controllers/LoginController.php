<?php
namespace App\Controllers;
use App\Core\Controller;

class LoginController extends Controller {
    public function index() {
        $data = [
            'title' => 'PCF:CareWise - Login Account'
        ];
        
        $this->view('/login', $data);
    }
}