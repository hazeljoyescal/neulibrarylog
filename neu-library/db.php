<?php
// Database Configuration for InfinityFree
$host   = "sqlXXX.infinityfree.com"; // Get this from your 'MySQL Details' in the control panel
$user   = "if0_XXXXXXXX";           // Your 'MySQL Username'
$pass   = "YourAccountPassword";    // This is your ACCOUNT password (not 'root' or 'p@ssword')
$dbname = "if0_XXXXXXXX_neu_lib";   // InfinityFree forces a prefix on database names

// Establish Connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check Connection
if (!$conn) {
    // On a live site, it's safer to show a generic message
    die("Database Connection failed. Please try again later.");
}

mysqli_set_charset($conn, "utf8");
