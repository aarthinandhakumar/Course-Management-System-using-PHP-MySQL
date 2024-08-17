<?php
require_once('database.php');

// Get the student ID and course ID from the query string
$student_id = filter_input(INPUT_GET, 'student_id', FILTER_VALIDATE_INT);
$course_id = filter_input(INPUT_GET, 'courseID', FILTER_SANITIZE_STRING);

// Validate inputs
if ($student_id) {
    // Delete the student from the database
    $query = 'DELETE FROM sk_students WHERE studentID = :student_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->execute();
    $statement->closeCursor();
}

// Redirect to the home page with the current course
header("Location: index.php?courseID=$course_id");
exit();
?>