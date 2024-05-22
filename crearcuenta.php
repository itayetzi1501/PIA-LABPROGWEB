<?php
include 'db_connection.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['Id_Usuario']);
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['ApellidoPaterno']);
    $apellido_materno = $conn->real_escape_string($_POST['ApellidoMaterno']);
    $email = $conn->real_escape_string($_POST['correo']);
    $telefono = $conn->real_escape_string($_POST['telefono']);
    $direccion = $conn->real_escape_string($_POST['direccion']);
    $cp = $conn->real_escape_string($_POST['CodigoPostal']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['FechaNacimiento']);
    $password = password_hash($conn->real_escape_string($_POST['Contraseña']), PASSWORD_BCRYPT);

    $sql_check = "SELECT * FROM usuarios WHERE username = '$Id_Usuario' OR email = '$Correo'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "El usuario o correo electrónico ya existe";
    } else {
        $sql = "INSERT INTO usuarios (username, Nombre, ApellidoPaterno, ApellidoMaterno, Correo, Telefono, Direccion, CodigoPostal, FechaNacimiento, Contraseña) 
                VALUES ('$username', '$Nombre', '$ApellidoPaterno', '$ApellidoMaterno', '$Coreo', '$Telefono', '$Direccion', '$CodigoPostal', '$FechaNacimiento', 'Contraseña')";

        if ($conn->query($sql) === TRUE) {
            $success = "Cuenta creada exitosamente. Ahora puedes <a href='login.php'>iniciar sesión</a>";
        } else {
            $error = "Error al crear la cuenta: " . $conn->error;
        }
    }

    $conn->close();
}
?>

