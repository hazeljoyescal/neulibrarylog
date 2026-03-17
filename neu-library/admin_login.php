<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check against the admins table
    $query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
    } else {
        $error = "Invalid credentials. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - NEU Library</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f0;
            /* Original beige background */
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 420px;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .logo {
            width: 80px;
            margin-bottom: 15px;
        }

        h1 {
            color: #555d42;
            font-size: 1.8rem;
            margin: 0;
            font-weight: 700;
        }

        .subtitle {
            color: #888;
            font-size: 0.95rem;
            margin-top: 5px;
            margin-bottom: 40px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: 700;
            color: #555d42;
            margin-bottom: 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #555d42;
            font-size: 1rem;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 14px 14px 48px;
            border: 1px solid #f0f0f0;
            background: #fafafa;
            border-radius: 12px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .input-wrapper input:focus {
            border-color: #555d42;
            background: white;
            box-shadow: 0 0 0 4px rgba(85, 93, 66, 0.1);
        }

        .sign-in-btn {
            width: 100%;
            background: #555d42;
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            transition: 0.3s;
        }

        .sign-in-btn:hover {
            background: #434a34;
            transform: translateY(-2px);
        }

        .error-msg {
            color: #d9534f;
            font-size: 0.85rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .return-link {
            margin-top: 35px;
            display: block;
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .return-link:hover {
            color: #555d42;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <img src="images.png" class="logo" alt="NEU Logo">
        <h1>Admin Portal</h1>
        <p class="subtitle">Library Management System</p>

        <?php if (isset($error)) echo "<p class='error-msg'><i class='fas fa-exclamation-circle'></i> $error</p>"; ?>

        <form action="admin_login.php" method="POST">
            <div class="input-group">
                <label>Admin Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Enter Username" required>
                </div>
            </div>

            <div class="input-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter Password" required>
                </div>
            </div>

            <button type="submit" name="login" class="sign-in-btn">
                Sign In <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <a href="index.php" class="return-link"><i class="fas fa-arrow-left"></i> Return to Main Page</a>
    </div>

</body>

</html>