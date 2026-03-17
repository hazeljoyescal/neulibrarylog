<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEU Library - Tap Entry</title>
    <style>
        /* General Body Styling - Original Beige/White */
        body {
            background-color: #f5f5f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding-top: 80px;
            /* Space for fixed navbar */
        }

        /* Navigation Bar Styling */
        .navbar {
            background-color: #ffffff;
            width: 100%;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .nav-brand {
            font-weight: bold;
            color: #555d42;
            /* Original Olive Green */
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-item {
            text-decoration: none;
            color: #888;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.3s;
            padding-right: 10px;
        }

        .nav-item:hover,
        .nav-item.active {
            color: #555d42;
            /* Original Olive Green */
        }

        /* Admin Login Button - Original Olive Green Theme */
        .admin-login-btn {
            background-color: #555d42;
            color: #ffffff !important;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background-color 0.3s, transform 0.2s;
        }

        .admin-login-btn:hover {
            background-color: #434a34;
            /* Darker Olive */
            transform: translateY(-1px);
        }

        /* Login Card Styling */
        .login-card {
            background: white;
            padding: 50px;
            border-radius: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
            text-align: center;
            width: 400px;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        h1 {
            color: #555d42;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        p {
            color: #888;
            margin-bottom: 30px;
        }

        .input-field {
            width: 100%;
            padding: 15px;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            font-size: 1.1rem;
            text-align: center;
            outline: none;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: #555d42;
            /* Olive Green Focus */
        }

        .toggle-link {
            display: block;
            margin-top: 20px;
            color: #555d42;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">NEU Library</div>
            <div class="nav-links">
                <a href="index.php" class="nav-item active">Home</a>
                <a href="admin_login.php" class="admin-login-btn">Admin Login</a>
            </div>
        </div>
    </nav>

    <div class="login-card">
        <img src="images.png" class="logo" alt="NEU Logo">
        <h1>Welcome to NEU Library!</h1>
        <p id="instruction-text">Please tap your School ID</p>

        <form action="check_id.php" method="POST">
            <input type="text"
                name="student_id"
                id="login-input"
                class="input-field"
                placeholder="Waiting for tap..."
                autofocus
                required>

            <button type="submit" class="hidden"></button>
        </form>

        <a class="toggle-link" onclick="toggleLoginType()" id="toggle-btn">Use Institutional Email</a>
    </div>

    <script>
        function toggleLoginType() {
            const input = document.getElementById('login-input');
            const text = document.getElementById('instruction-text');
            const btn = document.getElementById('toggle-btn');

            if (input.placeholder === "Waiting for tap...") {
                input.placeholder = "Enter email";
                text.innerText = "Please enter your Institutional Email";
                btn.innerText = "Switch back to ID Tap";
                input.type = "email";
            } else {
                input.placeholder = "Waiting for tap...";
                text.innerText = "Please tap your School ID";
                btn.innerText = "Use Institutional Email";
                input.type = "text";
            }
            input.focus();
        }
    </script>

</body>

</html>