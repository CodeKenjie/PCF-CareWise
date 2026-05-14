<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\CloudinaryService;

class CareController extends Controller{
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF: CareWise - Care',
            'displayName' => $user['display_name'],
            'avatar' => $user['avatar'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/care', $data);
    }
}