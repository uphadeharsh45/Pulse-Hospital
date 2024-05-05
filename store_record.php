<?php
session_start();
require '../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
echo "Connection to database successfully";
// select a database
$db = $conn->project1;
echo "Database mydb selected";
$collection = $db->selectCollection('record');
$appointmentCollection = $db->selectCollection('appointment');
$doctorCollection = $db->selectCollection('doctor');
if(isset($_SESSION['id']))
{
    $doc_id=$_SESSION['id'];
    $dt=$doctorCollection->findOne(['_id'=>$doc_id]);
    $Time_slot =$_POST['Time_slot'];
    $appointment_date =$_POST['date'];
    $prescription=$_POST['prescription'];
    $feedback=$_POST['feedback'];
    var_dump($appointment_date);
    $appointment = $appointmentCollection->findOne(['doctor_id' => $dt['doctor_id'],'app_time'=>$Time_slot,'app_date'=>$appointment_date]);
    var_dump($appointment);
    if($appointment==NULL){
        header('location:record_new.html?error=notexist');
    }
    //echo $appointment['app_id']." "."<br>";
    else{
        $document = [
            'app_id' => $appointment['app_id'],
            'feedback' => $feedback,
            'prescription' => $prescription
            
        ];
        $collection->insertOne($document);
        
        header('location:record_stored.html'); 
    }
  

}

?>