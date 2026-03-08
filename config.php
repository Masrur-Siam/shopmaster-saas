<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shop_db");
if (!$conn) { die("Database Connection Failed"); }
?>