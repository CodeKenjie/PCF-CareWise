<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller {
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Schedule',
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/schedule', $data);
    }

    public function add(){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $date = $_POST['getDate'] ?? '';
            $time = $_POST['getTime'] ?? '';
            $frequency = $_POST['frequency'] ?? '';
            $firstName = $_POST['firstName'] ?? '';
            $lastName = $_POST['lastName'] ?? '';
            $contact = $_POST['contact'] ?? '';
            $exContact = $this->notApplicable($_POST['exContact'] ?? '');
            $schduledFor = $_POST['scheduledFor'] ?? '';
            $response = [];

            if(empty($date)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: invalid Date'];
                echo json_encode($response);
                exit;
            }

            if(empty($time)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: invalid Time'];
                echo json_encode($response);
                exit;
            }

            if(empty($frequency)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No frequency selected'];
                echo json_encode($response);
                exit;
            }

            if(empty($firstName)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter patients first name'];
                echo json_encode($response);
                exit;
            }

            if(empty($lastName)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter patients last name'];
                echo json_encode($response);
                exit;
            }

            if(empty($contact)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter patients contact'];
                echo json_encode($response);
                exit;
            }

            if(empty($schduledFor)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please state your reason for scheduling'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'date' => $date,
                'time' => $time,
                'frequency' => ucfirst($frequency),
                'firstName' => ucwords($firstName),
                'lastName' => ucwords($lastName),
                'contact' => $contact,
                'exContact' => $exContact,
                'scheduledFor' => $schduledFor
            ];

            $sched = new Schedule();
            $sched->createSchedule($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Schedule successfully added ' . $date ];
            echo json_encode($response);
        }

    }

    public function filter(){
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        $response = [];
        $date = $input['filter'] ?? '';

        if(empty($input['filter'])){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a date' ];
            echo json_encode($response);
            exit;
        }

        $shedules = (new Schedule())->getSchedByDate($date);

        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Patients scheduled on ' . $date, 'collection' => $shedules ];
        echo json_encode($response);
    }

    public function edit(){
        $this->editorOnly();

        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $id = $input['id'] ?? '';
            $time = $input['time'] ?? '';
            $frequency = $input['frequency'] ?? '';
            $scheduledFor = $input['schedFor'] ?? '';
            $response = [];

            if($id === 'null' || empty($id)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No Schedule Selected for update'];
                echo json_encode($response);
                exit;
            }

            if(empty($scheduledFor)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please fillup the reason for scheduling'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'time' => $time,
                'frequency' => $frequency,
                'scheduledFor' => $scheduledFor,
            ];

            $sched = new Schedule();
            $sched->editSchedule($data);

            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Schedule id:' . $id . 'is successfully updated'];
            echo json_encode($response);
        }
    }

    public function reschedule(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $id = $params['id'] ?? null;
            $date = $input['newDate'] ?? null;
            $response = [];

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No schedule Selected'];
                echo json_encode($response);
                exit;
            }

            if($date === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: date is empty!'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'date' => $date
            ];

            (new Schedule())->updateDate($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Rescheduled Successfully'];
            echo json_encode($response);
        }
    }

    public function delete(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $response = [];

        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a schedule to delete'];
            echo json_encode($response);
            exit;
        }

        $sched = new Schedule();
        $sched->deleteScheduleById($id);

        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Schedule: ' . $id . ' is successfully deleted'];
        echo json_encode($response);
    }

    public function today(){
        header('Content-Type: application/json');
        $response = []; 

        $sched = new Schedule();
        $scheduleToday = $sched->getSchedToday();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $scheduleToday ];
        echo json_encode($response);
    }

    public function all(){
        header('Content-Type: application/json');
        $response = []; 

        $sched = new Schedule();
        $schedules = $sched->getAll();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $schedules ];
        echo json_encode($response);
    }
}