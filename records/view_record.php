<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table{
            margin-left:100px;
        }
*{
    margin: 0;
    padding: 0;
    font-family: Montserrat;
    user-select: none;
}

nav {height: 10vh;
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
.full{
    border: 0.5vh solid #FF3444;
    border-radius: 4vh;
    font-size: 5vh;
    font-weight: 600;
    width: 75vh;
    text-align: center;
    padding: 6vh;
    align-self: center;
    margin-left: auto;
    margin-right: auto;
    margin-top: 10vh;
    background-color: #F0F0F8;
}
    </style>
</head>
<body>
<nav>
        <img src="Group 3.png" alt="Pulse Multispeciality">
        <a href="../home_pg/home.html">Home</a>
</nav>
<br>;
<br>;
<?php
session_start();
require '../../vendor/autoload.php';
// connect to mongodb
$conn= new MongoDB\Client;
//echo "Connection to database successfully";
// select a database
$db = $conn->project1;
//echo "Database mydb selected";
$rcollection = $db->selectCollection('record');
$dcollection = $db->selectCollection('doctor');
$pcollection = $db->selectCollection('patient');
$appointmentCollection = $db->selectCollection('appointment');

$patient_id=$_SESSION['id'];
$appointment = $appointmentCollection->find(['patient_id'=>$patient_id  ]);
echo '<table border="1"><tr><th>App date</th><th>App Time</th><th>Doctor name</th><th>View details</th></tr>';
foreach($appointment as $appoint){

    $appointment_id=$appoint['app_id'];
    $result=$rcollection->findone(['app_id'=>$appointment_id]);
    $dname=$dcollection->findOne(['doctor_id'=>$appoint['doctor_id']]);
    if($result) echo '<tr><td>'. $appoint['app_date'] ." ". '</td><td>'. $appoint['app_time'] ." ". '</td><td>'.  $dname['doctor_name'] ." ".'</td><td>
    <a href="appointment.php?uname=' . $result['app_id'] . ' ">View
    Details</a></td></tr>';
}

?>

</body>
</html>





