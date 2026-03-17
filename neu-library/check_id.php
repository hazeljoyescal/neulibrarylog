<?php
include 'db.php';

if (isset($_POST['student_id'])) {
    $input = mysqli_real_escape_string($conn, $_POST['student_id']);

    // Updated Query: Search by ID OR Email, and fetch the status
    $query = "SELECT * FROM users WHERE id = '$input' OR email = '$input'";
    $result = mysqli_query($conn, $query);

    echo "<!DOCTYPE html><html lang='en'><head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body { background-color: #f5f5f0; font-family: 'Times New Roman', serif; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; overflow: hidden; }
        .container { background: white; width: 90vw; height: 85vh; border-radius: 60px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; position: relative; overflow: hidden; }
        .header { display: flex; justify-content: center; align-items: center; gap: 20px; padding: 20px; border-bottom: 2px solid #f5f5f0; color: #555d42; }
        .header-logo { width: 60px; height: 60px; object-fit: contain; }
        .header-text h2 { margin: 0; font-size: 1.8rem; letter-spacing: 2px; }
        .main-content { display: flex; flex: 1; padding: 20px 80px; align-items: center; gap: 40px; }
        .user-info { flex: 1.2; font-size: 1.3rem; line-height: 2.2; color: #1a1a1a; }
        .label { font-weight: bold; display: inline-block; width: 150px; color: #555d42; }
        .clock-container { flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; border-left: 2px solid #f5f5f0; }
        #clock { font-size: 4.5rem; font-weight: bold; color: #555d42; }
        .id-display-box { border: 3px solid #555d42; color: #555d42; padding: 8px 30px; font-size: 1.6rem; border-radius: 12px; font-weight: bold; }
        .bottom-section { padding: 25px; display: flex; justify-content: center; background: #fafafa; }
        .btn-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-top: 15px; }
        .btn { padding: 18px; border: none; border-radius: 12px; background: #555d42; color: white; font-weight: bold; cursor: pointer; font-size: 1rem; transition: 0.3s; }
        .btn:hover { background: #3e4430; transform: translateY(-3px); }
        .school-footer { position: absolute; bottom: 30px; width: 100%; text-align: center; font-size: 1.2rem; color: #555d42; letter-spacing: 6px; font-weight: bold; opacity: 0.5; }
    </style>
    </head><body onload='updateClock()'>";

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 1. CHECK IF USER IS BLOCKED
        if ($user['status'] == 'blocked') {
            echo "<script>
                alert('ACCESS RESTRICTED: Your account is currently blocked. Please proceed to the Librarian desk.');
                window.location.href='index.php';
            </script>";
            exit();
        }

        // 2. IF ACTIVE, SHOW TERMINAL
        echo "<div class='container'>
                <div class='header'>
                    <img src='images.png' class='header-logo' alt='Logo'>
                    <div class='header-text'>
                        <h2>NEW ERA UNIVERSITY</h2>
                        <p>No. 9 Central Ave, Quezon City | 2025-2026</p>
                    </div>
                </div>
                <div class='main-content'>
                    <div class='user-info'>
                        <p><span class='label'>Library ID:</span> " . $user['id'] . "</p>
                        <p><span class='label'>Name:</span> " . $user['name'] . "</p>
                        <p><span class='label'>College:</span> " . $user['college'] . "</p>
                        <p><span class='label'>Patron Type:</span> STUDENT</p>
                    </div>
                    <div class='clock-container'>
                        <div id='clock'>00:00:00</div>
                    </div>
                </div>
                <div class='bottom-section'>
                    <div class='purpose-selection'>
                        <form method='POST' action='log_visit.php' class='btn-grid'>
                            <input type='hidden' name='user_id' value='" . $user['id'] . "'>
                            <button type='submit' name='purpose' value='Reading' class='btn'>Reading Books</button>
                            <button type='submit' name='purpose' value='Thesis' class='btn'>Thesis Research</button>
                            <button type='submit' name='purpose' value='Computer' class='btn'>Computer Use</button>
                            <button type='submit' name='purpose' value='Assignment' class='btn'>Do Assignment</button>
                        </form>
                    </div>
                </div>
              </div>";
    } else {
        echo "<script>alert('ID or EMAIL NOT REGISTERED'); window.location.href='index.php';</script>";
    }

    echo "<script>
        function updateClock() {
            const clock = document.getElementById('clock');
            setInterval(() => {
                const now = new Date();
                clock.innerText = now.toLocaleTimeString('en-US', { hour12: true });
            }, 1000);
        }
    </script></body></html>";
}
