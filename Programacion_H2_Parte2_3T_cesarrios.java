import java.sql.*;
import java.util.Scanner;

public class Programacion_H2_Parte2_3T_cesarrios {
    public static void main(String[] args) {
        String url = "jdbc:mysql://localhost:3306/cine"; 
        String usuario = "root";
        String contraseña = "curso";

        Scanner scanner = new Scanner(System.in);
        int opcion;

        do {
            System.out.println("\n----- MENÚ -----");
            System.out.println("1 - Ver películas");
            System.out.println("2 - Añadir película");
            System.out.println("3 - Eliminar película");
            System.out.println("4 - Modificar película");
            System.out.println("5 - Salir");
            System.out.print("Seleccione una opción: ");
            opcion = scanner.nextInt();
            scanner.nextLine();

            switch (opcion) {
                case 1:
                    mostrarPeliculas(url, usuario, contraseña);
                    break;
                case 2:
                    añadirPelicula(url, usuario, contraseña, scanner);
                    break;
                case 3:
                    eliminarPelicula(url, usuario, contraseña, scanner);
                    break;
                case 4:
                    modificarPelicula(url, usuario, contraseña, scanner);
                    break;
                case 5:
                    System.out.println("Saliendo del programa...");
                    break;
                default:
                    System.out.println("Opción no válida.");
            }

        } while (opcion != 5);

        scanner.close();
    }

    
    public static void mostrarPeliculas(String url, String usuario, String contraseña) {
    	String sql = "SELECT p.id_pelicula, p.titulo, p.director, p.duracion, p.clasificacion, g.nombre_genero " +
                "FROM Peliculas p JOIN Generos g ON p.genero_id = g.id_genero " +
                "ORDER BY p.titulo ASC";


        try (
            Connection conexion = DriverManager.getConnection(url, usuario, contraseña);
            Statement stmt = conexion.createStatement();
            ResultSet rs = stmt.executeQuery(sql)
        ) {
            System.out.println("\n----- LISTADO DE PELÍCULAS -----");

            while (rs.next()) {
                System.out.println("ID: " + rs.getString("id_pelicula"));
                System.out.println("Título: " + rs.getString("titulo"));
                System.out.println("Director: " + rs.getString("director"));
                System.out.println("Duración: " + rs.getInt("duracion") + " minutos");
                System.out.println("Clasificación: " + rs.getString("clasificacion"));
                System.out.println("Género: " + rs.getString("nombre_genero"));
                System.out.println("----------------------------------------");
            }

        } catch (SQLException e) {
            System.out.println("Error al acceder a la base de datos: " + e.getMessage());
        }
    }

    
    public static void añadirPelicula(String url, String usuario, String contraseña, Scanner scanner) {
        try (
            Connection conexion = DriverManager.getConnection(url, usuario, contraseña)
        ) {
            System.out.print("ID película: ");
            String id = scanner.nextLine();

           
            String verificarSql = "SELECT COUNT(*) FROM Peliculas WHERE id_pelicula = ?";
            try (PreparedStatement verificarStmt = conexion.prepareStatement(verificarSql)) {
                verificarStmt.setString(1, id);
                ResultSet rs = verificarStmt.executeQuery();
                if (rs.next() && rs.getInt(1) > 0) {
                    System.out.println("Ya existe una película con ese ID.");
                    return;
                }
            }

            System.out.print("Título: ");
            String titulo = scanner.nextLine();
            System.out.print("Director: ");
            String director = scanner.nextLine();

            
            int duracion = 0;
            while (true) {
                System.out.print("Duración (minutos): ");
                if (scanner.hasNextInt()) {
                    duracion = scanner.nextInt();
                    scanner.nextLine(); 
                    break;
                } else {
                    System.out.println("Por favor, introduzca un número entero válido.");
                    scanner.nextLine(); 
                }
            }

            System.out.print("Clasificación: ");
            String clasificacion = scanner.nextLine();

            
            int generoId = 0;
            while (true) {
                System.out.print("ID Género: ");
                if (scanner.hasNextInt()) {
                    generoId = scanner.nextInt();
                    scanner.nextLine(); 
                    break;
                } else {
                    System.out.println("Por favor, introduzca un número entero válido.");
                    scanner.nextLine(); 
                }
            }

            String insertSql = "INSERT INTO Peliculas (id_pelicula, titulo, director, duracion, clasificacion, genero_id) " +
                               "VALUES (?, ?, ?, ?, ?, ?)";
            try (PreparedStatement insertStmt = conexion.prepareStatement(insertSql)) {
                insertStmt.setString(1, id);
                insertStmt.setString(2, titulo);
                insertStmt.setString(3, director);
                insertStmt.setInt(4, duracion);
                insertStmt.setString(5, clasificacion);
                insertStmt.setInt(6, generoId);
                insertStmt.executeUpdate();
                System.out.println("Película añadida correctamente.");
            }

        } catch (SQLException e) {
            System.out.println("Error al añadir película: " + e.getMessage());
        }
    }


    
    public static void eliminarPelicula(String url, String usuario, String contraseña, Scanner scanner) {
        try (
            Connection conexion = DriverManager.getConnection(url, usuario, contraseña)
        ) {
            System.out.print("ID de la película a eliminar: ");
            String id = scanner.nextLine();

            String deleteSql = "DELETE FROM Peliculas WHERE id_pelicula = ?";
            try (PreparedStatement deleteStmt = conexion.prepareStatement(deleteSql)) {
                deleteStmt.setString(1, id);
                int filasAfectadas = deleteStmt.executeUpdate();
                if (filasAfectadas > 0) {
                    System.out.println("Película eliminada correctamente.");
                } else {
                    System.out.println("No se encontró la película con ese ID.");
                }
            }

        } catch (SQLException e) {
            System.out.println("Error al eliminar película: " + e.getMessage());
        }
    }

   
    public static void modificarPelicula(String url, String usuario, String contraseña, Scanner scanner) {
        try (
            Connection conexion = DriverManager.getConnection(url, usuario, contraseña)
        ) {
            System.out.print("ID de la película a modificar: ");
            String id = scanner.nextLine();

            
            String verificarSql = "SELECT COUNT(*) FROM Peliculas WHERE id_pelicula = ?";
            try (PreparedStatement verificarStmt = conexion.prepareStatement(verificarSql)) {
                verificarStmt.setString(1, id);
                ResultSet rs = verificarStmt.executeQuery();
                if (rs.next() && rs.getInt(1) == 0) {
                    System.out.println("La película no existe.");
                    return;
                }
            }

            
            System.out.print("Nuevo título: ");
            String nuevoTitulo = scanner.nextLine();
            System.out.print("Nuevo director: ");
            String nuevoDirector = scanner.nextLine();

            String updateSql = "UPDATE Peliculas SET titulo = ?, director = ? WHERE id_pelicula = ?";
            try (PreparedStatement updateStmt = conexion.prepareStatement(updateSql)) {
                updateStmt.setString(1, nuevoTitulo);
                updateStmt.setString(2, nuevoDirector);
                updateStmt.setString(3, id);
                updateStmt.executeUpdate();
                System.out.println("Película modificada correctamente.");
            }

        } catch (SQLException e) {
            System.out.println("Error al modificar película: " + e.getMessage());
        }
    }
}


