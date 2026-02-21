<?php
require 'backend/db.php';

//to give manager a password
$name = 'Admin';
$email = 'jnjinasal@sample.com';
$contact = '09984567783';
$password = 'jnjinasal20';
$Date_hired = '2020-12-05';

$pass_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO Manager (Manager_name, Manager_email, Manager_contact_num, Password, Date_hired) VALUES (?,?,?,?,?)");
$stmt->bind_param('ississ',$id, $name, $email, $contact, $pass_hash, $Date_hired);
$stmt->execute();
$stmt->close();
