<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\User;

class ProfileController extends Controller{
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - ' . $user['last_name'] . ', ' . $user['first_name'],
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'email' => $user['email'],
            'birthdate' => $user['birthdate'],
            'sex' => $user['sex'],
            'contact' => $user['contact'],
            'address' => $user['address'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN),
            'request' => filter_var($user['request'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/profile', $data);
    }

    public function requests(){
        $this->editorOnly();
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $response = [];
            $requester = (new User())->getAllRequest();

            $response = [ 'ok' => true, 'code' => 200, 'collection' => $requester ];
            echo json_encode($response);
        }
    }

    public function editors(){
        $this->editorOnly();
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $user = $this->getLoggedUser();
            $id = $user['id'];
            $response = [];
            $requester = (new User())->getAllEditor($id);

            $response = [ 'ok' => true, 'code' => 200, 'collection' => $requester ];
            echo json_encode($response);
        }
    }
}