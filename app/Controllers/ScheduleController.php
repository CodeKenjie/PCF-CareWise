<?php
namespace App\Controllers;
use App\Core\Controller;

class ScheduleController extends Controller {
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Schedule',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role']
        ];

        $this->view('pages/schedule', $data);
    }
}