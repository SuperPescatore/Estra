<?php
// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "server";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Recupera i dati dalla richiesta POST
$userId = $_POST['userId'];
$newValue = $_POST['newValue'];

// Ottieni il nome del campo da aggiornare
$fieldToUpdate = '';
if ($userId === 'Username') {
    $fieldToUpdate = 'user';
} else
if ($userId === 'Password') {
    $fieldToUpdate = 'password';
}

// Esegui l'aggiornamento dei dati nel database
$sql = "UPDATE admin_user SET $fieldToUpdate = '$newValue' WHERE user = '$userId'";
if ($conn->query($sql) === TRUE) {
    $response = array("success" => true);
    echo json_encode($response);
} else {
    $response = array("success" => false);
    echo json_encode($response);
}

$conn->close();
?>
