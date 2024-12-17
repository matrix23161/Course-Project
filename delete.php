<?php
include 'db.php';

if (isset($_GET['course_id'])) {
    $id = $_GET['course_id'];
    $id = intval($id);

    $sql = "DELETE FROM course WHERE course_id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: display.php?status=success");
        exit();
    } else {
        header("Location: display.php?status=error");
        exit();
    }
} else {
    header("Location: display.php?status=no_id");
    exit();
}
?>
