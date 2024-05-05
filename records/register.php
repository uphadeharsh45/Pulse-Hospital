<?php
require '../../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
echo "Connection to database successfully";
// select a database
$db = $conn->project1;
echo "Database mydb selected";
$collection = $db->selectCollection('patient');

// Error messages
$str1 = "Sorry, passwords did not match. Please enter information again.";
$str2 = "The ID you entered already exists. Please enter information again.";

// // Form inputs
$pname = $_POST['patient_name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phone_no = $_POST['contact_no'];
$blood_group = $_POST['blood_group'];
$address = $_POST['address'];
$patient_id = $_POST['patient_id'];
$pass = $_POST['confirm_password'];
$pass1 = $_POST['password'];


// Check if passwords match
if ($pass != $pass1) {
    echo $str1 . "<br>";
    header('location:register_page.html?error=password');
    exit; // Stop further execution
}

// Check if patient ID already exists
$result = $collection->findOne(['patient_id' => $patient_id]);
if ($result) {
    echo $str2 . "<br>";
    header('location:register_page.html?error=id');
    exit; // Stop further execution
}

// Insert new patient
$document = [
    'pname' => $pname,
    'age' => $age,
    'gender' => $gender,
    'phone_no' => $phone_no,
    'blood_group' => $blood_group,
    'address' => $address,
    'patient_id' => $patient_id,
    'pass' => $pass
];
$collection->insertOne($document);

header('location:../register_successful.html');
?>
