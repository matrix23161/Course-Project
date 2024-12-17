<?php
include 'db.php';

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['course_id'];
    $code = $_POST['course_Code'];
    $desc = $_POST['course_description'];
    $lecture = $_POST['lecture_hrs'];
    $theory = $_POST['theory_hrs'];

    if ($lecture < 0 || $theory < 0) {
        $error_message = "Error: Lecture Hours and Theory Hours cannot be negative.";
    } else {
        $sql_check = "SELECT * FROM course WHERE (course_Code = '$code' OR course_description = '$desc') AND course_id != $id";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $error_message = "Error: Course code or description already exists. Please enter a unique course code and description.";
        } else {
            $sql = "UPDATE course SET 
                    course_Code = '$code', 
                    course_description = '$desc', 
                    lecture_hrs = $lecture, 
                    theory_hrs = $theory 
                    WHERE course_id = $id";

            if ($conn->query($sql) === TRUE) {
                header("Location: display.php?status=updated");
                exit();
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
} elseif (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];

    $sql = "SELECT * FROM course WHERE course_id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    } else {
        $error_message = "Course not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
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

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 50px 0;
        }

        .form-card {
            background-color: rgba(50, 50, 50, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        input:focus, textarea:focus {
            outline: none;
            box-shadow: 0 0 5px 2px red;
        }

        button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: darkred;
        }

        .bottom-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: white;
            text-decoration: none;
        }

        .bottom-link:hover {
            color: #dc3545;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-card">
        <h3 class="text-center mb-4" style="color: #dc3545;">Update Course</h3>

        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger text-center"><?= $error_message ?></div>
        <?php } ?>

        <form method="post" action="update.php">
            <div class="mb-3">
                <input type="number" name="course_id" class="form-control" placeholder="Course ID" value="<?= isset($course['course_id']) ? $course['course_id'] : '' ?>" required readonly>
            </div>
            <div class="mb-3">
                <input type="text" name="course_Code" class="form-control" placeholder="Course Code" value="<?= isset($course['course_Code']) ? $course['course_Code'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <textarea name="course_description" class="form-control" placeholder="Description" required><?= isset($course['course_description']) ? $course['course_description'] : '' ?></textarea>
            </div>
            <div class="mb-3">
                <input type="number" name="lecture_hrs" class="form-control" placeholder="Lecture Hours" value="<?= isset($course['lecture_hrs']) ? $course['lecture_hrs'] : '' ?>" required>
            </div>
            <div class="mb-3">
                <input type="number" name="theory_hrs" class="form-control" placeholder="Theory Hours" value="<?= isset($course['theory_hrs']) ? $course['theory_hrs'] : '' ?>" required>
            </div>
            <button type="submit">Update</button>
        </form>

        <a href="display.php" class="bottom-link">View All Courses</a>
    </div>
</div>

</body>
</html>
