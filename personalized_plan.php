<?php
session_start();
// You can include your logic here to check if the user is logged in, 
// or you can directly generate a fitness plan based on the input form.
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalized Fitness Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1f2937; /* Dark background */
            color: #d1d5db; /* Light text */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 30px 40px;
            background-color: #2d3748; /* Card background */
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        h1, .result {
            text-align: center;
        }

        h1 {
            color: #34a853; /* Accent green */
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label {
            color: #a0aec0;
            font-weight: 500;
        }
        .form-control, .form-select {
            background-color: #1a202c;
            color: #d1d5db;
            border: 1px solid #4a5568;
            border-radius: 8px;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #34a853;
            box-shadow: 0 0 8px rgba(52, 168, 83, 0.6);
        }

        .btn-submit {
            background-color: #16a085;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #1abc9c;
        }

        .fitness-plan-result {
            margin-top: 30px;
            background-color: #34495e;
            color: #ecf0f1;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .fitness-plan-result h3 {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .exercise-section {
            margin-top: 20px;
        }

        .exercise {
            margin-bottom: 20px;
        }

        .exercise h5 {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .exercise p {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .exercise ul {
            list-style-type: none;
            padding-left: 0;
        }

        .exercise ul li {
            margin-bottom: 10px;
        }

        .exercise ul li strong {
            color: #16a085;
        }

        .home-btn {
            background-color: #16a085;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            padding: 10px 20px;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .home-btn:hover {
            background-color: #1abc9c;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Get Your Personalized Fitness Plan</h1>

        <!-- Fitness Plan Input Form -->
        <div class="form-section">
            <form action="personalized_plan.php" method="POST">
                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control" id="age" name="age" required>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" class="form-control" id="height" name="height" required>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control" id="weight" name="weight" required>
                </div>
                <div class="mb-3">
                    <label for="activity" class="form-label">Activity Level</label>
                    <select class="form-control" id="activity" name="activity" required>
                        <option value="sedentary">Sedentary</option>
                        <option value="active">Active</option>
                        <option value="very_active">Very Active</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="goal" class="form-label">Fitness Goal</label>
                    <select class="form-control" id="goal" name="goal" required>
                        <option value="weight_loss">Weight Loss</option>
                        <option value="muscle_gain">Muscle Gain</option>
                        <option value="maintain">Maintain Weight</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit w-100">Generate Fitness Plan</button>
            </form>
        </div>

        <!-- Display Personalized Plan -->
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Handle form submission and calculate personalized fitness plan
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $activity = $_POST['activity'];
            $goal = $_POST['goal'];

            // Displaying the User Input
            
            echo "<hr>";
            echo "<h5>Suggested Workout Plan</h5>";

            // Example workout based on activity level
            echo "<div class='exercise-section'>";

            if ($activity == "sedentary") {
                echo "<div class='exercise'>";
                echo "<h5>Beginner Routine (Sedentary)</h5>";
                echo "<p>For those who are just starting, focus on light cardio and bodyweight exercises to build a foundation.</p>";
                echo "<ul>";
                echo "<li><strong>Bodyweight Squats:</strong> 3 sets of 12 reps</li>";
                echo "<li><strong>Push-ups:</strong> 3 sets of 8-10 reps</li>";
                echo "<li><strong>Plank:</strong> 3 sets of 20-30 seconds hold</li>";
                echo "<li><strong>Walking:</strong> 20 minutes, 3 times a week</li>";
                echo "</ul>";
                echo "</div>";
            } elseif ($activity == "active") {
                echo "<div class='exercise'>";
                echo "<h5>Intermediate Routine (Active)</h5>";
                echo "<p>For those who are already active, aim to increase the intensity and incorporate resistance training for overall muscle strength.</p>";
                echo "<ul>";
                echo "<li><strong>Squats:</strong> 4 sets of 12 reps</li>";
                echo "<li><strong>Push-ups:</strong> 4 sets of 12-15 reps</li>";
                echo "<li><strong>Dumbbell Rows:</strong> 3 sets of 10 reps per side</li>";
                echo "<li><strong>Plank:</strong> 3 sets of 40 seconds hold</li>";
                echo "<li><strong>Cardio (Running/Cycling):</strong> 30 minutes, 3-4 times a week</li>";
                echo "</ul>";
                echo "</div>";
            } else {
                echo "<div class='exercise'>";
                echo "<h5>Advanced Routine (Very Active)</h5>";
                echo "<p>For those who are very active, focus on high-intensity workouts and advanced resistance training techniques.</p>";
                echo "<ul>";
                echo "<li><strong>Barbell Squats:</strong> 4 sets of 8-10 reps</li>";
                echo "<li><strong>Pull-ups:</strong> 4 sets of 6-8 reps</li>";
                echo "<li><strong>Deadlifts:</strong> 4 sets of 8 reps</li>";
                echo "<li><strong>Bench Press:</strong> 4 sets of 8-10 reps</li>";
                echo "<li><strong>HIIT (High-Intensity Interval Training):</strong> 20-30 minutes, 3 times a week</li>";
                echo "</ul>";
                echo "</div>";
            }

            echo "</div>";

        }
        ?>

    </div>

    <div class="text-center mt-4">
            <a href="HOME.html" class="home-btn">Go to Home</a> <!-- Redirect to Home Page -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
