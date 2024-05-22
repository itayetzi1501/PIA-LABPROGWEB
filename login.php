<?php
// Incluir el archivo de conexión
include 'db_connection.php';

// Iniciar la sesión
session_start();

// Variable para almacenar mensajes de error
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar los datos del formulario
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Consultar la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Iniciar sesión y redirigir al usuario
        $_SESSION['username'] = $username;
        header("Location: welcome.php"); // Redirigir a una página de bienvenida o dashboard
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    .login-container {
      max-width: 400px;
      margin: auto;
      margin-top: 100px;
    }
  </style>
</head>
<body>
  <div class="container login-container">
    <h2 class="text-center">Iniciar Sesión</h2>
    <?php
    if (!empty($error)) {
        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="username" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Introduce tu usuario" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </div>
    </form>
    <div class="text-center mt-3">
      <p>¿No tienes cuenta? <a href="crearcuenta.html">Crea una aquí</a></p>
    </div>
  </div>

  <!-- Bootstrap JS y dependencias -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
