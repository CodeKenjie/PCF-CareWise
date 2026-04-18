<?php

namespace App\Controllers;

use App\Core\Controller;

class CareController extends Controller{
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF: CareWise - Care',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role']
        ];

        $this->view('pages/care', $data);
    }
}