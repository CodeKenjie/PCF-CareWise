<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Notification;
use App\Models\Patient;
use App\Services\CloudinaryService;

class PatientsController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Patients',
            'avatar' => $user['avatar'],
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('/pages/patients', $data);
    }

    public function register(){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $sex = $_POST['sex'] ?? '';
            $birthdate = $_POST['birthdate'] ?? '';
            $address = $_POST['address'] ?? '';
            $contact = $_POST['contact'] ?? '';
            $exContact = $this->notApplicable($_POST['exContact'] ?? '');
            $status = $_POST['status'] ?? '';
            $referredBy = $this->notApplicable($_POST['referredBy'] ?? '');
            $response = [];
            $result = null;

            if(empty($firstName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients First name' ];
                echo json_encode($response);
                exit;
            }

            if(empty($lastName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients Last name' ];
                echo json_encode($response);
                exit;
            }

            if(empty($sex)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients sex' ];
                echo json_encode($response);
                exit;
            }

            if(empty($birthdate)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients birthdate' ];
                echo json_encode($response);
                exit;
            }

            if(empty($address)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients address' ];
                echo json_encode($response);
                exit;
            }

            if(empty($contact)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients contact' ];
                echo json_encode($response);
                exit;
            }

            if(empty($status)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients status' ];
                echo json_encode($response);
                exit;
            }

            $data = [
                'firstName' => ucwords($firstName),
                'lastName' => ucwords($lastName),
                'sex' => ucwords($sex),
                'birthdate' => $birthdate,
                'address' => ucwords($address),
                'contact' => $contact,
                'extraContact' =>$exContact,
                'status' => ucwords($status),
                'referredBy' => ucwords($referredBy),
            ];

            $patient = new Patient();
            $patient->create($data);
            $this->log('Added Patient', 'added' . ucwords($lastName) . ', ' . ucwords($firstName));
            $response = [ 'ok' => true, 'code' => 201, 'message' => 'Patient: ' . ucwords($lastName) . ', ' . ucwords($firstName) . ' is successfully registered'];
            echo json_encode($response);
        }
    }

    public function edit(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $params['id'] ?? '';
            $firstName = $_POST['updateFirstName'] ?? '';
            $lastName = $_POST['updateLastName'] ?? '';
            $sex = $_POST['updateSex'] ?? '';
            $birthdate = $_POST['updateBirthdate'] ?? '';
            $address = $_POST['updateAddress'] ?? '';
            $contact = $_POST['updateContact'] ?? '';
            $exContact = $this->notApplicable($_POST['updateExContact'] ?? '');
            $status = $_POST['updateStatus'] ?? '';
            $referredBy = $this->notApplicable($_POST['updateReferredBy'] ?? '');
            $response = [];
            $result = null;
 
            if(empty($firstName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients First name' ];
                echo json_encode($response);
                exit;
            }

            if(empty($lastName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients Last name' ];
                echo json_encode($response);
                exit;
            }

            if(empty($sex)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients sex' ];
                echo json_encode($response);
                exit;
            }

            if(empty($birthdate)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients birthdate' ];
                echo json_encode($response);
                exit;
            }

            if(empty($address)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients address' ];
                echo json_encode($response);
                exit;
            }

            if(empty($contact)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients contact' ];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'firstName' => ucwords($firstName),
                'lastName' => ucwords($lastName),
                'sex' => ucwords($sex),
                'birthdate' => $birthdate,
                'address' => ucwords($address),
                'contact' => $contact,
                'extraContact' =>$exContact,
                'status' => ucwords($status),
                'referredBy' => ucwords($referredBy),
            ];

            $patient = new Patient();
            $patient->updatePatient($data);
            $this->log('Edited Patient', ucwords($lastName) . ', ' . ucwords($firstName) . ' has been edited' );
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Patient: ' . ucwords($lastName) . ', ' . ucwords($firstName) . ' update success' ];
            echo json_encode($response);
        }
    }
    
    public function avatar(array $params){
        $this->editorOnly();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $params['id'] ?? null;
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

            (new Patient())->uploadPaitentAvatar($data);
            $patient = (new Patient())->getPatientById($id);
            $this->log('Edited Patient', ucwords($patient['last_name']) . ', ' . ucwords($patient['first_name']) . ' has been edited' );
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Successfully changed avatar'];
            echo json_encode($response);
        }
    }

    public function delete(array $params) {
        $this->editorOnly();

        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $response = [];
        if($id === 'null'){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a Patient to delete'];
            echo json_encode($response);
            exit;
        }

        $patient = new Patient();

        $selected = $patient->getPatientById($id);
        $this->log('Deleted Patient', ucwords($selected['last_name']) . ', ' . ucwords($selected['first_name']) . ' has been deleted' );

        $patient->deletePatient($id);
        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Patient successfully deleted' ];
        echo json_encode($response);
    }

    public function sort(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $response = [];
            $order = $_GET['order'] ?? 'id';
            $direction = $_GET['direction'] ?? 'ASC';
            $allowedSort = ['id', 'last_name', 'age'];

            if(!in_array($order, $allowedSort)) {
                $order = 'id';
            }

            $patients = new Patient();
            $sorted = $patients->sortPatients($order, $direction);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Patients sorted by: '. ucwords($order) . ' direction: ' . ucfirst($direction), 'collection' => $sorted ];
            echo json_encode($response);
        }
    }

    public function search(){
        header('Content-Type: application/json');
        $input = $_GET['search'] ?? '';
        $response = [];

        $results = (new Patient())->searchPatient($input);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $results ];
        echo json_encode($response);
    }

    public function dropdown(){
        header('Content-Type: application/json');
        $input = $_GET['search'] ?? '';
        $response = [];

        $results = (new Patient())->patientDrop($input);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $results ];
        echo json_encode($response);
    }

    public function new(){
        header('Content-Type: application/json');
        $user = $this->getLoggedUser();
        $id = $user['id'] ?? null;
        $response = [];
        $patients = new Patient();
        $newPatients = $patients->getNewPatients();
        $notificationModel = new Notification();

        foreach($newPatients as $patient){
            $requirements = [
                'userId' => $id,
                'referenceId' => $patient['id'],
                'key' => 'newPatient',
            ];

            if(!$notificationModel->doesExist($requirements)) {
                $notification = [
                    'userId' => $id,
                    'type' => 'reminder',
                    'key' => 'newPatient',
                    'referenceId' => $patient['id'],
                    'title' => 'There\'s A New Patient',
                    'content' => $patient['last_name'] . ', ' . $patient['first_name'] . ' was added to the patients',
                    'link' => '/patients'
                ];

                $notificationModel->createNotification($notification);
            }

        }

        $response = ['ok' => true, 'code' => 200, 'collection' => $newPatients ];
        echo json_encode($response);
    }

    public function status(){
        header('Content-Type: application/json');
        $response = [];
        $patients = new Patient();
        $status = $patients->getPatientStatus();

        $response = ['ok' => true, 'code' => 200, 'collection' => $status ];
        echo json_encode($response);
    }

    public function getAll(){
        header('Content-Type: application/json');
        $response = [];
        $patients = new Patient();
        $patientsList = $patients->getAllPatients();

        $response = ['ok' => true, 'code' => 200, 'collection' => $patientsList ];
        echo json_encode($response);
    }

}