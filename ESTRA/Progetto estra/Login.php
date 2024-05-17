<?php
// Connessione al database (cambia i valori per adattarli al tuo ambiente)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "server";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se la connessione al database è avvenuta con successo
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Inizializza le variabili
$errorMessage = "";
$successMessage = "";

// Gestione del login e registrazione
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        // Gestione del login
        if ($action === "login") {
            $user = $_POST["user"];
            $password = $_POST["password"];

            // Query per verificare le credenziali
            $query = "SELECT * FROM admin_user WHERE user = '$user' LIMIT 1";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                // Utente trovato, controlla la password senza crittografia
                $row = $result->fetch_assoc();
                $storedPassword = $row["password"];
                $privilege = $row["privilegio"];

                if ($password === $storedPassword) {
                    // Password corretta
                    session_start();
                    $_SESSION["user"] = $user;

                    if ($privilege == 1) {
                        header("Location: HomeAdmin.php"); // Reindirizza alla dashboard dell'amministratore
                    } else {
                        header("Location: HomeUser.php"); // Reindirizza alla dashboard dell'utente
                    }

                    exit;
                } else {
                    // Password errata
                    $errorMessage = "Password errata. Riprova.";
                    echo '<script>alert("Errore: ' . $errorMessage . '");</script>';
                }
            } else {
                // Utente non trovato
                $errorMessage = "Utente inesistente, contatta l'amministratore";
                echo '<script>alert("Errore: ' . $errorMessage . '");</script>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    /* Stili per il riquadro di login */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    
    #login-container {
      max-width: 300px;
      padding: 20px;
      border: 1px solid #ccc;
      background-color: #f4f4f4;
      text-align: center;
      border-radius: 10px;
    }
    
    #login-form label,
    #login-form input[type="text"],
    #login-form input[type="password"],
    #login-form button[type="submit"] {
      display: block;
      margin-bottom: 10px;
      width: 100%;
      box-sizing: border-box;
      border-radius: 10px;
      padding: 5px;
    }
    
    #user,
    #password {
      width: calc(100% - 50px);
    }
    
    #login-form button[type="submit"] {
      margin-left: auto;
      margin-top: 20px;
      width: 30%;
      background-color: #828282;
      border-radius: 10px; /* Aggiunto arrotondamento del bordo */
    }
    
    #logo {
      margin-bottom: 20px;
      width: 100%;
      border-radius: 10px;   
    }


.login-form {
  margin-right: 150px;
  margin-top:20px;
}

.container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 100vh;
}

.login-form,
.registration-form {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px; /* Adds vertical spacing between form elements */
  padding: 40px;
  border: 1px solid #ccc;
  border-radius: 20px;
  max-width: 300px;
  margin-bottom: 20px;
  background-color: #f5f5f5;
}

.login-form {
  margin-right: 150px;
  margin-top:20px;
}

.registration-form {
  margin-left: 150px;
  margin-top:20px;
}

form input[type="email"],
form input[type="password"],
form input[type="text"] {
  width: 100%;
  border-radius: 20px;
  border: 1px solid #ccc;
  padding: 8px;
  margin-bottom:10px;
}

form button {
  border-radius: 5px;
  padding: 8px 16px;
  background-color: #1e90ff;
  color: white;
  border: none;
  cursor: pointer;
  margin-top:10px;
}

form label {
  margin-bottom: 5px; /* Adds spacing between label and input fields */
}



  </style>
</head>
<body>
  
  <div id="login-container">
    <img src="Logo Estra.jpg" alt="Estra Logo" id="logo">
    <form method="post" action="">
      <input type="hidden" name="action" value="login">
      <label for="user">User:</label><br>
      <input type="text" id="user" name="user" required><br><br>
      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br><br>
      <button type="submit">Accedi</button>
    </form>
   
</div>
</body>
</html> 
