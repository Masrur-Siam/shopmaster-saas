<?php include('config.php'); if(!isset($_SESSION['user_id'])) header("Location: login.php"); $uid = $_SESSION['user_id']; ?>
<!DOCTYPE html>
<html>
<head><title>Dashboard | ShopMaster</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <div class="nav-bar">
        <h3 style="color:var(--primary);">SHOPMASTER</h3>
        <a href="logout.php" class="btn-outline" style="border-color:var(--danger); color:var(--danger);">Logout</a>
    </div>
    <div class="welcome-card">
        <h1>Welcome Back, <?php echo $_SESSION['user_name']; ?>!</h1>
        <p>Manage your inventory and sales seamlessly.</p>
    </div>
    <div class="stat-grid">
        <div class="stat-card"><h4>Products</h4><h2><?php echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM products WHERE user_id=$uid"))['c']; ?></h2></div>
        <div class="stat-card" style="border-color:var(--success);"><h4>Revenue</h4><h2><?php echo number_format(mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) as s FROM sales WHERE user_id=$uid"))['s'], 2); ?></h2></div>
        <div class="stat-card" style="border-color:var(--danger);"><h4>Low Stock</h4><h2><?php echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as l FROM products WHERE user_id=$uid AND stock_qty < 5"))['l']; ?></h2></div>
    </div>
    <div style="display:grid; grid-template-columns: 2fr 1fr; gap:30px; margin-top:30px;">
        <div class="glass-panel">
            <h3>Recent Sales</h3>
            <table>
                <tr><th>Product</th><th>Qty</th><th>Total</th></tr>
                <?php $res = mysqli_query($conn, "SELECT sales.*, products.product_name FROM sales JOIN products ON sales.product_id = products.id WHERE sales.user_id=$uid ORDER BY sales.id DESC LIMIT 5");
                while($r = mysqli_fetch_assoc($res)) echo "<tr><td>{$r['product_name']}</td><td>{$r['qty_sold']}</td><td>{$r['total_price']} TK</td></tr>"; ?>
            </table>
        </div>
        <div>
            <a href="inventory.php" class="stat-card" style="display:block; text-decoration:none; margin-bottom:20px; border:none; background:var(--primary); color:white;"><h3>📦 Inventory</h3></a>
            <a href="billing.php" class="stat-card" style="display:block; text-decoration:none; border:none; background:var(--success); color:white;"><h3>🛒 New Sale</h3></a>
        </div>
    </div>
</div>
</body>
</html>