<!DOCTYPE html>
<html>
<head>
<title>Gestione server e Report di attività</title>
<style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        .highlight {
            background-color: yellow;
        }

        .editable {
            cursor: pointer;
        }

        .modified {
            background-color: lightblue;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .logout-form {
            margin-top: 20px;
        }

        header {
            background-color: #1e90ff;
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            height: 70px;
            border-radius: 20px;
            overflow: hidden;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            padding: 0 50px;
            /* sposta la navbar e il tasto cerca più verso sinistra */
            margin-left: 20px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .menu-items {
            display: flex;
        }

        .dropdown {
            position: relative;
            margin: 0 10px;
        }

        .dropbtn {
            background-color: transparent;
            border: none;
            font-size: 18px;
            color: #fff;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            z-index: 1;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 10px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            color: #282828;
            padding: 8px 0;
            text-decoration: none;
            border-bottom: 1px solid #ddd;
        }

        .dropdown-content a:hover {
            background-color: #1e90ff;
            color: #fff;
        }

        .account-cart {
            display: flex;
            align-items: center;
        }

        .account-cart img {
            height: 25px;
            margin-left: 20px;
            cursor: pointer;
        }

        h1 {
            margin-top: 20px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            margin-top: -250px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 300px;
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #1e90ff;
            color: #fff;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 5px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
        }
        
        .popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.1);
        }
        
        .popup h2 {
            margin-top: 0;
            color: #1e90ff;
        }
        
        .popup p {
            margin-bottom: 20px;
        }
        
        .popup button {
            background-color: #1e90ff;
            color: #fff;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
        }
    

        input[type="text"],
        input[type="password"],
        select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 300px;
            margin-bottom: 10px;
        }

      

</style>
<script>
 // Mostra il popup con il titolo e il messaggio specificati
function showPopup(title, message) {
    document.getElementById("popup-title").textContent = title;
    document.getElementById("popup-message").textContent = message;
    document.getElementById("overlay").style.display = "flex";

    // Aggiungi l'evento di click al pulsante di chiusura del popup
document.getElementById("popup-close").addEventListener("click", closePopup);
}

// Chiudi il popup
function closePopup() {
    document.getElementById("overlay").style.display = "none";
}


</script>
</head>
<body>
<header>
        <nav class="navbar">
            <div class="logo">
                <a href="HomeAdmin.php">
                    <img src="Logo Estra.jpg" alt="Logo">
                </a>
            </div>
            <div class="menu-items">
                <div class="dropdown">
                    <a class="dropbtn" href="HomeAdmin.php">Home</a>
                </div>
                <div class="dropdown">
                    <a class="dropbtn" href="Prodotti.html">Server</a>
                    <div class="dropdown-content">
                        <a href="aggiungi server.php">aggiungi server</a>
                        <a href="visualizza lista server Admin.php">visualizza lista server</a>
                        <a href="modifica server.php">modifica server</a>
                        <a href="elimina server.php">elimina server</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a class="dropbtn" href="Contatti.html">Utenti</a>
                    <div class="dropdown-content">
                        <a href="Aggiungi utente.php">aggiungi utente</a>
                        <a href="visualizza lista utenti Admin.php">visualizza lista utenti</a>
                        <a href="modifica utente.php">modifica utente</a>
                        <a href="elimina utente.php">elimina utente</a>
                    </div>
                </div>
                <div class="dropdown">
                    <a class="dropbtn" href="Contatti.html">Report</a>
                    <div class="dropdown-content">
                        <a href="genera reportistica server Admin.php">genera reportistica server</a>
                    </div>
                </div>
            </div>
            <div class="account-cart">
                <a href="Login.php"><img src="Logout.png"></a>
            </div>
        </nav>
    </header>
<h1>Aggiungi utente</h1>

<div class="container">
<form method="POST" action="">
    <label for="add_user">User:</label>
    <input type="text" id="add_user" name="add_user" required>
    <br>
    <label for="add_password">Password:</label>
    <input type="password" id="add_password" name="add_password" required>
    <br>
    <label for="privilegio">Privilegio:</label>
    <select id="privilegio" name="privilegio" required>
        <option value="0">Utente</option>
        <option value="1">Amministratore</option>
    </select>
    <br>
    <input type="submit" value="Aggiungi account">
</form>
</div>

<div id="overlay" class="overlay">
    <div class="popup">
        <h2 id="popup-title">Errore</h2>
        <p id="popup-message"></p>
        <button id="popup-close" type="button">Chiudi</button>
    </div>
</div>



<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "server";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Verifica se i dati di aggiunta dell'account sono stati inviati
    if (isset($_POST["add_user"]) && isset($_POST["add_password"]) && isset($_POST["privilegio"])) {
        $user = $_POST["add_user"];
        $password = $_POST["add_password"];
        $privilegio = $_POST["privilegio"];

        // Verifica se l'utente esiste già nella tabella admin_user
        $checkUserQuery = "SELECT * FROM admin_user WHERE user = '$user'";
        $checkUserResult = $conn->query($checkUserQuery);

        if ($checkUserResult->num_rows > 0) {
            $errorMessage = "utente esistente nella tabella admin_user. Impossibile aggiungere un account con lo stesso nome.";
            echo "<script>showPopup('$errorMessage');</script>";
        } else {
            // Query per aggiungere l'account alla tabella admin_user
            $addAccountQuery = "INSERT INTO admin_user (user, password, privilegio) VALUES ('$user', '$password', '$privilegio')";

            if ($conn->query($addAccountQuery) === TRUE) {
                echo "<script>showPopup('Utente aggiunto con successo.', '')</script>";
            } else {
                $errorMessage = "Errore durante l'aggiunta dell'account: " . $conn->error;
                echo "<script>showPopup('$errorMessage');</script>";
            }
        }
    }

    $conn->close();
}
?>


</body>
</html>
