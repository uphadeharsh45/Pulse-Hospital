<?php

use Twilio\Rest\Client;
session_start();
require '../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
//echo "Connection to database successfully";
// select a database
$db = $conn->project1;
//echo " Database mydb selected";
$patientCollection = $db->selectCollection('patient');
$doctorCollection =$db->selectCollection('doctor');
$appointmentCollection =$db->selectCollection('appointment');
if(isset($_SESSION['id'])) {
    $code = rand(10000,99999);
    $app_id = "pm_" . $code;
    $patient_id = $_SESSION['id'];
    $doc_name = $_POST['Doctor_name'];
    $Time_slot = $_POST['Time_slot'];
    $ph=$_POST['contact_no'];
    $appointment_date = date('Y-m-d', strtotime($_POST['appointment_date']));
    echo " line 20  ";
    // Find doctor by name
    $doctor = $doctorCollection->findOne(['doctor_name' => $doc_name]);
    echo $doc_name." "."<br>";
    var_dump($doctor);
    if($doctor) {
        $doctor_id = $doctor['doctor_id'];

        // Check if appointment exists
        $queryy = array(
            'doctor_id' => $doctor_id,
            'app_date' => $appointment_date,
            'app_time' => $Time_slot
        );
        $existing_appointment = $appointmentCollection->findOne($queryy);
        echo "  line 35 ";  
        if($existing_appointment) {
            $_SESSION['appointment_date'] = $appointment_date;
            $_SESSION['doctor_id'] = $doctor_id;
            header('location:sorry.php');
            exit;
        } else {
            // Insert new appointment
            $new_appointment = array(
                'patient_id' => $patient_id,
                'doctor_id' => $doctor_id,
                'app_date' => $appointment_date,
                'app_time' => $Time_slot,
                'app_id' => $app_id
            );

            echo "  line 50  ";
            $appointmentCollection->insertOne($new_appointment);
            $account_id="ACa005c39119264f59facf810b79193d80";
            $auth_token="4fa9ac7333805f25855ca2c7b88de535";
            $client=new Twilio\Rest\Client($account_id,$auth_token);
            $twilio_number="+18155724230";
            $client->messages->create(
                '+91 98904 57247',
                [
                    "from"=>$twilio_number,
                    "body"=>"Hello !, Your appointment with Dr.".$doc_name." has been booked on ".$appointment_date
                ]
                );
            header('location:appointment_confirm.html');
            exit;
        }
    }
}
echo "end";
?>
