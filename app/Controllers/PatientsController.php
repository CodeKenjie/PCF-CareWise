<?php
namespace App\Controllers;
use App\Core\Controller;

class PatientsController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Patients',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role'],
        ];

        $this->view('/pages/patients', $data);
    }
}