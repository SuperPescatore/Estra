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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            margin-top: -200px;
            text-align: center;
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

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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
    </style>
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

    <h1>Elimina server</h1>
    <div class="container">
        <form method="POST" action="">
            <label for="host_name">Nome Server:</label>
            <input type="text" id="host_name" name="host_name" required>
            <br>
            <input type="submit" value="Elimina server">
        </form>
    </div>

    <div id="popup" class="popup">
        <h2 id="popup-title"></h2>
        <p id="popup-message"></p>
        <button id="popup-close">Chiudi</button>
    </div>

    <script>
        // Mostra il popup con il titolo e il messaggio specificati
        function showPopup(title, message) {
            document.getElementById("popup-title").textContent = title;
            document.getElementById("popup-message").textContent = message;
            document.getElementById("popup").style.display = "block";
        }

        // Chiudi il popup
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }

        // Aggiungi l'evento di click al pulsante di chiusura del popup
        document.getElementById("popup-close").addEventListener("click", closePopup);
    </script>

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

        // Verifica se il parametro di rimozione del server è stato inviato
        if (isset($_POST["host_name"])) {
            $hostNameToRemove = $_POST["host_name"];

            // Query per verificare se il nome del server esiste
            $checkServerQuery = "SELECT * FROM info_controll WHERE Host_name = '$hostNameToRemove'";
            $checkServerResult = $conn->query($checkServerQuery);

            if ($checkServerResult->num_rows > 0) {
                // Nome server trovato, esegui la rimozione
                $deleteServerQuery = "DELETE FROM info_controll WHERE Host_name = '$hostNameToRemove'";

                if ($conn->query($deleteServerQuery) === TRUE) {
                    echo "<script>showPopup('Server rimosso con successo.', '')</script>";
                } else {
                    echo "<script>showPopup('Errore durante la rimozione del server:', '" . $conn->error . "')</script>";
                }
            } else {
                // Nome server non trovato
                echo "<script>showPopup('Impossibile rimuovere il server.', 'Il nome del server non esiste.')</script>";
            }
        }

        $conn->close();
    }
    ?>

</body>
</html>
