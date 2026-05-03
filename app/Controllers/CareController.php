<?php

namespace App\Controllers;

use App\Core\Controller;

class CareController extends Controller{
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF: CareWise - Care',
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/care', $data);
    }
}