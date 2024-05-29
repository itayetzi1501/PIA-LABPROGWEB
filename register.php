<?php
include 'db_connection.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conn->real_escape_string($_POST['Nombre']);
    $apellido_paterno = $conn->real_escape_string($_POST['ApellidoPaterno']);
    $apellido_materno = $conn->real_escape_string($_POST['ApellidoMaterno']);
    $correo = $conn->real_escape_string($_POST['Correo']);
    $telefono = $conn->real_escape_string($_POST['Telefono']);
    $direccion = $conn->real_escape_string($_POST['Direccion']);
    $codigo_postal = $conn->real_escape_string($_POST['CodigoPostal']);
    $fecha_nacimiento = $conn->real_escape_string($_POST['FechaNacimiento']);
    $contraseña = $conn->real_escape_string($_POST['Contraseña']);  // Contraseña sin hash

    // Verificar si el usuario o el correo ya existen
    $sql_check = "SELECT * FROM Usuario WHERE Correo = '$correo'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $error = "El usuario o correo electrónico ya existe";
    } else {
        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO Usuario (Nombre, ApellidoPaterno, ApellidoMaterno, Correo, Telefono, Direccion, CodigoPostal, FechaNacimiento, Contraseña) 
                VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$correo', '$telefono', '$direccion', $codigo_postal, '$fecha_nacimiento', '$contraseña')";

        if ($conn->query($sql) === TRUE) {
            $id_usuario = $conn->insert_id;
            $id_rol = 2; // ID del rol "usuario"

            // Asignar rol de usuario por defecto
            $sql_rol = "INSERT INTO UsuarioRol (Id_Usuario, Id_Rol) VALUES ($id_usuario, $id_rol)";
            $conn->query($sql_rol);

            $success = "Cuenta creada exitosamente. Ahora puedes <a href='login.php'>iniciar sesión</a>";
        } else {
            $error = "Error al crear la cuenta: " . $conn->error;
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Registro de Usuario</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php" class="mx-auto" style="max-width: 600px;">
        <div class="form-group">
            <label for="Nombre">Nombre</label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" required>
        </div>
        <div class="form-group">
            <label for="ApellidoPaterno">Apellido Paterno</label>
            <input type="text" class="form-control" id="ApellidoPaterno" name="ApellidoPaterno">
        </div>
        <div class="form-group">
            <label for="ApellidoMaterno">Apellido Materno</label>
            <input type="text" class="form-control" id="ApellidoMaterno" name="ApellidoMaterno">
        </div>
        <div class="form-group">
            <label for="Correo">Correo</label>
            <input type="email" class="form-control" id="Correo" name="Correo" required>
        </div>
        <div class="form-group">
            <label for="Telefono">Teléfono</label>
            <input type="text" class="form-control" id="Telefono" name="Telefono">
        </div>
        <div class="form-group">
            <label for="Direccion">Dirección</label>
            <input type="text" class="form-control" id="Direccion" name="Direccion">
        </div>
        <div class="form-group">
            <label for="CodigoPostal">Código Postal</label>
            <input type="text" class="form-control" id="CodigoPostal" name="CodigoPostal">
        </div>
        <div class="form-group">
            <label for="FechaNacimiento">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="FechaNacimiento" name="FechaNacimiento">
        </div>
        <div class="form-group">
            <label for="Contraseña">Contraseña</label>
            <input type="password" class="form-control" id="Contraseña" name="Contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
    </form>
</div>

<!-- Incluir Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
