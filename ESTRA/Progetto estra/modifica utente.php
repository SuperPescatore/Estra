<!DOCTYPE html>
<html>
<head>
    <title>Gestione server e Report di attività</title>
    <style>
                   .search-bar {
    display: flex;
    align-items: center;
    border-radius: 20px;
    padding: 5px;
    background-color: #3e4e88;
    width: 300px;
    margin: 20px;
}

.search-bar .search-icon {
    padding: 5px;
    background-color: transparent;
    border-radius: 50%;
    margin-right: 5px;
}

.search-bar .search-icon i {
    color: #1e90ff;
}

.search-bar input[type="text"] {
    flex: 1;
    border: none;
    outline: none;
    padding: 5px;
    border-radius: 20px;
    text-align: center;
}

.search-bar .search-icon img {
    width: 20px; /* Imposta la larghezza desiderata */
    height: auto; /* Lascia che l'altezza si adatti proporzionalmente */
}
        
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
        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 10px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .report-section {
            background-color: #fff;
            box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        .report-section h2 {
            margin-top: 0;
        }

        .report-form {
            margin-bottom: 20px;
        }

        .report-form label {
            font-weight: bold;
        }

        .report-form input[type="date"],
        .report-form input[type="time"],
        .report-form input[type="submit"] {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .report-form input[type="submit"] {
            background-color: #1e90ff;
            color: #fff;
            cursor: pointer;
        }

        .report-results {
            margin-top: 20px;
        }

        .report-results table {
            margin-top: 10px;
        }

        .report-results th, .report-results td {
            border: 1px solid #ddd;
        }

        .report-results th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
    // Funzione per abilitare la modifica di un campo
    function enableEdit(element) {
    if (!element.classList.contains("editable")) {
        element.contentEditable = true;
        element.classList.add("editable");
        element.focus();
    }
}


    // Funzione per disabilitare la modifica di un campo
    function disableEdit(element) {
        element.contentEditable = false;
        element.classList.remove("editable");
    }

    function handleKeyPress(event, element, userId) {
    if (event.key === "Enter") {
        event.preventDefault();
        updateData(element, userId);
        disableEdit(element);
    }
}

// Funzione per abilitare la modifica di un campo
function enableEdit(element) {
    if (!element.classList.contains("editable")) {
        element.contentEditable = true;
        element.classList.add("editable");
        element.focus();
    }
}



function updateData(element) {
    var newValue = element.textContent.trim();
    var userId = element.getAttribute("data-user-id");

    // Effettua una richiesta AJAX per aggiornare la password nel database
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            // Aggiorna la riga della tabella con il nuovo valore dal database
            var response = JSON.parse(this.responseText);
            if (response.success) {
                element.classList.add("modified");
                setTimeout(function() {
                    element.classList.remove("modified");
                }, 1000);
            } else {
                alert("Si è verificato un errore durante l'aggiornamento della password nel database.");
            }
        }
    };

    xmlhttp.open("POST", "update_user_data.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("userId=" + encodeURIComponent(userId) + "&newValue=" + encodeURIComponent(newValue));
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
        <div class="search-bar">
            <div class="search-icon">
                <img src="Lente.png" alt="Icona Lente d'Ingrandimento">
            </div>
            <input type="text" id="searchInput" placeholder="Cerca" onkeyup="searchTable()">
        </div>
  <script>
            function searchTable() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("serverTable"); // Modifica qui
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td");
                    for (var j = 0; j < td.length; j++) {
                        var cell = td[j];
                        if (cell) {
                            txtValue = cell.textContent || cell.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                                break;
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            }
        </script>

        <div class="menu-items">
            <div class="dropdown">
                <a class="dropbtn" href="HomeAdmin.php">Home</a>
            </div>
            <div class="dropdown">
                <a class="dropbtn" href="Prodotti.html">Server</a>
                <div class="dropdown-content">
                    <a href="aggiungi server.php">Aggiungi server</a>
                    <a href="visulaizza lista server Admin.php">Visualizza lista server</a>
                    <a href="modifica server.php">Modifica server</a>
                    <a href="elimina server.php">Elimina server</a>
                </div>
            </div>
            <div class="dropdown">
                <a class="dropbtn" href="Contatti.html">Utenti</a>
                <div class="dropdown-content">
                    <a href="Aggiungi utente.php">Aggiungi utente</a>
                    <a href="visualiza lista utenti Admin.php">Visualizza lista utenti</a>
                    <a href="modifica utente.php">Modifica utente</a>
                    <a href="elimina utente.php">Elimina utente</a>
                </div>
            </div>
            <div class="dropdown">
                <a class="dropbtn" href="Contatti.html">Report</a>
                <div class="dropdown-content">
                    <a href="genera reportistica server Admin.php">Genera reportistica server</a>
                </div>
            </div>
        </div>
        <div class="account-cart">
            <a href="Login.php"><img src="Logout.png"></a>
        </div>
    </nav>
        </header>

    <div class="report-section">
        <h2>Modifica lista utenti</h2>
    <table id="serverTable">
        <tr>
            <th>Username</th>
            <th>Password</th>
            <th>Privilegio</th>
        </tr>
        <?php
        // Connessione al database e recupero dei dati degli utenti
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "server";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }

        // Recupera il valore di ricerca dalla query string
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Costruisci la query per recuperare i dati degli utenti con il filtro di ricerca
        $sql = "SELECT user, password, privilegio FROM admin_user WHERE user LIKE '%$search%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = $row["user"];
                $password = $row["password"];
                $privilegio = $row["privilegio"];
                $privilegioStringa = $privilegio == 0 ? "Utente" : "Amministratore";
                echo "<tr>";
                echo "<td onclick='enableEdit(this)' onkeypress='handleKeyPress(event, this, \"$user\")' data-user-id=\"$user\">" . $user . "</td>";
                echo "<td onclick='enableEdit(this)' onkeypress='handleKeyPress(event, this, \" $user\")' data-user-id=\"$user\">" . $password ."</td>";
                echo "<td>" . $privilegioStringa . "</td>";
                echo "</tr>";
            }
        }
        
                else {
            echo "<tr><td colspan='3'>Nessun utente presente.</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    </div>
</body>
</html>