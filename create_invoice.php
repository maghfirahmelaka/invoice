<?php
require_once 'functions.php';
require_login();
// load customers
$custRes = $mysqli->query('SELECT id,name FROM customers ORDER BY name');
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_id'])){
    $customer_id = intval($_POST['customer_id']);
    $date = $_POST['date'] ?: date('Y-m-d');
    $due_date = $_POST['due_date'] ?: null;
    $items = $_POST['items_json']; // expected JSON from form
    $notes = $mysqli->real_escape_string($_POST['notes']);
    $sub = floatval($_POST['sub_total']);
    $tax = floatval($_POST['tax']);
    $total = floatval($_POST['total']);
    $mysqli->query("INSERT INTO invoices (invoice_no,customer_id,date,due_date,items,sub_total,tax,total,notes) VALUES ('', $customer_id, '$date', ".($due_date ? "'$due_date'" : 'NULL').", '".$mysqli->real_escape_string($items)."', $sub, $tax, $total, '$notes')");
    $id = $mysqli->insert_id;
    $invoice_no = generate_invoice_no($id);
    $mysqli->query("UPDATE invoices SET invoice_no='$invoice_no' WHERE id=$id");
    flash('Invois disimpan.');
    header('Location: view_invoice.php?id='.$id);
    exit;
}
?>
<!doctype html>
<html><head><meta charset='utf-8'><title>Buat Invois - MKM Travel</title><link rel='stylesheet' href='assets/style.css'></head><body>
<div class='topbar'><div class='brand'><?php echo COMPANY_NAME; ?></div><div class='toplinks'><a href='dashboard.php'>Dashboard</a> | <a href='customers.php'>Customer</a> | <a href='invoices.php'>Invois</a> | <a href='logout.php'>Log Keluar</a></div></div>
<div class='container'>
  <h2>Buat Invois</h2>
  <form method='post' onsubmit='prepareItems()' class='card'>
    <label>Customer</label>
    <select name='customer_id' id='customer_id' required>
      <option value=''>-- Pilih Customer --</option>
      <?php while($r=$custRes->fetch_assoc()): ?>
        <option value='<?php echo $r['id']; ?>'><?php echo htmlspecialchars($r['name']); ?></option>
      <?php endwhile; ?>
    </select>
    <label>Tarikh</label><input type='date' name='date' value='<?php echo date('Y-m-d'); ?>'>
    <label>Due Date</label><input type='date' name='due_date'>
    <h4>Item</h4>
    <table class='table' id='items_table'>
      <thead><tr><th>Deskripsi</th><th>Kuantiti</th><th>Harga (RM)</th><th></th></tr></thead>
      <tbody></tbody>
    </table>
    <button type='button' class='btn' onclick='addItem()'>Tambah Item</button>
    <div class='right'>
      <p>Sub-total: <span id='sub'>0.00</span></p>
      <p>Cukai: <input type='number' id='tax' name='tax' value='0' step='0.01' onchange='recalc()'> RM</p>
      <p><strong>Total: <span id='total'>0.00</span></strong></p>
    </div>
    <label>Nota</label><textarea name='notes'></textarea>
    <input type='hidden' name='items_json' id='items_json'>
    <input type='hidden' name='sub_total' id='sub_total'>
    <input type='hidden' name='total' id='total_input'>
    <button class='btn' type='submit'>Simpan & Lihat</button>
  </form>
</div>
<script>
function addItem(desc='',qty=1,price=0){
  let tbody = document.querySelector('#items_table tbody');
  let tr = document.createElement('tr');
  tr.innerHTML = `<td><input class='full' value='${desc}'></td>
                  <td><input class='qty' type='number' value='${qty}' min='1'></td>
                  <td><input class='price' type='number' value='${price}' step='0.01'></td>
                  <td><button type='button' onclick='this.closest("tr").remove();recalc();'>Buang</button></td>`;
  tbody.appendChild(tr);
  recalc();
}
function recalc(){
  let rows = document.querySelectorAll('#items_table tbody tr');
  let sub = 0;
  rows.forEach(r=>{
    let q = parseFloat(r.querySelector('.qty').value||0);
    let p = parseFloat(r.querySelector('.price').value||0);
    sub += q*p;
  });
  document.getElementById('sub').innerText = sub.toFixed(2);
  document.getElementById('sub_total').value = sub.toFixed(2);
  let tax = parseFloat(document.getElementById('tax').value||0);
  let total = sub + tax;
  document.getElementById('total').innerText = total.toFixed(2);
  document.getElementById('total_input').value = total.toFixed(2);
}
function prepareItems(){
  let rows = document.querySelectorAll('#items_table tbody tr');
  let arr = [];
  rows.forEach(r=>{
    arr.push({
      desc: r.querySelector('input').value,
      qty: parseFloat(r.querySelector('.qty').value||0),
      price: parseFloat(r.querySelector('.price').value||0)
    });
  });
  document.getElementById('items_json').value = JSON.stringify(arr);
}
// add one sample item
addItem('Contoh Pakej Umrah (10 hari 8 malam)',1,5990.00);
</script>
</body></html>