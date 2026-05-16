<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Notification;
use App\Services\CloudinaryService;
use App\Models\User;
use App\Services\ResendService;

class UserController extends Controller {
    private function generateVerificationCode(){
        $min = pow(10, 6 - 1);
        $max = pow(10, 6) - 1;

        return random_int($min, $max);
    }

    public function register() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $displayName = $_POST['displayName'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ?? '';
            $password = $_POST['password'] ?? '';
            $position = $_POST['position'] ?? '';
            $confPass = $_POST['confPass'] ?? '';
            $accept = isset($_POST['accept']);
            $verificationCode = $this->generateVerificationCode();

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

            $send = [
                'to' => [ 'franciskenjiemaraasin@jrccmanila.edu.ph' ],
                'subject' => 'Your PCF: CareWise - Verification Code: ' . $verificationCode,
                'html' => "
                <h3>Welcome to Philadelphia Christcentered Fellowship Church</h3>
                <p>I would like for you to confirm your account. Here is your verification code:</p>
                <h4>Verification Code:</h4>
                <h1>{$verificationCode}</h1>"
            ];

            $result = (new ResendService())->sendEmail($send);
            
            if(!$result['ok']) {
                $response = [ 'ok' => false, 'code' => 500, 'error' => 'Cant send the email', 'result' => $result['error'] ?? $result['response'] ];
                echo json_encode($response);
                exit;
            }

            $data = [
                'displayName'=> $displayName,
                'firstName'=> ucwords($firstName),
                'lastName'=> ucwords($lastName),
                'sex'=> ucwords($sex),
                'position'=> $position,
                'isEditor'=> ($position ?? '') === 'ADMIN' ? 'true' : 'false',
                'email'=> strtolower($email),
                'password'=>$password,
                'code' => $verificationCode,
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
            $user = (new User())->findById($userExists['id']);
            $this->log('Logged In', $user['last_name'] . ', ' . $user['first_name'] . ' (' . $user['display_name'] . ') logged in');
            $response = ['ok' => true, 'code' => 200, 'message' => 'Logged in success!' ];
            echo json_encode($response);
        }
    }

