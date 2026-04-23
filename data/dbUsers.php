<?php
$conn = new mysqli("localhost", "root", "root", "note_app_users");
if (!$conn) {
  die(mysqli_error($conn));
}
