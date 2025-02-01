<?php
require_once 'C:\xampp\htdocs\prog_php\hitocesar\config\class_conexion.php';

$conexion = new Conexion();
$conn = $conexion->getConexion();
$usuario_id = $_GET['id'];
//Creamos las variables que recogeremos del usuario
$nombre = '';
$email = '';
$edad = '';
$plan_id = '';
$duracion = '';
$paquete_id = '';

if ($usuario_id) {
    //Obtenemos los datos del socio
    $sql_usuario = "SELECT * FROM usuarios WHERE id = $usuario_id";
    $result_usuario = $conn->query($sql_usuario);

    if ($result_usuario->num_rows > 0) {
        $usuario = $result_usuario->fetch_assoc();
        $nombre = $usuario['nombre'];
        $email = $usuario['email'];
        $edad = $usuario['edad'];

        //Obtenemos la suscripcion del socio
        $sql_suscripcion = "SELECT * FROM suscripciones WHERE usuario_id = $usuario_id LIMIT 1";
        $result_suscripcion = $conn->query($sql_suscripcion);
        if ($result_suscripcion->num_rows > 0) {
            $suscripcion = $result_suscripcion->fetch_assoc();
            $plan_id = $suscripcion['plan_id'];
            $duracion = $suscripcion['duracion'];
        }

        //Obtenemos el paquete del socio
        $sql_paquete = "SELECT * FROM usuario_paquetes WHERE usuario_id = $usuario_id LIMIT 1";
        $result_paquete = $conn->query($sql_paquete);
        if ($result_paquete->num_rows > 0) {
            $paquete = $result_paquete->fetch_assoc();
            $paquete_id = $paquete['paquete_id'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $edad = $_POST['edad'];
    $plan_id = $_POST['plan'];
    $duracion = $_POST['duracion'];
    $paquete_id = $_POST['paquete'];

    if ($edad < 18 && $paquete_id != 3) {
        die("Los menores de edad solo pueden contratar el pack infantil.");
    }
    if ($paquete_id == "1" && $duracion != "Anual") {
        die("El paquete de deporte ha de ser anual.");
    }
    //Actualizamos los datos del usuario
    $sql_usuario = "UPDATE usuarios SET nombre = '$nombre', email = '$email', edad = $edad WHERE id = $usuario_id";
    if ($conn->query($sql_usuario) === TRUE) {
        $sql_suscripcion = "UPDATE suscripciones SET plan_id = $plan_id, duracion = '$duracion' WHERE usuario_id = $usuario_id";
        //Actualizamos la suscripcion
        $conn->query($sql_suscripcion);
        // Actualizamos el paquete seleccionado
        $sql_paquete = "UPDATE usuario_paquetes SET paquete_id = $paquete_id WHERE usuario_id = $usuario_id";
        $conn->query($sql_paquete);
        echo "Usuario actualizado correctamente.";
        header("Location: index.php"); 
    } else {
        // Comprobamos si hubo un error
        echo "Error al actualizar el usuario: " . $conn->error;
    }
    $conexion->cerrar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
</head>
<body>
    <h1>Modificar Usuario</h1>
    <!--Formulario para modificar el usuario y demás con valores ya cargados-->
    <form action="modificar_socios.php?id=<?php echo $usuario_id; ?>" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $nombre; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" value="<?php echo $edad; ?>" required><br><br>

        <label for="plan">Plan de Suscripción:</label>
        <select name="plan" required>
            <option value="1" <?php if ($plan_id == 1) echo "selected"; ?>>Básico</option>
            <option value="2" <?php if ($plan_id == 2) echo "selected"; ?>>Estándar</option>
            <option value="3" <?php if ($plan_id == 3) echo "selected"; ?>>Premium</option>
        </select><br><br>

        <label for="duracion">Duración:</label>
        <select name="duracion" required>
            <option value="Mensual" <?php if ($duracion == 'Mensual') echo "selected"; ?>>Mensual</option>
            <option value="Anual" <?php if ($duracion == 'Anual') echo "selected"; ?>>Anual</option>
        </select><br><br>

        <label for="paquete">Paquete Adicional:</label>
        <select name="paquete" required>
            <option value="1" <?php if ($paquete_id == 1) echo "selected"; ?>>Deporte</option>
            <option value="2" <?php if ($paquete_id == 2) echo "selected"; ?>>Cine</option>
            <option value="3" <?php if ($paquete_id == 3) echo "selected"; ?>>Infantil</option>
        </select><br><br>

        <button type="submit">Actualizar Usuario</button>
    </form>
</body>
</html>
