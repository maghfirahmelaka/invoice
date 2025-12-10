<?php
require_once 'functions.php';
require_login();
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['name'])){
    $name = $mysqli->real_escape_string($_POST['name']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $address = $mysqli->real_escape_string($_POST['address']);
    $idno = $mysqli->real_escape_string($_POST['identity_no']);
    $mysqli->query("INSERT INTO customers (name,phone,email,address,identity_no) VALUES ('$name','$phone','$email','$address','$idno')");
    flash('Customer ditambah.');
    header('Location: customers.php');
    exit;
}
$res = $mysqli->query('SELECT * FROM customers ORDER BY id DESC');
?>
<!doctype html>
<html><head><meta charset='utf-8'><title>Customers - MKM Travel</title><link rel='stylesheet' href='assets/style.css'></head><body>
<div class='topbar'><div class='brand'><?php echo COMPANY_NAME; ?></div><div class='toplinks'><a href='dashboard.php'>Dashboard</a> | <a href='invoices.php'>Invois</a> | <a href='create_invoice.php'>Buat Invois</a> | <a href='logout.php'>Log Keluar</a></div></div>
<div class='container'>
  <h2>Customer</h2>
  <form method='post' class='card'>
    <label>Nama</label><input name='name' required>
    <label>No Telefon</label><input name='phone'>
    <label>Email</label><input name='email' type='email'>
    <label>Alamat</label><textarea name='address'></textarea>
    <label>No IC / Passport</label><input name='identity_no'>
    <button class='btn' type='submit'>Tambah Customer</button>
  </form>
  <div class='card'>
    <h3>Senarai Customer</h3>
    <table class='table'>
      <thead><tr><th>ID</th><th>Nama</th><th>Telefon</th><th>Email</th><th>Tarikh</th></tr></thead>
      <tbody>
        <?php while($c = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $c['id']; ?></td>
            <td><?php echo htmlspecialchars($c['name']); ?></td>
            <td><?php echo htmlspecialchars($c['phone']); ?></td>
            <td><?php echo htmlspecialchars($c['email']); ?></td>
            <td><?php echo $c['created_at']; ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body></html>