<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Core\Database;
use App\Models\User;
use DateTime;

class UserController extends Controller {
    public function register() {
        header('Content-Type: application/json');
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

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response = ['ok' => false, 'code' => 400,  'error' => "Email is not Valid"];
                echo json_encode($response);
                exit;
            }

            if(strlen($displayName) < 6) { 
                $response = ['ok' => false, 'code' => 401, 'error' => "Username must be 6 character or longer"];
                echo json_encode($response);
                exit;
            }

            if($password !== $confPass) { 
                $response = ['ok' => false, 'code' => 409,'error' => "Password did not match"];
                echo json_encode($response);
                exit;
            }

            if(!$accept){
                $response = [ 'ok' => false, 'code' => 403, 'error' => 'Please make sure to read and accept the terms and condition'];
                echo json_encode($response);
                exit;
            }
            
            $data = [
                'displayName'=> $displayName,
                'firstName'=> $firstName,
                'lastName'=> $lastName,
                'birthdate'=> $birthdate,
                'age'=> $age,
                'sex'=> $sex,
                'address'=> $address,
                'email'=> strtolower($email),
                'password'=>$password,
                'role'=> $role,
            ];
            $user = new User();

            if($user->findByEmail($data['email'])){
                $response = [ 'ok' => false, 'code' => 409, 'error' => 'Email is already registered' ];
                echo json_encode($response);
                exit;
            }

            $user->create($data); 
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Account successfully created!'];
            echo json_encode($response);
            exit;
        }
    }

    public function login() {
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $response = ['ok' => false, 'code' => 400, 'error' => "Email format not valid" ];
                echo json_encode($response);
                exit;
            }

            $user = new User();
            $userExists = $user->findByEmail($email);

            if(!$userExists) {
                $response = ['ok' => false, 'code' => 404, 'error' => 'Email is not yet registered' ];
                echo json_encode($response);
                exit;
            }

            if (!password_verify($password, $userExists['password'])) {
                $response = ['ok' => false, 'code' => 401, 'error' => 'Incorrect Password' ];
                echo json_encode($response);
                exit;
            }

            session_regenerate_id(true);
            $_SESSION['id'] = $userExists['id'];

            $response = ['ok' => true, 'code' => 200, 'message' => 'Logged in success!' ];
            echo json_encode($response);
        }
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();

        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie( session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        $this->redirect('/login');
        exit;
    }
}