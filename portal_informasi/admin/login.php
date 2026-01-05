<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "SELECT * FROM admin 
         WHERE username='$username' AND password='$password'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['admin'] = $data['username'];
        header("Location: admin.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
</head>
<body>

<h3>Login Admin</h3>

<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button name="login">Login</button>
</form>

</body>
</html>
