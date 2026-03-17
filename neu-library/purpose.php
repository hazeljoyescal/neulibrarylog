<?php
include 'db.php';
$user_id = $_GET['id']; // Passed from the tap/email check

// Fetch user details to display (Output 1)
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_query);

if (!$user) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Select Purpose - NEU Library</title>
    <style>
        body {
            background-color: #f5f5f0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 500px;
        }

        .user-info {
            margin-bottom: 30px;
            padding: 20px;
            background: #fafafa;
            border-radius: 15px;
            border-left: 5px solid #555d42;
        }

        .user-info h2 {
            color: #555d42;
            margin: 0;
        }

        .user-info p {
            color: #888;
            margin: 5px 0 0;
        }

        .purpose-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-purpose {
            background: white;
            border: 2px solid #555d42;
            color: #555d42;
            padding: 20px;
            border-radius: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-purpose:hover {
            background: #555d42;
            color: white;
        }
    </style>
</head>

<body>

    <div class="card">
        <h1>Welcome to NEU Library!</h1>

        <div class="user-info">
            <h2><?php echo $user['name']; ?></h2>
            <p><?php echo $user['college']; ?></p>
        </div>

        <p>Please select the purpose of your visit:</p>

        <form action="save_log.php" method="POST" class="purpose-grid">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <button type="submit" name="purpose" value="Reading Books" class="btn-purpose">📚 Reading Books</button>
            <button type="submit" name="purpose" value="Thesis Research" class="btn-purpose">🎓 Thesis Research</button>
            <button type="submit" name="purpose" value="Computer Use" class="btn-purpose">💻 Computer Use</button>
            <button type="submit" name="purpose" value="Assignments" class="btn-purpose">📝 Doing Assignments</button>
        </form>
    </div>

</body>

</html>