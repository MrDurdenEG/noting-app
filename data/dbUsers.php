<?php
$conn = new mysqli("db", "root", "root", "note_app_users");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}