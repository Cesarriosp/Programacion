<?php
// Incluimos el archivo que conecta a la base de datos
require_once 'C:\xampp\htdocs\prog_php\hitocesar\config\class_conexion.php';
$conexion = new Conexion();
$conn = $conexion->getConexion();

// Hacemos una consulta para obtener los datos de los usuarios
$sql = "SELECT id, nombre, email FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - StreamWeb</title>
    <style>
        /* Estilo simple para hacer que la página se vea bien  con una tabla y cambiando los tamaños de separacion y de las fuentes*/
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Bienvenido al sistema de gestión de usuarios</h1>
    
    <!--Enlace para registrar un nuevo usuario-->
    <h2>Opciones</h2>
    <ul>
        <li><a href="insertar_usuarios.php">Registrar nuevo usuario</a></li>
    </ul>

    <h2>Usuarios Registrados</h2>
    <?php
    //Volvemos a crear la conexión para obtener más información
    $conexion = new Conexion();
    $conn = $conexion->getConexion();
    
    //Hacemos otra consulta para obtener los usuarios con más detalles (plan y paquete)
    $sql_usuarios = "
        SELECT u.id, u.nombre, u.email, u.edad, p.precio AS precio_plan, 
               pa.precio AS precio_paquete
        FROM usuarios u
        JOIN suscripciones s ON u.id = s.usuario_id
        JOIN planes p ON s.plan_id = p.id
        LEFT JOIN usuario_paquetes up ON u.id = up.usuario_id
        LEFT JOIN paquetes pa ON up.paquete_id = pa.id
    ";
    $result_usuarios = $conn->query($sql_usuarios);
    ?>    

    <!--Tabla para mostrar la lista de usuarios-->
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Edad</th>
                <th>Coste Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!--Recorremos todos los usuarios obtenidos y mostramos sus datos-->
            <?php while ($usuario = $result_usuarios->fetch_assoc()) { 
                // Calculamos el precio total (plan+paquete)
                $precio_total = $usuario['precio_plan'] + ($usuario['precio_paquete'] ?? 0); 
            ?>
                <tr>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['edad']; ?></td>
                    <td><?php echo number_format($precio_total, 2, ',', '.'); ?> €</td>
                    <td>
                        <!--Enlaces para modificar o eliminar el usuario-->
                        <a href="modificar_socios.php?id=<?php echo $usuario['id']; ?>">Modificar</a>
                        <a href="eliminar_socios.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
    
<?php $conexion->cerrar(); ?>
