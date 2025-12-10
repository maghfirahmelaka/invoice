<?php
require_once 'functions.php';
require_login();
$id = intval($_GET['id'] ?? 0);
if($_SERVER['REQUEST_METHOD']==='POST'){
    $invoice_id = intval($_POST['invoice_id']);
    $amount = floatval($_POST['amount']);
    $method = $mysqli->real_escape_string($_POST['method']);
    $note = $mysqli->real_escape_string($_POST['note']);
    $mysqli->query("INSERT INTO payments (invoice_id,amount,method,note) VALUES ($invoice_id, $amount, '$method', '$note')");
    // update invoice status simply
    $pRes = $mysqli->query("SELECT SUM(amount) as paid FROM payments WHERE invoice_id=$invoice_id");
    $paid = $pRes->fetch_assoc()['paid'] ?? 0;
    $iRes = $mysqli->query("SELECT total FROM invoices WHERE id=$invoice_id");
    $total = $iRes->fetch_assoc()['total'];
    $status = 'Partially Paid';
    if($paid >= $total) $status = 'Paid';
    $mysqli->query("UPDATE invoices SET status='$status' WHERE id=$invoice_id");
    header('Location: view_invoice.php?id='.$invoice_id);
    exit;
}
$res = $mysqli->query("SELECT i.*, c.name as customer_name FROM invoices i JOIN customers c ON i.customer_id=c.id WHERE i.id=$id");
if(!$res || $res->num_rows==0){ flash('Invois tidak ditemui.'); header('Location: invoices.php'); exit; }
$inv = $res->fetch_assoc();
?>
<!doctype html><html><head><meta charset='utf-8'><title>Rekod Pembayaran - MKM Travel</title><link rel='stylesheet' href='assets/style.css'></head><body>
<div class='topbar'><div class='brand'><?php echo COMPANY_NAME; ?></div><div class='toplinks'><a href='view_invoice.php?id=<?php echo $id; ?>'>Kembali</a></div></div>
<div class='container'><h2>Rekod Pembayaran untuk <?php echo $inv['invoice_no']; ?></h2>
  <form method='post' class='card'>
    <input type='hidden' name='invoice_id' value='<?php echo $id; ?>'>
    <label>Jumlah (RM)</label><input name='amount' required>
    <label>Kaedah</label><input name='method' placeholder='Tunai / Bank Transfer / Credit Card'>
    <label>Nota</label><textarea name='note'></textarea>
    <button class='btn' type='submit'>Simpan & Buat Resit</button>
  </form>
</div></body></html>