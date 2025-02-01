<?php
require_once 'C:\xampp\htdocs\prog_php\hitocesar\config\class_conexion.php';

$conexion = new Conexion();
$conn = $conexion->getConexion();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recogemos los datos enviados desde el formulario  con el _POST
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $plan_id = $_POST['plan'];
    $duracion = $_POST['duracion'];
    $paquete_id = $_POST['paquete'];

    //Validamos si la edad es adecuada para el plan y paquete seleccionado
    if ($edad < 18 && $paquete_id != 3) {
        // Si el usuario es menor de 18 años, solo puede seleccionar el paquete Infantil
        die("Los menores de edad solo pueden contratar el pack infantil.");
    }

    //Si el paquete es el de deporte, la duración debe ser Anual
    if ($paquete_id == "1" && $duracion != "Anual") {
        die("El paquete de deporte ha de ser anual.");
    }

    //Insertamos el usuario en la base de datos con los datos obtenidos
    $sql_usuario = "INSERT INTO usuarios (nombre, email, edad) VALUES ('$nombre', '$email', $edad)";
    if ($conn->query($sql_usuario) === TRUE) {
        //obtenemos el ID del usuario insertado
        $usuario_id = $conn->insert_id;

        //Insertamos la suscripción asociada al usuario
        $sql_suscripcion = "INSERT INTO suscripciones (usuario_id, plan_id, duracion) VALUES ($usuario_id, $plan_id, '$duracion')";
        if ($conn->query($sql_suscripcion) === TRUE) {
            //Insertamos el paquete adicional seleccionado
            $sql_paquete = "INSERT INTO usuario_paquetes (usuario_id, paquete_id) VALUES ($usuario_id, $paquete_id)";
            if ($conn->query($sql_paquete) === TRUE) {
                echo "Usuario creado correctamente.";
                header("Location: index.php"); // Redirige al index para ver todo
            }
        } else {
            //controlamos si hubo un error al insertar la suscripción
            echo "Error al insertar la suscripción: " . $conn->error;
        }
    } else {
        //Controlamos si hubo un error al insertar el usuario
        echo "Error al insertar el usuario: " . $conn->error;
    }

    $conexion->cerrar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Registrar Nuevo Usuario</h1>

    <form action="insertar_usuarios.php" method="POST">
        <!--Opciones del formulario como el nombre, email, edad, plan y duración-->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" required><br><br>

        <label for="plan">Plan de Suscripción:</label>
        <select name="plan" required>
            <option value="1">Básico</option>
            <option value="2">Estándar</option>
            <option value="3">Premium</option>
        </select><br><br>

        <label for="duracion">Duración:</label>
        <select name="duracion" required>
            <option value="Mensual">Mensual</option>
            <option value="Anual">Anual</option>
        </select><br><br>

        <label for="paquete">Paquete Adicional:</label>
        <select name="paquete" required>
            <option value="">Seleccionar paquete...</option>
            <option value="1">Deporte</option>
            <option value="2">Cine</option>
            <option value="3">Infantil</option>
        </select><br><br>

        <button type="submit">Registrar Usuario</button>
    </form>
</body>
</html>
