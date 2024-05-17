package ping;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.LocalTime;
import java.util.HashMap;
import java.util.Map;
import java.util.Scanner;

public class ReportGenerator {
    // Configurazione per la connessione al database
    private static final String DB_URL = "jdbc:mysql://localhost:3306/server";
    private static final String DB_USERNAME = "root";
    private static final String DB_PASSWORD = "";

    public static void main(String[] args) {
        // Connessione al database
        try (Connection conn = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD)) {
            // Recupero dei dati per ogni server
            String sql = "SELECT Host_name, data, ora, result FROM respons";
            try (PreparedStatement stmt = conn.prepareStatement(sql)) {
                try (ResultSet rs = stmt.executeQuery()) {
                    Scanner scanner = new Scanner(System.in);

                    System.out.print("Inserisci la data di inizio (AAAA-MM-GG): ");
                    String startDateInput = scanner.nextLine();
                    LocalDate startDate = LocalDate.parse(startDateInput);

                    System.out.print("Inserisci l'ora di inizio (HH:MM): ");
                    String startTimeInput = scanner.nextLine();
                    LocalTime startTime = LocalTime.parse(startTimeInput);

                    System.out.print("Inserisci la data di fine (AAAA-MM-GG): ");
                    String endDateInput = scanner.nextLine();
                    LocalDate endDate = LocalDate.parse(endDateInput);

                    System.out.print("Inserisci l'ora di fine (HH:MM): ");
                    String endTimeInput = scanner.nextLine();
                    LocalTime endTime = LocalTime.parse(endTimeInput);

                    Map<String, Integer> contactedCountMap = new HashMap<>();
                    Map<String, Integer> activeCountMap = new HashMap<>();

                    while (rs.next()) {
                        String serverName = rs.getString("Host_name");
                        LocalDate date = rs.getDate("data").toLocalDate();
                        LocalTime time = rs.getTime("ora").toLocalTime();
                        boolean result = rs.getBoolean("result");

                        // Controllo sul nome del server
                        // Controllo sulla data e ora
                            LocalDateTime dateTime = LocalDateTime.of(date, time);
                            LocalDateTime startDateTime = LocalDateTime.of(startDate, startTime);
                            LocalDateTime endDateTime = LocalDateTime.of(endDate, endTime);

                            if (dateTime.isAfter(startDateTime) && dateTime.isBefore(endDateTime)) {
                                // Aggiornamento del contatore delle volte che il server è stato contattato
                                int contactedCount = contactedCountMap.getOrDefault(serverName, 0);
                                contactedCount += 1;
                                contactedCountMap.put(serverName, contactedCount);

                                // Aggiornamento del contatore delle volte che il server è stato attivo
                                int activeCount = activeCountMap.getOrDefault(serverName, 0);
                                activeCount += result ? 0 : 1;
                                activeCountMap.put(serverName, activeCount);
                            }
                        }

                    // Generazione del rapporto per ogni server
                    for (Map.Entry<String, Integer> entry : contactedCountMap.entrySet()) {
                        String serverName = entry.getKey();
                        int contactedCount = entry.getValue();
                        int activeCount = activeCountMap.getOrDefault(serverName, 0);

                        generateReport(serverName, contactedCount, activeCount);
                    }
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static void generateReport(String serverName, int contactedCount, int activeCount) {
        // Calcolo della percentuale di volte in cui il server è stato attivo
        double activePercentage = (activeCount / (double) contactedCount) * 100.0;

        // Generazione del rapporto
        System.out.println("Server: " + serverName);
        System.out.println("Percentuale di attività: " + activePercentage + "%");
        System.out.println("--------------------------------------------------");
    }
}
