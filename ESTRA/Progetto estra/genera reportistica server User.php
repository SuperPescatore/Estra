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
    <h2>Report di attività</h2>

    <form class="report-form" method="POST" action="">
        <label for="start_date">Data d'inizio:</label>
        <input type="date" id="start_date" name="start_date" required>
        <label for="end_date">Data di fine:</label>
        <input type="date" id="end_date" name="end_date" required>
        <label for="hour">Ora:</label>
        <input type="time" id="hour" name="hour" required>
        <input type="submit" value="Genera report">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Recupero le date e l'ora inserite dall'utente
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $hour = $_POST["hour"];

        // Connessione al database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "server";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connessione fallita: " . $conn->connect_error);
        }

        // Query per calcolare la percentuale di attività per ogni Host_name
        $sql = "SELECT Host_name, 
                ROUND((SUM(CASE WHEN result = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) AS activity_percentage
                FROM respons
                WHERE DATE(data) BETWEEN '$start_date' AND '$end_date'
                AND TIME(ora) >= '$hour'
                GROUP BY Host_name";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Stampa dei risultati nella tabella
            echo "<div class='report-results'>";
            echo "<table>";
            echo "<tr><th>Host_name</th><th>Percentuale di attività</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Host_name"] . "</td>";
                echo "<td>" . $row["activity_percentage"] . "%</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>Nessun dato trovato per il periodo selezionato.</p>";
        }

        $conn->close();
    }
    ?>
</div>
</body>
</html>
