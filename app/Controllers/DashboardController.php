<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Services\CloudinaryService;

class DashboardController extends Controller  {
    public function index() {
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Dashboard',
            'avatar' => $user['avatar'],
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/dashboard', $data);
    }
}