<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Database;
use App\Models\User;
use DateTime;

class RegisterController extends Controller {
    public function index(){
        $data = [
            'title' => 'PCF:CareWise - Register Account'
        ];

        $this->view('/register', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $displayName = $_POST['displayName'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $birthdate = $_POST['birthdate'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $address = $_POST['address'] ?? '';
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';
            $confPass = $_POST['confPass'] ?? '';
            $accept = isset($_POST['accept']);
            $bdateFormat = new DateTime($birthdate);
            $today = new DateTime('today');
            $age = $bdateFormat -> diff($today) -> y;

            if(strlen($displayName) < 6) { 
                $response = ['ok' => false, 'error' => "Username must be 6 character or longer"];
                echo json_encode($response);
                exit;
            }

            if($password !== $confPass) { 
                $response = ['ok' => false, 'error' => "Password did not match"];
                echo json_encode($response);
                exit;
            }

            if (!$email) { 
                $response = ['ok' => false, 'error' => "Wrong email format"];
                echo json_encode($response);
                exit;
            }

            if(!$accept) { 
                $response = ['ok' => false, 'error' => "Please make sure to read and accept security privacy, terms and condition"];
                echo json_encode($response);
                exit;
            }
            
            $db = new Database();
            $userData = [
                'display_name'=> $displayName,
                'firstName'=> $firstName,
                'lastName'=> $lastName,
                'birthdate'=> $birthdate,
                'age'=> $age,
                'sex'=> $sex,
                'address'=> $address,
                'email'=> $email,
                'password'=> password_hash($password, PASSWORD_DEFAULT),
                'role'=> $role,
            ];
            $user = new User($db, $userData);
            $user->save(); 
            $this->redirect('/login');
        }
    }
}