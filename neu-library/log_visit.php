<?php
include 'db.php';

if (isset($_POST['user_id']) && isset($_POST['purpose'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);

    // Insert the visit into the 'logs' table
    $sql = "INSERT INTO logs (user_id, purpose) VALUES ('$user_id', '$purpose')";

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Visit Logged - NEU Library</title>
        <style>
            /* 1. Matches index.php Background */
            body { 
                background-color: #f5f5f0; 
                font-family: 'Times New Roman', serif; 
                display: flex; 
                justify-content: center; 
                align-items: center; 
                height: 100vh; 
                width: 100vw;
                margin: 0; 
                overflow: hidden;
            }

            /* 2. Matches index.php Full-Screen Container */
            .container { 
                background: white; 
                width: 90vw;
                height: 85vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                border-radius: 60px; 
                box-shadow: 0 20px 50px rgba(0,0,0,0.05); 
                text-align: center; 
                position: relative;
            }

            /* 3. The Big Checkmark Icon */
            .success-icon {
                width: 180px;
                height: 180px;
                background-color: #555d42;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 40px;
                box-shadow: 0 10px 30px rgba(85, 93, 66, 0.2);
            }

            .checkmark {
                color: white;
                font-size: 100px;
                font-family: Arial, sans-serif;
                font-weight: bold;
            }

            /* 4. Massive Typography */
            h1 { 
                color: #1a1a1a; 
                font-weight: 400; 
                font-size: 4.5rem;
                margin: 0;
            }

            p { 
                color: #888; 
                font-style: italic;
                font-size: 2rem;
                margin-top: 10px;
            }

            .loader-text {
                margin-top: 50px;
                font-size: 1.2rem;
                color: #555d42;
                letter-spacing: 3px;
                text-transform: uppercase;
                font-weight: bold;
                opacity: 0.7;
            }

            /* Branding Footer */
            .school-footer {
                position: absolute;
                bottom: 40px;
                font-size: 1.2rem;
                color: #555d42;
                letter-spacing: 6px;
                font-weight: bold;
                opacity: 0.6;
            }
        </style>
    </head>
    <body>";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='container'>
                <div class='success-icon'>
                    <div class='checkmark'>✓</div>
                </div>
                <h1>Visit Logged!</h1>
                <p>Enjoy your stay at the NEU Library.</p>
                <div class='loader-text'>Redirecting to Home...</div>
                <div class='school-footer'>NEW ERA UNIVERSITY</div>
              </div>";

        // Redirect back to index.php after 3 seconds
        header("refresh:3; url=index.php");
    } else {
        echo "<div class='container' style='border: 5px solid #8b0000;'>
                <h1 style='color: #8b0000;'>Error</h1>
                <p>" . mysqli_error($conn) . "</p>
                <a href='index.php' style='color: #555d42; font-size: 1.5rem; text-decoration: none; margin-top: 20px;'>Go Back</a>
                <div class='school-footer'>NEW ERA UNIVERSITY</div>
              </div>";
    }

    echo "</body></html>";
}
