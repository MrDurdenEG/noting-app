<?php
$conn = new mysqli("localhost", "root", "root", "note_app");
if (!$conn) {
  die(mysqli_error($conn));
}
