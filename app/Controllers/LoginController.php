<?php
namespace App\Controllers;
use App\Core\Controller;

class LoginController extends Controller {
    public function index() {
        if(isset($_SESSION['id'])){
            $this->redirect('/dashboard');
            exit;
        }

        $data = [
            'title' => 'PCF:CareWise - Login Account' 
        ];
        
        $this->view('pages/login', $data);
    }
}