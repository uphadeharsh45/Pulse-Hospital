<?php
require '../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
echo "Connection to database successfully";
// select a database
$db = $conn->project1;
echo "Database mydb selected";
$collection = $db->selectCollection('doctor');

// Error messages
$str1 = "Sorry, passwords did not match. Please enter information again.";
$str2 = "The ID you entered already exists. Please enter information again.";

// // Form inputs
$dname = $_POST['doctor_name'];
$doctor_id = $_POST['doctor_id'];
$pass = $_POST['confirm_password'];
$pass1 = $_POST['password'];
$phone_no = $_POST['phone_no'];
$qualification = $_POST['qualification'];
$phone_no = $_POST['phone_no'];
$hire_date = $_POST['hire_date'];
$specialization = $_POST['specialization'];



// Check if passwords match
if ($pass != $pass1) {
    echo $str1 . "<br>";
    header('location:doctor_inform.html');
    exit; // Stop further execution
}

// Check if patient ID already exists
$result = $collection->findOne(['doctor_id' => $doctor_id]);
if ($result) {
    echo $str2 . "<br>";
    header('location:doctor_inform.html');
    exit; // Stop further execution
}
//Insert new patient
$document = [
    'doctor_name' => $dname,
    'doctor_id' => $doctor_id,
    'doctor_password' => $pass,
    'confirm_password' => $pass1,
    'qualification' => $qualification,
    'phone_no' => $phone_no,
    'hire_date' => $hire_date,
    'specialization' => $specialization,
];
$collection->insertOne($document);

header('location:doc_register_succ.html');
?>
