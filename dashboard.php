<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'university_erp');
$query = $conn->prepare("SELECT * FROM students WHERE id = ?");
$query->bind_param("i", $_SESSION['user_id']);
$query->execute();
$user = $query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0; }
        .dashboard-container { max-width: 600px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
        .timetable { background: #f0f0f0; padding: 15px; border-radius: 4px; }
        .logout { text-align: right; margin-bottom: 20px; }
        .logout a { text-decoration: none; color: white; background-color: #dc3545; padding: 10px 15px; border-radius: 4px; font-size: 14px; }
        .logout a:hover { background-color: #c82333; }

    </style>
</head>
<body>
    <div class="dashboard-container">
    <div class="logout">
            <a href="logout.php">Logout</a>
        </div>

        <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h2>
        <h3>Your Timetable</h3>
        <div class="timetable">
            <?php
            if (!empty($user['timetable'])) {
                echo nl2br(htmlspecialchars($user['timetable']));
            } else {
                echo "No timetable assigned.";
            }
            ?>

        </div>
    </div>
</body>
</html>
