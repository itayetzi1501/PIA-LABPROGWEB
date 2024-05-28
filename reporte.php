<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_fin = $_POST["fecha_fin"];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "usuario", "contraseña", "farmax");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para obtener el reporte de ventas en el período seleccionado
    $sql = "SELECT v.id, p.nombre AS nombre_producto, v.cantidad, v.total, v.fecha
            FROM ventas v
            JOIN productos p ON v.id_producto = p.id
            WHERE v.fecha BETWEEN ? AND ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
    $stmt->execute();
    $result = $stmt->get_result();

    $ventas = [];
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }

    $stmt->close();
    $conexion->close();

    echo json_encode($ventas);
}
?>
