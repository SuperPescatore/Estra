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
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">
            <a href="HomeUser.php">
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
                table = document.getElementById("serverTable");
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
                <a class="dropbtn" href="HomeUser.php">Home</a>
            </div>
            <div class="dropdown">
                <a class="dropbtn" href="Prodotti.html">Server</a>
                <div class="dropdown-content">
                    <a href="visulaizza lista server User.php">Visualizza lista server</a>
                </div>
            </div>
            <div class="dropdown">
                <a class="dropbtn" href="Contatti.html">Report</a>
                <div class="dropdown-content">
                    <a href="genera reportistica server User.php">Genera reportistica server</a>
                </div>
            </div>
        </div>
        <div class="account-cart">
            <a href="Login.php"><img src="Logout.png"></a>
        </div>
    </nav>
</header>

<div class="report-section">
    <h2>Lista server</h2>
    <table id="serverTable">
        <tr>
            <th>Nome</th>
            <th>IP</th>
            <th>Sistema operativo</th>
        </tr>
        
        <?php
        // Connessione al database e recupero dei dati dei server
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

        // Costruisci la query per recuperare i dati dei server con il filtro di ricerca
        $sql = "SELECT Host_name, Ip_address, OS FROM info_controll WHERE Host_name LIKE '%$search%' OR Ip_address LIKE '%$search%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Stampa dei risultati nella tabella
            while ($row = $result->fetch_assoc()) {
                $hostName = $row["Host_name"];
                $ipAddress = $row["Ip_address"];
                $os = $row["OS"];

                // Verifica se la riga corrente corrisponde al criterio di ricerca
                $rowClass = "";
                if ($hostName === $search || $ipAddress === $search) {
                    $rowClass = "highlight";
                }

                echo "<tr class='$rowClass'>";
                echo "<td class='editable' data-field='Host_name' onclick='makeEditable(this, \"$hostName\", \"Host_name\")'>" . $hostName . "</td>";
                echo "<td class='editable' data-field='Ip_address' onclick='makeEditable(this, \"$hostName\", \"Ip_address\")'>" . $ipAddress . "</td>";
                echo "<td class='editable' data-field='OS' onclick='makeEditable(this, \"$hostName\", \"OS\")'>" . $os . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>Nessun server presente.</td></tr>";
        }

        $conn->close();
        ?>
</div>
</body>
</html>
