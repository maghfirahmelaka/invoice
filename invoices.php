<?php
require_once 'functions.php';
require_login();
$res = $mysqli->query('SELECT i.*, c.name as customer_name FROM invoices i JOIN customers c ON i.customer_id=c.id ORDER BY i.id DESC');
?>
<!doctype html><html><head><meta charset='utf-8'><title>Invois - MKM Travel</title><link rel='stylesheet' href='assets/style.css'></head><body>
<div class='topbar'><div class='brand'><?php echo COMPANY_NAME; ?></div><div class='toplinks'><a href='dashboard.php'>Dashboard</a> | <a href='customers.php'>Customer</a> | <a href='create_invoice.php'>Buat Invois</a> | <a href='logout.php'>Log Keluar</a></div></div>
<div class='container'><h2>Senarai Invois</h2><div class='card'><table class='table'><thead><tr><th>#</th><th>No Invois</th><th>Customer</th><th>Tarikh</th><th>Total (RM)</th><th>Status</th><th></th></tr></thead><tbody><?php while($i=$res->fetch_assoc()): ?><tr><td><?php echo $i['id']; ?></td><td><?php echo $i['invoice_no']; ?></td><td><?php echo htmlspecialchars($i['customer_name']); ?></td><td><?php echo $i['date']; ?></td><td><?php echo number_format($i['total'],2); ?></td><td><?php echo $i['status']; ?></td><td><a href='view_invoice.php?id=<?php echo $i['id']; ?>' class='btn small'>Lihat</a></td></tr><?php endwhile; ?></tbody></table></div></div></body></html>