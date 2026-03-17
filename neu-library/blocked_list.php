<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db.php';

// 1. Handle Unblocking Logic
if (isset($_GET['unblock'])) {
    $unblock_id = mysqli_real_escape_string($conn, $_GET['unblock']);
    mysqli_query($conn, "UPDATE users SET status='active' WHERE id='$unblock_id'");
    header("Location: blocked_list.php");
}

// 2. Fetch only blocked users
$blocked_query = "SELECT * FROM users WHERE status = 'blocked'";
$blocked_res = mysqli_query($conn, $blocked_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Blocked List - NEU Library</title>
    <style>
        body {
            background-color: #f5f5f0;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #555d42;
            height: 100vh;
            color: white;
            padding: 30px 20px;
            position: fixed;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            opacity: 0.8;
        }

        .sidebar a:hover {
            opacity: 1;
        }

        .main-content {
            margin-left: 290px;
            padding: 40px;
            width: calc(100% - 330px);
        }

        .table-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #f5f5f0;
            color: #555d42;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f5f5f0;
        }

        .btn-unblock {
            color: #28a745;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #28a745;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-unblock:hover {
            background: #28a745;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>NEU LIBRARY</h2>
        <a href="admin.php">← Back to Dashboard</a>
        <a href="logout.php" style="margin-top: 20px; color: #ffbaba;">Logout</a>
    </div>

    <div class="main-content">
        <h1>Restricted Access List</h1>
        <p>The following patrons are currently blocked from entering the library.</p>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($blocked_res) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($blocked_res)): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['college']; ?></td>
                                <td>
                                    <a href="blocked_list.php?unblock=<?php echo $row['id']; ?>"
                                        class="btn-unblock"
                                        onclick="return confirm('Restore library access for this student?')">Unblock User</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align:center;">No blocked users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>