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
            $alias = $_POST['alias'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $birthdate = $_POST['birthdate'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $address = $_POST['address'] ?? '';
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '';
            $confPass = $_POST['conf_password'] ?? '';
            $accept = isset($_POST['accept']);
            $bdateFormat = new DateTime($birthdate);
            $today = new DateTime('today');
            $age = $bdateFormat -> diff($today) -> y;

            if(strlen($alias) < 6) { 
                $response = ['ok' => false, 'error' => "Username must be 6 character or longer"];
                return json_encode($response);
            }

            if($password !== $confPass) { 
                $response = ['ok' => false, 'error' => "Password did not match"];
                return json_encode($response);
            }

            if (!$email) { 
                $response = ['ok' => false, 'error' => "Wrong email format"];
                return json_encode($response);
            }

            if(!$accept) { 
                $response = ['ok' => false, 'error' => "Please make sure to read and accept security privacy, terms and condition"];
                return json_encode($response);
            }
            
            $db = new Database();
            $userData = [
                'alias'=> $alias,
                'name'=> "{$lastName}, {$firstName}",
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
        }
    }
}