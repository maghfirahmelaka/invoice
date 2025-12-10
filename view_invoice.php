<?php
require_once 'functions.php';
require_login();
$id = intval($_GET['id'] ?? 0);
$res = $mysqli->query("SELECT i.*, c.* FROM invoices i JOIN customers c ON i.customer_id=c.id WHERE i.id=$id");
if(!$res || $res->num_rows==0){
    flash('Invois tidak ditemui.');
    header('Location: invoices.php');
    exit;
}
$inv = $res->fetch_assoc();
$items = json_decode($inv['items'], true);
// fetch payments
$pRes = $mysqli->query("SELECT SUM(amount) as paid FROM payments WHERE invoice_id=$id");
$paid = $pRes->fetch_assoc()['paid'] ?? 0;
?>
<!doctype html><html><head><meta charset='utf-8'><title>Invois <?php echo $inv['invoice_no']; ?> - MKM Travel</title><link rel='stylesheet' href='assets/style.css'></head><body>
<div class='topbar'><div class='brand'><?php echo COMPANY_NAME; ?></div><div class='toplinks'><a href='invoices.php'>Kembali</a> | <a href='print_invoice.php?id=<?php echo $id; ?>' target='_blank'>Cetak / Save PDF</a></div></div>
<div class='container'><div class='card invoice'>
  <div class='head'><div class='company'><img src='<?php echo COMPANY_LOGO; ?>' class='logo-sm'><h3><?php echo COMPANY_NAME; ?></h3><p><?php echo COMPANY_ADDRESS; ?></p></div>
  <div class='meta'><p><strong>No Invois:</strong> <?php echo $inv['invoice_no']; ?></p><p><strong>Tarikh:</strong> <?php echo $inv['date']; ?></p><p><strong>Due:</strong> <?php echo $inv['due_date']; ?></p></div></div>
  <div class='to'><h4>Bill Kepada:</h4><p><?php echo htmlspecialchars($inv['name']); ?><br><?php echo nl2br(htmlspecialchars($inv['address'])); ?><br>Tel: <?php echo htmlspecialchars($inv['phone']); ?></p></div>
  <table class='table'><thead><tr><th>Deskripsi</th><th>Kuantiti</th><th>Harga (RM)</th><th>Jumlah</th></tr></thead><tbody><?php foreach($items as $it): ?><tr><td><?php echo htmlspecialchars($it['desc']); ?></td><td><?php echo $it['qty']; ?></td><td><?php echo number_format($it['price'],2); ?></td><td><?php echo number_format($it['qty']*$it['price'],2); ?></td></tr><?php endforeach; ?></tbody></table>
  <div class='right'><p>Sub-total: RM <?php echo number_format($inv['sub_total'],2); ?></p><p>Cukai: RM <?php echo number_format($inv['tax'],2); ?></p><p><strong>Total: RM <?php echo number_format($inv['total'],2); ?></strong></p><p>Dibayar: RM <?php echo number_format($paid,2); ?></p><p>Baki: RM <?php echo number_format($inv['total'] - $paid,2); ?></p></div>
  <div><h4>Nota:</h4><p><?php echo nl2br(htmlspecialchars($inv['notes'])); ?></p></div>
  <div class='actions'><a href='record_payment.php?id=<?php echo $id; ?>' class='btn'>Rekod Pembayaran / Buat Resit</a></div>
</div></div></body></html>