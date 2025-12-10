<?php
require_once 'functions.php';
require_login();
$res = $mysqli->query('SELECT COUNT(*) as c FROM customers');
$customers = $res->fetch_assoc()['c'];
$res = $mysqli->query("SELECT COUNT(*) as c FROM invoices");
$invoices = $res->fetch_assoc()['c'];
$res = $mysqli->query("SELECT COUNT(*) as c FROM invoices WHERE status='Unpaid'");
$unpaid = $res->fetch_assoc()['c'];
$flash = get_flash();
?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<title>Dashboard - MKM Travel</title>
<link rel='stylesheet' href='assets/style.css'>
</head>
<body>
<div class='topbar'>
  <div class='brand'><?php echo COMPANY_NAME; ?></div>
  <div class='toplinks'>
    <a href='customers.php'>Customer</a> | 
    <a href='invoices.php'>Invois</a> | 
    <a href='create_invoice.php'>Buat Invois</a> | 
    <a href='logout.php'>Log Keluar</a>
  </div>
</div>
<div class='container'>
  <?php if($flash): ?><div class='alert'><?php echo $flash; ?></div><?php endif; ?>
  <div class='grid'>
    <div class='card stat'>
      <h3>Jumlah Customer</h3>
      <p class='big'><?php echo $customers; ?></p>
    </div>
    <div class='card stat'>
      <h3>Jumlah Invois</h3>
      <p class='big'><?php echo $invoices; ?></p>
    </div>
    <div class='card stat'>
      <h3>Invois Belum Dibayar</h3>
      <p class='big'><?php echo $unpaid; ?></p>
    </div>
  </div>
</div>
</body>
</html>