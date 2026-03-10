<?php
session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
  header("Location: ../login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = intval($_POST['id']);
  $user_id = $_SESSION['id'];

  $stmt = mysqli_prepare($conn, "DELETE FROM notes WHERE id = ? AND user_id = ?");
  mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);

  if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: ../index.php");
    exit();
  } else {
    echo "Error deleting note: " . mysqli_error($conn);
  }
} else {
  header("Location: ../index.php");
  exit();
}

mysqli_close($conn);
