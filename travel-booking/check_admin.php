<?php
require 'includes/db.php';
$res = mysqli_query($conn, "SELECT * FROM users WHERE role = 'admin'");
while ($row = mysqli_fetch_assoc($res))
    print_r($row);
