<?php
session_start();
require 'db_connect.php'; // Database connection

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details securely using prepared statements
$sql = "SELECT * FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle profile update securely
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $weight = $_POST['weight'];
    $height = $_POST['height'];

    // Validate weight and height (realistic values)
    if ($weight < 20 || $weight > 300 || $height < 100 || $height > 250) {
        $error_message = "Please enter a valid weight (20-300 kg) and height (100-250 cm).";
    } else {
        $update_sql = "UPDATE Users SET weight = ?, height = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ddi", $weight, $height, $user_id);

        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
            // Refresh the page to show updated values
            header('Location: profile.php?success=1');
            exit();
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937;
            color: #d1d5db;
            font-family: 'Arial', sans-serif;
        }
        .profile-container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 30px 40px;
            background-color: #2d3748;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        .profile-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
            color: #34a853;
        }
        .alert {
            text-align: center;
            font-size: 1rem;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }
        .alert-success {
            background-color: #34a853;
            color: white;
        }
        .alert-danger {
            background-color: #e74c3c;
            color: white;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 1rem;
            color: #a0aec0;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #4a5568;
            background-color: #1a202c;
            color: #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .input-group input:focus {
            outline: none;
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #34a853;
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        button:hover {
            background-color: #2c9c46;
            transform: scale(1.03);
        }
        .back-link, .track-progress-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a, .track-progress-link a {
            color: #34a853;
            text-decoration: none;
            font-size: 1rem;
        }
        .back-link a:hover, .track-progress-link a:hover {
            color: #2c9c46;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <h1>Profile Details</h1>

        <!-- Success or Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Profile updated successfully!</div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['name']); ?>" disabled>
            </div>

            <div class="input-group">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" value="<?php echo htmlspecialchars($user['weight']); ?>" min="30" max="300" required>
            </div>

            <div class="input-group">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" value="<?php echo htmlspecialchars($user['height']); ?>" min="100" max="250" required>
            </div>

            <button type="submit">Update Profile</button>
        </form>

        <!-- Track Progress Link -->
        <div class="track-progress-link">
            <p><a href="track_progress.php">Track Progress</a></p>
        </div>

        <div class="back-link">
            <p><a href="home.html">Back to Home</a></p>
        </div>
    </div>

</body>
</html>
