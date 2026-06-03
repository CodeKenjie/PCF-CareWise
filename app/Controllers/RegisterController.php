<?php
namespace App\Controllers;
use App\Core\Controller;

class RegisterController extends Controller {
    public function index(){
        if(isset($_SESSION['id'])){
            $this->redirect('/dashboard');
            exit;
        }

        $data = [];

        $this->view('pages/register', $data);
    }
}