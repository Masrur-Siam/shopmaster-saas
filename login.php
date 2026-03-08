<?php include('config.php'); ?>
<!DOCTYPE html>
<html>
<head><title>Login | ShopMaster</title><link rel="stylesheet" href="style.css"></head>
<body style="display:flex; align-items:center; height:100vh; background:#e9ecef;">
<div class="container" style="max-width:450px; background:white; padding:40px; border-radius:25px; box-shadow: 0 20px 50px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; margin-bottom:30px; color:var(--primary);">ShopMaster SaaS</h2>
    <?php
    if(isset($_POST['login'])){
        $e = mysqli_real_escape_string($conn, $_POST['email']); $p = $_POST['pass'];
        $u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='$e'"));
        if($u && password_verify($p, $u['password'])){
            $_SESSION['user_id'] = $u['id']; $_SESSION['user_name'] = $u['name']; header("Location: dashboard.php");
        } else { echo "<p style='color:red; text-align:center;'>Invalid Credentials</p>"; }
    }
    if(isset($_POST['reg'])){
        $n = $_POST['name']; $e = $_POST['email']; $p = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$n', '$e', '$p')");
        echo "<p style='color:green; text-align:center;'>Account Created! Login now.</p>";
    }
    ?>
    <form method="POST"><h3>Login</h3><input type="email" name="email" placeholder="Email" required><input type="password" name="pass" placeholder="Password" required><button type="submit" name="login" style="width:100%;">Enter Dashboard</button></form>
    <div style="text-align:center; margin:20px 0; color:#ccc;">OR</div>
    <form method="POST"><h3>Create Shop</h3><input type="text" name="name" placeholder="Shop Name" required><input type="email" name="email" placeholder="Email" required><input type="password" name="pass" placeholder="Password" required><button type="submit" name="reg" style="width:100%; background:var(--dark);">Sign Up</button></form>
</div>
</body>
</html>