    public function update(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user = $this->getLoggedUser();
            $id = (int) $user['id'] ?? null;
            $displayName = $_POST['displayName'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $position = $_POST['position'] ?? '';
            $birthdate = $this->notApplicable($_POST['birthdate'] ?? '');
            $contact = $this->notApplicable($_POST['contact'] ?? '');
            $address = $this->notApplicable($_POST['address'] ?? '');
            $response = [];
            $result = null;

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No logged user detected'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'displayName' => $displayName,
                'firstName' => ucwords($firstName),
                'lastName' => ucwords($lastName),
                'sex' => ucfirst($sex),
                'position' => $position,
                'birthdate' => $birthdate,
                'contact' => $contact,
                'address' => strtoupper($address)
            ];

            (new User())->updateUserInfo($data);
            $this->log('Updated Profile', 'updated his profile');
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Successfully updated your info'];
            echo json_encode($response);
        }
    }

    public function password(){
        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $user = $this->getLoggedUser();
            $id = $user['id'] ?? null;
            $password = $input['password'] ?? '';
            $newPassword = $input['newPassword'] ?? null;
            $confirmPassword = $input['confirmPassword'] ?? '';
            $response = [];
            if(is_null($id)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Error: Not authorized to change password'];
                echo json_encode($response);
                exit;
            }

            if(is_null($newPassword)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No new password was entered'];
                echo json_encode($response);
                exit;
            }

            if (!password_verify($password, $user['password'])) {
                $response = ['ok' => false, 'code' => 400, 'error' => 'Change failed: Wrong password' ];
                echo json_encode($response);
                exit;
            }

            if($newPassword !== $confirmPassword){
                $response = ['ok' => false, 'code' => 409,'error' => "Password did not match"];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'password' => $newPassword,
            ];

            (new User())->changePassword($data);
            $this->log('Update Profile', 'Changed Password');
            $response = ['ok' => true, 'code' => 200,'message' => "Password was changed successfully"];
            echo json_encode($response);
        }
    }

    public function avatar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user = $this->getLoggedUser();
            $id = $user['id'] ?? null;
            $avatar = $_FILES['avatar'] ?? null;
            $result = null;
            $response = [];

            if(is_null($id)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No patient Identified'];
                echo json_encode($response);
                exit;
            }

            if(is_null($avatar)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No image is identified'];
                echo json_encode($response);
                exit;
            }

            if($avatar && $avatar['error'] === UPLOAD_ERR_OK){
                $cloudinary = new CloudinaryService();
                $result = $cloudinary->upload($avatar['tmp_name']);

                if(!$result || !isset($result['secure_url'])){
                    $response = [ 'ok' => false, 'code' => 400, 'error' => 'upload Image failed'];
                    echo json_encode($response);
                    exit;
                }
            }

            $data = [
                'id' => $id,
                'avatar' => $result['secure_url']
            ];

            (new User())->uploadUserAvatar($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Successfully changed avatar'];
            echo json_encode($response);
        }
    }

    public function verify(){
        $input = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $user = $this->getLoggedUser();
            $id = $user['id'] ?? null;
            $code = (int) $input['code'] ?? null;
            $response = [];

            if(is_null($id)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No patient Identified'];
                echo json_encode($response);
                exit;
            }

            if(is_null($code)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No code was recieved'];
                echo json_encode($response);
                exit;
            }

            if($code !== $user['verification_code']){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Wrong Code: Please check your email for the correct Code'];
                echo json_encode($response);
                exit;
            }

            (new User())->verifyAccount($id);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Successfully verified account' ];
            echo json_encode($response);
        }
    }

    public function resend(){
        $user = $this->getLoggedUser();
        $response = [];

        if(!$user){
            $response = [ 'ok' => false, 'code' => 400, 'message' => 'Cant find the user logged' ];
            echo json_encode($response);
            exit;
        }

        $send = [
            'to' => ['franciskenjiemaraasin@jrccmanila.edu.ph'],
            'subject' => 'Your PCF: CareWise - Verification Code: ' . $user['verification_code'],
            'html' => "
            <h3>Welcome to Philadelphia Christcentered Fellowship Church</h3>
            <p>I would like for you to confirm your account. Here is your verification code:</p>
            <h4>Verification Code:</h4> 
            <h1>" . $user['verification_code'] . "</h1>"
        ];

        $result = (new ResendService())->sendEmail($send);

        if(!$result['ok']) {
            $response = [ 'ok' => false, 'code' => 500, 'error' => 'Cant send the email', 'result' => $result['error'] ?? $result['response'] ];
            echo json_encode($response);
            exit;
        }


        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Verification code sent, please check your email' ];
        echo json_encode($response);
    }

    public function changeRole(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $id = $params['id'] ?? null;
            $response = [];

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No account selected' ];
                echo json_encode($response);
                exit;
            }

            (new User())->changeRole($id);
            $user = $this->getLoggedUser();
            $selected = (new User())->findById($id);
            $this->log('User Role Change', $user['last_name'] . ', ' . $user['first_name'] . ' (' . $user['display_name'] . ') changed ' . $selected['last_name'] . ', ' . $selected['first_name'] . ' role');
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Role successfully changed' ];
            echo json_encode($response);
        }
    }

    public function request(){
        $this->VerifiedOnly();
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $user = $this->getLoggedUser();
            $id = $user['id'] ?? null;
            $notification = new Notification();

            $response = [];
            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No account selected' ];
                echo json_encode($response);
                exit;
            }

            (new User())->setRequestAccess($id);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Request access sent wait for response' ];
            echo json_encode($response);
        }
    }

    public function decline(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $id = $params['id'] ?? null;

            $response = [];
            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No account selected' ];
                echo json_encode($response);
                exit;
            }

            (new User())->setRequestAccess($id);
            $user = $this->getLoggedUser();
            $selected = (new User())->findById($id);
            $this->log('Decline Request', $user['last_name'] . ', ' . $user['first_name'] . ' (' . $user['display_name'] . ') declined ' . $selected['last_name'] . ', ' . $selected['first_name'] . ' request for editor role');
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Request access sent wait for response' ];
            echo json_encode($response);
        }
    }

    public function logout() {
        $user = $this->getLoggedUser();
        $this->log('Logged Out', $user['last_name'] . ', ' . $user['first_name'] . ' (' . $user['display_name'] . ') logged in');

        $_SESSION = [];
        session_destroy();

        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie( session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        $this->redirect('/login');
        exit;
    }

    public function delete() {
        $user = $this->getLoggedUser();
        $id = $user['id'] ?? null;
        $response = [];

        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Can\'t find user id '];
            echo json_encode($response);
            exit;
        }

        (new User())->deleteAccount($id);

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