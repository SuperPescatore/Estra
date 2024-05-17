package ping;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.InetAddress;
import java.sql.*;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Timer;
import java.util.TimerTask;

public class Import_ping {

    public void pingServer() {
        String dbURL = "jdbc:mysql://localhost/server";
        String username = "root";
        String password = "";

        try {
            // Connessione al database
            Connection conn = DriverManager.getConnection(dbURL, username, password);

            // Esecuzione della query per ottenere i dati dalla tabella
            String query = "SELECT * FROM server.info_controll";
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            // Scansione dei risultati della query
            while (rs.next()) {
                String hostName = rs.getString("Host_name");
                String ipAddress = rs.getString("Ip_address");
                String OS = rs.getString("OS");

                // Esecuzione del ping
                boolean isServerConnected = performPing(ipAddress);

                // Inserimento dei dati nella tabella respons
                insertPingResult(conn, hostName, isServerConnected);
            }

            // Chiusura delle risorse
            rs.close();
            stmt.close();
            conn.close();
        } catch (SQLException ex) {
            System.out.println("Errore durante l'accesso al database: " + ex.getMessage());
        }
    }

    private boolean performPing(String ipAddress) 
    {
                try {
            InetAddress inetAddress = InetAddress.getByName(ipAddress);
            return inetAddress.isReachable(5000); // Timeout di 5 secondi
        } catch (IOException e) {
            e.printStackTrace();
        }

        return false;
    }

    private void insertPingResult(Connection conn, String hostName, boolean isServerConnected) {
        try {
            // Ottenere la data e l'ora corrente
            LocalDateTime dateTime = LocalDateTime.now();
            String data = dateTime.format(DateTimeFormatter.ofPattern("yyyy-MM-dd"));
            String ora = dateTime.format(DateTimeFormatter.ofPattern("HH:mm:ss"));

            // Query per l'inserimento dei dati nella tabella respons
            String insertQuery = "INSERT INTO respons (Host_name, data, ora, result) VALUES (?, ?, ?, ?)";

            // Preparazione della dichiarazione
            PreparedStatement stmt = conn.prepareStatement(insertQuery);

            // Impostazione dei parametri della query
            stmt.setString(1, hostName);
            stmt.setString(2, data);
            stmt.setString(3, ora);
            stmt.setBoolean(4, !isServerConnected); // Inverti il risultato del ping (0 se il server è collegato, 1 altrimenti)

            // Esecuzione della query di inserimento
            stmt.executeUpdate();

            // Chiusura della dichiarazione
            stmt.close();
        } catch (SQLException ex) {
            System.out.println("Errore durante l'inserimento dei dati nella tabella respons: " + ex.getMessage());
        }
    }
        
        private void runUserInterface() 
        {
            try (BufferedReader reader = new BufferedReader(new InputStreamReader(System.in))) {
                String choice;
                do {
                    System.out.println("Seleziona un'opzione:");
                    System.out.println("0. Esci");
                    System.out.println("1. Aggiungi un server");
                    System.out.println("2. Rimuovi un server");

                    choice = reader.readLine();

                    switch (choice) {
                    
                    case "0":
                        System.out.println("Addioss!!");
                        break;
                        
                        case "1":
                            addServer(reader);
                            break;
                        case "2":
                            removeServer(reader);
                            break;
                        default:
                            System.out.println("Opzione non valida. Riprova.");
                            break;
                    }

                    System.out.println();
                } while (!choice.equals("0"));
            } catch (IOException ex) {
                System.out.println("Errore di input/output: " + ex.getMessage());
            }
        }

        private void addServer(BufferedReader reader) {
            try {
                System.out.println("Inserisci i dettagli del server:");
                System.out.print("Host Name: ");
                String hostName = reader.readLine();
                System.out.print("IP Address: ");
                String ipAddress = reader.readLine();
                System.out.print("OS: ");
                String os = reader.readLine();

                // Esecuzione del ping
                boolean isServerConnected = performPing(ipAddress);

                // Inserimento dei dati nella tabella info_controll
                insertServerDetails(hostName, ipAddress, os);

                System.out.println("Server aggiunto con successo!");
            } catch (IOException ex) {
                System.out.println("Errore di input/output: " + ex.getMessage());
            }
        }


        private void removeServer(BufferedReader reader) 
        {
            try {
                System.out.println("Inserisci l'Host Name del server da rimuovere:");
                System.out.print("Host Name: ");
                String hostName = reader.readLine();

                // Rimozione del server dalla tabella info_controll
                int rowsAffected = deleteServer(hostName);

                if (rowsAffected > 0) {
                    System.out.println("Server rimosso con successo!");
                } else {
                    System.out.println("Nessun server corrispondente trovato.");
                }
            } catch (IOException ex) {
                System.out.println("Errore di input/output: " + ex.getMessage());
            }
        }

       
        private void insertServerDetails(String hostName, String ipAddress, String os) {
             	 String dbURL = "jdbc:mysql://localhost/server";
                 String username = "root";
                 String password = "";

                 try {
                     // Connessione al database
                     Connection conn = DriverManager.getConnection(dbURL, username, password);

                    // Query per l'inserimento dei dati nella tabella info_controll
                     String insertQuery = "INSERT INTO info_controll (Host_name, Ip_address, OS) VALUES (?, ?, ?)";

                     // Preparazione della dichiarazione
                     PreparedStatement stmt = conn.prepareStatement(insertQuery);

                     // Impostazione dei parametri della query
                     stmt.setString(1, hostName);
                     stmt.setString(2, ipAddress);
                     stmt.setString(3, os);

                     // Esecuzione della query di inserimento
                     stmt.executeUpdate();
                     

                     // Chiusura delle risorse
                     stmt.close();
                     conn.close();
               

                } catch (SQLException ex) {
                System.out.println("Errore durante l'inserimento dei dati nella tabella info_controll: " + ex.getMessage());
            }
}

        private int deleteServer(String hostName) {
        	String dbURL = "jdbc:mysql://localhost/server";
            String username = "root";
            String password = "";

            try {
                // Connessione al database
                Connection conn = DriverManager.getConnection(dbURL, username, password);

              
                // Query per la rimozione del server dalla tabella info_controll
                String deleteQuery = "DELETE FROM info_controll WHERE Host_name = ?";

                // Preparazione della dichiarazione
                PreparedStatement stmt = conn.prepareStatement(deleteQuery);

                // Impostazione dei parametri della query
                stmt.setString(1, hostName);

                // Esecuzione della query di eliminazione
                int rowsAffected = stmt.executeUpdate();

                // Chiusura della dichiarazione
                stmt.close();

                return rowsAffected;
            } catch (SQLException ex) {
                System.out.println("Errore durante la rimozione del server dalla tabella info_controll: " + ex.getMessage());
            }
            return 0;
        }
    

    


        public static void main(String[] args) {
            Timer timer = new Timer();
            long interval = 600000; // Intervallo di tempo tra i ping in millisecondi (60 secondi)

            // Creazione del task di ping da eseguire ripetutamente
            TimerTask task = new TimerTask() {
                @Override
                public void run() {
                    Import_ping databasePing = new Import_ping();
                    databasePing.pingServer();
                }
            };

            // Avvio del timer per i ping ripetuti
            timer.scheduleAtFixedRate(task, 0, interval);
        }

}
