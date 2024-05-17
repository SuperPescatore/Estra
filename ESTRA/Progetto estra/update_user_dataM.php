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
if (filter_var($userId, FILTER_VALIDATE_IP)) {
    $fieldToUpdate = 'Ip_address';
} else {
    $fieldToUpdate = 'OS';
}

// Esegui l'aggiornamento dei dati nel database
$sql = "UPDATE info_controll SET $fieldToUpdate = '$newValue' WHERE Host_name = '$userId'";
if ($conn->query($sql) === TRUE) {
    $response = array("success" => true);
    echo json_encode($response);
} else {
    $response = array("success" => false);
    echo json_encode($response);
}

$conn->close();
?>
