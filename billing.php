<?php include('config.php'); if(!isset($_SESSION['user_id'])) header("Location: login.php"); $uid = $_SESSION['user_id'];
if(isset($_POST['sell'])){
    $pid = $_POST['pid']; $q = $_POST['q'];
    $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$pid AND user_id=$uid"));
    if($p['stock_qty'] >= $q){
        $total = $p['price'] * $q;
        mysqli_query($conn, "INSERT INTO sales (user_id, product_id, qty_sold, total_price) VALUES ($uid, $pid, $q, $total)");
        mysqli_query($conn, "UPDATE products SET stock_qty = stock_qty - $q WHERE id=$pid");
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Billing</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <div class="nav-bar"><a href="dashboard.php" class="btn-outline">← Back</a><h2>New Sale</h2></div>
    <div class="glass-panel">
        <form method="POST" style="display:flex; gap:15px;">
            <select name="pid" required><option value="">Select Product</option>
            <?php $ps = mysqli_query($conn, "SELECT * FROM products WHERE user_id=$uid AND stock_qty > 0");
            while($p = mysqli_fetch_assoc($ps)) echo "<option value='{$p['id']}'>{$p['product_name']} ({$p['stock_qty']})</option>"; ?>
            </select>
            <input type="number" name="q" placeholder="Qty" required>
            <button type="submit" name="sell">Complete Bill</button>
        </form>
    </div>
    <div class="glass-panel">
        <h3>Recent Sales Log</h3>
        <table>
            <tr><th>Product</th><th>Qty</th><th>Total</th><th>Date</th></tr>
            <?php $sls = mysqli_query($conn, "SELECT sales.*, products.product_name FROM sales JOIN products ON sales.product_id = products.id WHERE sales.user_id=$uid ORDER BY sales.id DESC");
            while($s = mysqli_fetch_assoc($sls)) echo "<tr><td>{$s['product_name']}</td><td>{$s['qty_sold']}</td><td>{$s['total_price']} TK</td><td>".date('d M', strtotime($s['sale_date']))."</td></tr>"; ?>
        </table>
    </div>
</div>
</body>
</html>