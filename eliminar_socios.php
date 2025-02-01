<?php
require_once 'C:\xampp\htdocs\prog_php\hitocesar\config\class_conexion.php';

$conexion = new Conexion();
$conn = $conexion->getConexion();

// Obtener el ID del usuario a eliminar
$id_usuario = $_GET['id'];

// Eliminar el usuario por su id
$sql = "DELETE FROM usuarios WHERE id = $id_usuario";
if ($conn->query($sql) === TRUE) {
    echo "Usuario eliminado correctamente.";
    header("Location: index.php");
} else {
    echo "Error al eliminar el usuario: " . $conn->error;
}

$conexion->cerrar();
?>
