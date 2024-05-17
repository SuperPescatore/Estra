<?php
session_start();

// Verifica se sono stati inviati i dati di login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "server";

    // Crea la connessione
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controlla la connessione
    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    // Pulisci i dati inviati dal modulo di login
    $username = $_POST["user"];
    $password = $_POST["password"];

    // Esegue la query per verificare l'utente nel database
    $sql = "SELECT user FROM admin_user WHERE user = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utente è autenticato, salva il nome utente nella sessione
        $row = $result->fetch_assoc();
        $_SESSION["user"] = $row["user"];

        // Reindirizza l'utente alla pagina HomeAdmin.php
        header("Location: HomeAdmin.php");
        exit();
    } else {
        // L'utente non è valido, visualizza un messaggio di errore
        echo "Credenziali di accesso non valide.";
    }

    // Chiudi la connessione al database
    $conn->close();
}
?>

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

   
    <?php
    // Verifica se l'utente è autenticato
    if (isset($_SESSION['user'])) {
        // Ottieni il nome utente dalla sessione
        $username = $_SESSION['user'];

        // Stampa il messaggio di benvenuto con il nome utente
        echo '<div style="text-align: center; margin-top: 250px; font-size: 50px;">Benvenuto ' . $username . '</div>';
    } else {
        // L'utente non è autenticato, reindirizza all pagina di login
        header("Location: Login.php");
        exit();
    }
    ?>


</body>
</html>
