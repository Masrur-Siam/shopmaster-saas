<?php include('config.php'); if(!isset($_SESSION['user_id'])) header("Location: login.php"); $uid = $_SESSION['user_id'];
if(isset($_POST['add'])){
    $img = time()."_".$_FILES['img']['name']; move_uploaded_file($_FILES['img']['tmp_name'], "uploads/".$img);
    mysqli_query($conn, "INSERT INTO products (user_id, product_name, price, stock_qty, image) VALUES ($uid, '{$_POST['n']}', '{$_POST['p']}', '{$_POST['q']}', '$img')");
    header("Location: inventory.php");
}
if(isset($_GET['del'])){ mysqli_query($conn, "DELETE FROM products WHERE id={$_GET['del']} AND user_id=$uid"); header("Location: inventory.php"); }
?>
<!DOCTYPE html>
<html>
<head><title>Inventory</title><link rel="stylesheet" href="style.css"></head>
<body>
<div class="container">
    <div class="nav-bar"><a href="dashboard.php" class="btn-outline">← Back</a><h2>Inventory</h2></div>
    <div class="glass-panel">
        <form method="POST" enctype="multipart/form-data" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap:15px;">
            <input type="text" name="n" placeholder="Product Name" required>
            <input type="number" name="p" placeholder="Price" required>
            <input type="number" name="q" placeholder="Qty" required>
            <input type="file" name="img" required>
            <button type="submit" name="add">Add Product</button>
        </form>
    </div>
    <div class="glass-panel">
        <input type="text" id="src" onkeyup="search()" placeholder="Search your stock..." style="border-radius:25px; padding:15px 25px;">
        <table id="tbl">
            <tr><th>Image</th><th>Name</th><th>Price</th><th>Stock</th><th>Action</th></tr>
            <?php $res = mysqli_query($conn, "SELECT * FROM products WHERE user_id=$uid ORDER BY id DESC");
            while($r = mysqli_fetch_assoc($res)) echo "<tr><td><img src='uploads/{$r['image']}' class='img-thumb'></td><td class='n'>{$r['product_name']}</td><td>{$r['price']} TK</td><td>{$r['stock_qty']}</td><td><a href='inventory.php?del={$r['id']}' style='color:var(--danger);'>Delete</a></td></tr>"; ?>
        </table>
    </div>
</div>
<script>
function search() {
    let f = document.getElementById('src').value.toUpperCase();
    let tr = document.getElementById('tbl').getElementsByTagName('tr');
    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByClassName('n')[0];
        tr[i].style.display = td.innerText.toUpperCase().indexOf(f) > -1 ? "" : "none";
    }
}
</script>
</body>
</html>