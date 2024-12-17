<?php
session_start();
include 'db.php';

$sql = "SELECT * FROM course";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Course List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #2c2c2c, #dc3545);
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
        }

        .box-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 50px 0;
        }

        .box {
            background: rgba(50, 50, 50, 0.9);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 1300px;
        }

        table.table.table-bordered.table-dark {
            background-color: rgba(0, 0, 0, 0.85) !important;
            color: white !important;
        }

        table.table.table-bordered.table-dark tbody tr:nth-child(odd) {
            background-color: rgba(220, 53, 69, 0.2) !important; /* Light red for odd rows */
        }

        table.table.table-bordered.table-dark tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1) !important; /* Light gray for even rows */
        }

        table.table.table-bordered.table-dark tbody tr:hover {
            background-color: rgba(220, 53, 69, 0.4) !important; /* Darker red on hover */
        }

        table thead th {
            background-color: #dc3545;
            color: white;
            text-align: center;
        }

        .return-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            color: white;
            background-color: #dc3545;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .return-link:hover {
            background-color: #c82333;
        }

        h3 {
            color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="box-container">
        <div class="box">
            <h3 class="text-center mb-4" style="color: #dc3545;">Course List</h3>

            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Code</th>
                        <th>Course Description</th>
                        <th>Lecture Hours</th>
                        <th>Theory Hours</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . htmlspecialchars($row['course_id']) . "</td>
                                    <td>" . htmlspecialchars($row['course_Code']) . "</td>
                                    <td>" . htmlspecialchars($row['course_description']) . "</td>
                                    <td>" . htmlspecialchars($row['lecture_hrs']) . "</td>
                                    <td>" . htmlspecialchars($row['theory_hrs']) . "</td>
                                    <td>
                                        <a href='update.php?course_id=" . $row['course_id'] . "' class='btn btn-warning btn-sm'>Update</a>
                                        <a href='delete.php?course_id=" . $row['course_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No courses found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="index.php" class="return-link">Return to Create Course</a>
        </div>
    </div>
</body>
</html>
