<?php

session_start();

require '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

if (!isset($_POST['rating'])) {
    die("Không nhận được đánh giá.");
}

$user_id = $_SESSION['user_id'];
$rating = (int) $_POST['rating'];

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO logout_reviews
    (
        user_id,
        rating
    )
    VALUES (?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $user_id,
    $rating
);

mysqli_stmt_execute($stmt);

session_destroy();

header("Location: ../login.php");
exit;