<?php

namespace App\Controllers;
use App\Core\Controller;

class InventoryController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();
        $data = [
            'title' => 'PCF:CareWise - Inventory',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role']
        ];

        $this->view('pages/inventory', $data);
    }
}