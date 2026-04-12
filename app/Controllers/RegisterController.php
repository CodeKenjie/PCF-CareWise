<?php
namespace App\Controllers;
use App\Core\Controller;

class RegisterController extends Controller {
    public function index(){
        if(isset($_SESSION['id'])){
            $this->redirect('/dashboard');
            exit;
        }

        $data = [
            'title' => 'PCF:CareWise - Register Account'
        ];

        $this->view('pages/register', $data);
    }
}