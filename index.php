<?php
include "auth.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Note Taking Application</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Segoe UI", Tahoma, sans-serif;
      background: linear-gradient(145deg, #f5f7fb, #e6edf7);
      color: #1f2937;
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      width: min(600px, 95%);
      margin: 0 auto;
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    h1 {
      margin-bottom: 24px;
      color: #0f766e;
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #374151;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font: inherit;
      font-size: 14px;
    }

    input[type="text"]:focus,
    textarea:focus {
      outline: none;
      border-color: #0f766e;
      box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
    }

    textarea {
      resize: vertical;
      min-height: 180px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #0f766e;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.2s;
    }

    button:hover {
      background: #0d5f58;
    }

    button:active {
      transform: scale(0.98);
    }

    .notes {
      margin-top: 20px;
    }

    .note {
      padding: 16px;
      background: #f9fafb;
      border-left: 4px solid #0f766e;
      margin-bottom: 12px;
      border-radius: 4px;
      position: relative;
    }

    .note h3 {
      color: #0f766e;
      margin-bottom: 8px;
      font-size: 18px;
      padding-right: 60px;
    }

    .note p {
      color: #4b5563;
      line-height: 1.6;
      white-space: pre-wrap;
    }

    .delete-btn {
      position: absolute;
      top: 16px;
      right: 16px;
      padding: 6px 12px;
      background: #dc2626;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 13px;
      cursor: pointer;
      transition: background 0.2s;
      width: auto;
    }

    .delete-btn:hover {
      background: #b91c1c;
    }

    hr {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 20px 0;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .logout-btn {
      padding: 8px 16px;
      background: #6b7280;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none;
      display: inline-block;
    }

    .logout-btn:hover {
      background: #4b5563;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>Create a New Note</h1>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <form method="POST" action="data/notes.php">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" placeholder="Enter note title" maxlength="120" required>
      </div>

      <div class="form-group">
        <label for="content">Content:</label>
        <textarea id="content" name="content" placeholder="Enter your note content here" rows="8" maxlength="5000"
          required></textarea>
      </div>

      <button type="submit">Add To Note</button>
    </form>
    <br>
    <hr>
    <h1>my notes</h1><br>
    <div class="notes">
      <?php
      include "data/db.php";
      $user_id = $_SESSION['id'];
      $stmt = mysqli_prepare($conn, "SELECT * FROM notes WHERE user_id = ? ORDER BY id DESC");
      mysqli_stmt_bind_param($stmt, "i", $user_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $title = htmlspecialchars($row['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
          $content = htmlspecialchars($row['content'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
          echo "<div class='note'>";
          echo "<form method='POST' action='data/delete.php'>";
          echo "<input type='hidden' name='id' value='$id'>";
          echo "<button type='submit' class='delete-btn'>Delete</button>";
          echo "</form>";
          echo "<h3>$title</h3>";
          echo "<p>$content</p>";
          echo "</div>";
        }
      } else {
        echo "<p>No notes found.</p>";
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
      ?>
    </div>
  </div>
</body>

</html>