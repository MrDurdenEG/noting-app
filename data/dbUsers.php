<?php
$conn = new mysqli("localhost", "root", "", "note_app_users");
if (!$conn) {
  die(mysqli_error($conn));
}