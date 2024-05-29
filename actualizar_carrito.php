<?php
session_start();
include 'db_connection.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['Id_Usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['Id_Usuario'];

// Verificar si se proporcionan los datos necesarios
if (isset($_POST['id_producto']) && is_numeric($_POST['id_producto']) && isset($_POST['cantidad']) && is_numeric($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Actualizar la cantidad del producto en el carrito
    $sql = "UPDATE carrito SET cantidad = $cantidad WHERE id_usuario = $usuario_id AND id_producto = $id_producto";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cantidad actualizada exitosamente.');</script>";
    } else {
        echo "<script>alert('Error al actualizar la cantidad: " . $conn->error . "');</script>";
    }
}

// Redirigir de nuevo al carrito
header("Location: carrito.php");
exit();

$conn->close();
?>
