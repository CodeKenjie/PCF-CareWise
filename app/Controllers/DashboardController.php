<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;

class DashboardController extends Controller  {
    public function index() {
        if(!isset($_SESSION['id'])){
            $this->redirect('/login');
            exit;
        }

        $user = new User();
        $loggedUser = $user->findbyId($_SESSION['id']); 

        if(!$loggedUser){
            $this->redirect('/login');
            exit;
        }

        $data = [
            'title' => 'PCF:CareWise - Dashboard',
            'userId' => $loggedUser['id'],
            'userDisplayName' => $loggedUser['display_name'],
            'userRole' => $loggedUser['role']
        ];

        $this->view('pages/dashboard', $data);
    }
}