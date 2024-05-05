<?php 
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
//echo " collection selected";
$cat=$_POST['category'];
$id=$_POST['id'];
$pass=$_POST['password'];
if($cat=="who_are_you"){
    
    header('Location: login.html');
}
if($cat=="Patient"){
    $patient_id=$id;
    $password=$pass;
    $patient = $patientCollection->findOne(['patient_id' => $patient_id]);
    if($patient) {
        if($patient['pass']==$pass){
            echo "oihfiwrfbf";
            $_SESSION['id'] = $patient['_id']; // Assuming patient_id is unique, you might want to change this based on your MongoDB schema
        header('Location: patient_login.html');
        exit;
        }
        else {
            header('Location: login.html?error=invalid');
            exit;
         }
    }
    else {
        header('Location: login.html?error=invalid');
        exit;
     }
  } 
 elseif($cat=="Doctor") {
    $doctor_id=$id;
    $doctor_password=$pass;
    $doctor = $doctorCollection->findOne(['doctor_id' => $doctor_id]);
    if($doctor) {
        if($doctor['doctor_password']==$pass){
            $_SESSION['id'] = $doctor['_id']; // Assuming patient_id is unique, you might want to change this based on your MongoDB schema
        header('Location: doctor_login.html');
        exit;
        }
        else {
            header('Location: login.html?error=invalid');
            exit;
         }
    } else {
        header('Location: login.html?error=invalid');
        exit;
    }
}
?>
