<?php
$conn = new mysqli("localhost", "root", "", "note_app");
if (!$conn) {
  die(mysqli_error($conn));
}