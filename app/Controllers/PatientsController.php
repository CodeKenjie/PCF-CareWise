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
            $exContact = ', ' . strtolower($_POST['exContact'] ?? '');
            $referredBy = ucwords($_POST['referredBy'] ?? '');
            $bdayFormat = new DateTime($birthdate);
            $today = new DateTime('today');
            $age = $bdayFormat -> diff($today) -> y;
            $response = [];

            if(!isset($firstName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients First name' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($lastName)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients Last name' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($age)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients age' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($sex)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients sex' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($birthdate)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients birthdate' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($address)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients address' ];
                echo json_encode($response);
                exit;
            }

            if(!isset($contact)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Required: Patients contact' ];
                echo json_encode($response);
                exit;
            }


            if($exContact === 'na' || $exContact === 'n.a' || $exContact === 'n/a') {
                $exContact = '';
            }

            if($referredBy === 'Na' || $referredBy === 'N.a' || $exContact === 'N/a') {
                $referredBy = '';
            }

            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'age' => $age,
                'sex' => $sex,
                'birthdate' => $birthdate,
                'address' => $address,
                'contact' => $contact,
                'exContact' => $exContact,
                'referredBy' => $referredBy,
            ];

            $patient = new Patient();
            $patient->create($data);
            $response = [ 'ok' => true, 'code' => 201, 'message' => 'Patient: ' . ucwords($lastName) . ', ' . ucwords($firstName) . ' is successfully registered'];
            echo json_encode($response);
        }
    }

    public function get(){
        $patientId = $_GET['id'] ?? '';
        header('Content-Type: application/json');
        $response = [];
        $patient = new Patient();
        $patientInfo = $patient->getPatientById($patientId);
        
        $response = [ 'ok' => true, 'code' => 200, 'information' => $patientInfo ];
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