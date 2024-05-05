<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            font-family: Montserrat;
            user-select: none;
        }

        nav {height: 11vh;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #F0F0F8;
}

nav img,
a {
    padding: 1rem;
    margin: 0 1rem;
}

nav a {
    text-decoration: none;
    background-color: #FF3444;
    color: white;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    font-weight: 800;
}

nav a:hover {
    color: #FF3444;
    background-color: #F0F0F8;
}

.container {
    display: flex;
    margin-left: 100px;
    padding: 20px;
}

table{
    /* margin: 5vh 80vh; */
    margin-left:auto;
    margin-right:auto;
    margin-top:3vh;
    border-color:white;
    border-spacing:0px;
}
th,td{
    font-size:2.5vh;
    padding:1vh 3vh;
}
th{
    background-color:#FF3444;
    color:white;
}
    </style>
</head>
<body>
<nav>
    <img src="Group 3.png" alt="Pulse Multispeciality">
    <a href="../home_pg/home.html">Home</a>
</nav>
<?php
session_start();
require '../../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
//echo "Connection to database successfully";
// select a database
$db = $conn->project1;
//echo " Database mydb selected";
$patientCollection = $db->selectCollection('patient');
$doctorCollection =$db->selectCollection('doctor');
$appointmentCollection =$db->selectCollection('appointment');
$userid = $_SESSION['id'];
$appp_date = $_POST['date'];

$doct=$doctorCollection->find(['_id'=>$userid]);
foreach($doct as $dt){
    $temp_id=$dt['doctor_id'];
}
$query = array(
    'doctor_id' => $temp_id,
    'app_date' => $appp_date
);
$appointments = $appointmentCollection->find($query);

echo '<table border="1"><tr><th>patient_name</th><th>appointment_time</th></tr>';

foreach ($appointments as $appointment) {
    $patient_id = $appointment['patient_id'];
    $patient_query = array('_id' => $patient_id);
    $patient =$patientCollection->findOne(['_id'=>$patient_id]);
    //echo $patient['pname']." "."<br>";
    echo '<tr><td>' . $patient['pname'] . '</td><td>' . $appointment['app_time'] . '</td></tr>';
}

echo '</table>';
?>

</body>
</html>