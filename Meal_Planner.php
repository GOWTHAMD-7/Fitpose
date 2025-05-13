<?php
// Meal plan and macro calculation based on user input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $goal = $_POST['goal'];  // Weight loss, muscle gain, etc.
    $age = $_POST['age'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $activityLevel = $_POST['activityLevel'];

    // Basic BMR calculation (Mifflin-St Jeor Equation)
    $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5; // for males

    // Total Daily Energy Expenditure (TDEE) based on activity level
    switch ($activityLevel) {
        case 'sedentary':
            $tdee = $bmr * 1.2;
            break;
        case 'light':
            $tdee = $bmr * 1.375;
            break;
        case 'moderate':
            $tdee = $bmr * 1.55;
            break;
        case 'active':
            $tdee = $bmr * 1.725;
            break;
        case 'very_active':
            $tdee = $bmr * 1.9;
            break;
        default:
            $tdee = $bmr;
    }

    // Calculate macros based on goals
    if ($goal == 'weight_loss') {
        $calories = $tdee - 500;  // 500-calorie deficit
    } else if ($goal == 'muscle_gain') {
        $calories = $tdee + 500;  // 500-calorie surplus
    } else {
        $calories = $tdee;
    }

    $protein = $weight * 2.2; // Protein: 2.2g per kg of body weight
    $fats = $calories * 0.25 / 9; // Fats: 25% of total calories
    $carbs = ($calories - ($protein * 4 + $fats * 9)) / 4; // Carbs make up the rest

    // Display the result
    $message = "Your Daily Calories: $calories kcal\n";
    $message .= "Protein: $protein g\nFats: $fats g\nCarbs: $carbs g";
} else {
    $message = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Meal Planner & Macro Calculator</title>
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
            max-width: 700px;
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

        .btn-primary {
            background-color: #16a085;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1c2833;
        }

        .alert {
            background-color: #16a085;
            color: #fff;
            font-weight: bold;
        }

        .form-control, .form-select {
            border-radius: 8px;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 5px rgba(0, 255, 255, 0.5);
        }

        .result {
            margin-top: 30px;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .home-button {
          background-color: #1c2833;
          color: #fff;
          text-align: center;
          padding: 15px;
          font-size: 1.1rem;
          font-weight: bold;
          border-radius: 8px;
          display: block;
          margin: 20px auto 0; /* Centers the button and adds margin */
          width: 30%; /* Adjust width as needed */
          transition: transform 0.3s ease, background-color 0.3s ease;
      }

      .home-button:hover {
          background-color: #16a085;
          transform: scale(1.05);
      }


        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Macro Calculator</h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="goal" class="form-label">Goal</label>
                <select name="goal" id="goal" class="form-select">
                    <option value="weight_loss">Weight Loss</option>
                    <option value="muscle_gain">Muscle Gain</option>
                    <option value="maintain">Maintain Weight</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" name="age" required>
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" class="form-control" name="weight" required>
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number" class="form-control" name="height" required>
            </div>

            <div class="mb-3">
                <label for="activityLevel" class="form-label">Activity Level</label>
                <select name="activityLevel" class="form-select">
                    <option value="sedentary">Sedentary (little or no exercise)</option>
                    <option value="light">Light Activity</option>
                    <option value="moderate">Moderate Activity</option>
                    <option value="active">Active (hard exercise 3-5 days/week)</option>
                    <option value="very_active">Very Active (very hard exercise 6-7 days/week)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Calculate</button>
        </form>

        <?php if ($message): ?>
            <div class="alert alert-success mt-4">
                <pre><?php echo $message; ?></pre>
            </div>
        <?php endif; ?>

        <!-- Home Button -->
        <a href="HOME.html" class="home-button">Go to Home</a>
    </div>

</body>
</html>
