<?php
session_start();
include 'data/dbUsers.php';
$error = "";

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);

  if ($user && password_verify($pass, $user['password'])) {
    $_SESSION['id'] = $user['id'];
    header("Location: index.php");
    exit();
  } else {
    $error = "Wrong email or password";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      width: min(520px, 95%);
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
    }

    h1 {
      margin-bottom: 24px;
      color: #0f766e;
      text-align: center;
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

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      font: inherit;
      font-size: 14px;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #0f766e;
      box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1);
    }

    .error {
      margin-bottom: 16px;
      padding: 10px 12px;
      border-radius: 8px;
      background: #fee2e2;
      color: #991b1b;
      font-size: 14px;
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

    .helper-link {
      display: block;
      margin-top: 16px;
      text-align: center;
      color: #0f766e;
      text-decoration: none;
      font-weight: 600;
    }

    .helper-link:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Login</h1>

    <?php if ($error) { ?>
      <div class="error">
        <?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
      </div>
    <?php } ?>

    <form method="post">
      <div class="form-group">
        <label for="emailInput">Email</label>
        <input type="email" id="emailInput" name="email" placeholder="Enter email" autocomplete="off" required>
      </div>

      <div class="form-group">
        <label for="passwordInput">Password</label>
        <input type="password" id="passwordInput" name="password" placeholder="Password" required>
      </div>

      <button type="submit" name="submit">Login</button>
      <a href="register.php" class="helper-link">Don't have an account? Register here</a>
    </form>
  </div>
</body>

</html>