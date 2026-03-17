<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db.php';

// Get the filter from URL, default to 'today'
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'today';

// 1. Dynamic Statistics Logic
if ($filter == 'week') {
    $stats_query = "SELECT COUNT(*) as total FROM logs WHERE YEARWEEK(visit_date, 1) = YEARWEEK(CURDATE(), 1)";
    $label = "This Week";
} elseif ($filter == 'month') {
    $stats_query = "SELECT COUNT(*) as total FROM logs WHERE MONTH(visit_date) = MONTH(CURDATE()) AND YEAR(visit_date) = YEAR(CURDATE())";
    $label = "This Month";
} else {
    $stats_query = "SELECT COUNT(*) as total FROM logs WHERE DATE(visit_date) = CURDATE()";
    $label = "Today";
}

$stats_query_run = mysqli_query($conn, $stats_query);
$stats_res = mysqli_fetch_assoc($stats_query_run);

// 2. Fetch Recent Visitors
$logs_query = "SELECT logs.*, users.name, users.college FROM logs 
               JOIN users ON logs.user_id = users.id 
               ORDER BY visit_date DESC LIMIT 10";
$logs_res = mysqli_query($conn, $logs_query);

// 3. Handle Blocking
if (isset($_GET['block'])) {
    $block_id = mysqli_real_escape_string($conn, $_GET['block']);
    mysqli_query($conn, "UPDATE users SET status='blocked' WHERE id='$block_id'");
    header("Location: admin.php?filter=$filter");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - NEU Library</title>
    <style>
        body {
            background-color: #f5f5f0;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            display: flex;
        }

        /* Sidebar - Original Olive Green */
        .sidebar {
            width: 250px;
            background: #555d42;
            height: 100vh;
            color: white;
            padding: 30px 20px;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
            letter-spacing: 1px;
        }

        .nav-links {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .nav-links li {
            padding: 15px 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            display: block;
            transition: 0.3s;
        }

        .nav-links a:hover {
            opacity: 1;
            padding-left: 5px;
        }

        /* Main Content */
        .main-content {
            margin-left: 270px;
            padding: 40px;
            width: calc(100% - 270px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #555d42;
            margin: 0;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #555d42;
        }

        .card h3 {
            margin: 0;
            color: #888;
            font-size: 0.9rem;
            text-transform: uppercase;
        }

        .card p {
            margin: 10px 0 0;
            font-size: 2.5rem;
            font-weight: bold;
            color: #555d42;
        }

        /* Table Styling */
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
            font-weight: bold;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f5f5f0;
            color: #444;
        }

        /* Buttons & Filters */
        select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            color: #555d42;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-report {
            background: #555d42;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-report:hover {
            background: #434a34;
        }

        .btn-block {
            color: #d9534f;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: bold;
            border: 1px solid #d9534f;
            padding: 6px 12px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-block:hover {
            background: #d9534f;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h2>NEU LIBRARY</h2>
        <ul class="nav-links">
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="blocked_list.php">Blocked List</a></li>
            <li style="margin-top: 50px;">
                <a href="logout.php" style="color: #ffbaba; font-weight: bold;">Logout</a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Library Statistics</h1>
            <div style="display: flex; gap: 15px; align-items: center;">
                <form method="GET" action="admin.php" id="filterForm">
                    <select name="filter" onchange="document.getElementById('filterForm').submit()">
                        <option value="today" <?php if ($filter == 'today') echo 'selected'; ?>>Today</option>
                        <option value="week" <?php if ($filter == 'week') echo 'selected'; ?>>This Week</option>
                        <option value="month" <?php if ($filter == 'month') echo 'selected'; ?>>This Month</option>
                    </select>
                </form>
                <a href="generate_report.php?range=<?php echo $filter; ?>" class="btn-report">Download <?php echo ucfirst($filter); ?> PDF</a>
            </div>
        </div>

        <div class="stats-grid">
            <div class="card">
                <h3>Total Visitors (<?php echo $label; ?>)</h3>
                <p><?php echo $stats_res['total']; ?></p>
            </div>
            <div class="card">
                <h3>System Status</h3>
                <p style="font-size: 1.5rem; color: #28a745;">ACTIVE</p>
            </div>
        </div>

        <div class="table-container">
            <h2 style="color: #555d42; margin-bottom: 20px;">Recent Entries</h2>
            <table>
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Name</th>
                        <th>College</th>
                        <th>Purpose</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($logs_res)) { ?>
                        <tr>
                            <td><?php echo date('h:i A', strtotime($row['visit_date'])); ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['college']; ?></td>
                            <td><?php echo $row['purpose']; ?></td>
                            <td>
                                <a href="admin.php?block=<?php echo $row['user_id']; ?>"
                                    class="btn-block"
                                    onclick="return confirm('Block this student?')">Block User</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>