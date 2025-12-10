<?php
// index.php - login page
require_once 'config.php';
session_start();
$error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if($u === ADMIN_USER && $p === ADMIN_PASS){
        $_SESSION['user_logged'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password tidak betul.';
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<title>Login - MKM Travel Invoice System</title>
<link rel='stylesheet' href='assets/style.css'>
</head>
<body class='center'>
  <div class='card login-card'>
    <img src='assets/logo.png' alt='logo' class='logo'>
    <h2>MKM Travel Invoice System</h2>
    <?php if($error): ?><div class='alert'><?php echo $error; ?></div><?php endif; ?>
    <form method='post'>
      <label>Username</label>
      <input type='text' name='username' required>
      <label>Password</label>
      <input type='password' name='password' required>
      <button type='submit' class='btn'>Log Masuk</button>
    </form>
    <p class='muted'>Sila tukar credential di <code>config.php</code> selepas install.</p>
  </div>
</body>
</html>