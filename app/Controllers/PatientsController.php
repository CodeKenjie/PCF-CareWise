<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Patient;
use DateTime;

class PatientsController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Patients',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role'],
        ];

        $this->view('/pages/patients', $data);
    }

    public function register(){
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
            $response = [ 'ok' => true, 'code' => 201, 'message' => 'Patient: ' . ucwords($lastName) . ', ' . ucwords($firstName) . ' is successfully registered'];
            echo json_encode($response);
        }
    }

    public function edit(){
        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $id = $input['id'] ?? '';
            $firstName = $input['firstName'] ?? '';
            $lastName = $input['lastName'] ?? '';
            $sex = $input['sex'] ?? '';
            $birthdate = $input['birthdate'] ?? '';
            $address = $input['address'] ?? '';
            $contact = $input['contact'] ?? '';
            $exContact = $this->notApplicable($input['exContact'] ?? '');
            $status = $input['status'] ?? '';
            $referredBy = $this->notApplicable($input['referredBy'] ?? '');
            $response = [];
 
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

            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Patient: ' . ucwords($lastName) . ', ' . ucwords($firstName) . ' update success' ];
            echo json_encode($response);
        }
    }

    public function delete($id) {
        header('Content-Type: application/json');
        $response = [];

        if($id === 'null'){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a Patient to delete'];
            echo json_encode($response);
            exit;
        }

        $patient = new Patient();
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
        $input = $_GET['search'] ?? '';
        $response = [];

        $results = (new Patient())->searchPatient($input);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $results ];
        echo json_encode($response);
    }

    public function getAll(){
        $response = [];
        header('Content-Type: application/json');
        $patients = new Patient();
        $patientsList = $patients->getAllPatients();

        $response = ['ok' => true, 'code' => 200, 'collection' => $patientsList ];
        echo json_encode($response);
    }

}