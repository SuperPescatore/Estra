package ping;


import java.lang.management.ManagementFactory;
import java.lang.management.OperatingSystemMXBean;
import java.net.InetAddress;
import java.net.UnknownHostException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;

public class ServerResourceMonitor {

    private static final String DB_URL = "jdbc:mysql://localhost/server";
    private static final String DB_USERNAME = "root";
    private static final String DB_PASSWORD = "";

    public static void main(String[] args) {
        try (Connection conn = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD)) {
            List<String> serverIPs = retrieveServerIPs(conn);
            monitorServerResources(serverIPs);
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private static List<String> retrieveServerIPs(Connection conn) throws SQLException {
        List<String> serverIPs = new ArrayList<>();

        String query = "SELECT ip_address FROM info_controll";
        try (Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(query)) {
            while (rs.next()) {
                String ipAddress = rs.getString("ip_address");
                serverIPs.add(ipAddress);
            }
        }

        return serverIPs;
    }

    private static void monitorServerResources(List<String> serverIPs) {
        for (String ipAddress : serverIPs) {
            String hostName = getHostName(ipAddress);
            double cpuUsage = getCPUUsage();
            double memoryUsage = getMemoryUsage();
            double diskUsage = getDiskUsage();

            System.out.println("Server: " + hostName);
            System.out.println("CPU Usage: " + cpuUsage + "%");
            System.out.println("Memory Usage: " + memoryUsage + "%");
            System.out.println("Disk Usage: " + diskUsage + "%");
            System.out.println("----------------------------------");
        }
    }

    private static String getHostName(String ipAddress) {
        try {
            Connection conn = DriverManager.getConnection(DB_URL, DB_USERNAME, DB_PASSWORD);
            String query = "SELECT Host_name FROM info_controll WHERE ip_address = ?";
            try (PreparedStatement stmt = conn.prepareStatement(query)) {
                stmt.setString(1, ipAddress);
                ResultSet rs = stmt.executeQuery();
                if (rs.next()) {
                    String hostName = rs.getString("Host_name");
                    return hostName;
                }
            }
        } catch (SQLException e) {
            System.out.println("Errore durante il recupero dell'hostname del server: " + ipAddress);
        }

        return "";
    }


    private static double getCPUUsage() {
        OperatingSystemMXBean osBean = (OperatingSystemMXBean) ManagementFactory.getOperatingSystemMXBean();
        double cpuUsage = osBean.getCPUUsage() * 100.0;
        
        if (cpuUsage < 0) 
        {
            cpuUsage = 0.0;  // Imposta a 0 se il valore è negativo
        }
        
        return cpuUsage;
    }

    private static double getMemoryUsage() {
        OperatingSystemMXBean osBean = ManagementFactory.getOperatingSystemMXBean();
        double totalMemory = osBean.getTotalPhysicalMemorySize();
        double freeMemory = osBean.getFreePhysicalMemorySize();
        double memoryUsage = (totalMemory - freeMemory) / totalMemory * 100.0;
        return memoryUsage;
    }


    private static double getDiskUsage() {
        // Implementa il codice per ottenere l'utilizzo del disco del server
        // Utilizza una libreria o un approccio adatto per interrogare il server e ottenere l'utilizzo del disco
        // Restituisci l'utilizzo del disco come valore double
        // Esempio di implementazione usando un approccio fittizio che restituisce un valore casuale compreso tra 0 e 100:
        return Math.random() * 100;
    }
}
