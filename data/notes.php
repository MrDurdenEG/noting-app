<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
  header("Location: ../login.php");
  exit();
}

$user_id = $_SESSION['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$stmt = mysqli_prepare($conn, "INSERT INTO notes (title, content, user_id) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $user_id);
$result = mysqli_stmt_execute($stmt);
if ($result) {
  mysqli_stmt_close($stmt);
  header("Location: ../index.php");
} else {
  echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
