<?php
require_once('database.php');

// Get the student form data
$first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
$last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$course_id = filter_input(INPUT_POST, 'course_id', FILTER_SANITIZE_STRING);

// Validate inputs
if ($first_name && $last_name && $email && $course_id) {
    // Add the student to the database
    $query = 'INSERT INTO sk_students (courseID, firstName, lastName, email)
              VALUES (:course_id, :first_name, :last_name, :email)';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
    
    // Redirect to the student list or any other page
    header('Location: index.php');
    exit();
} else {
    echo 'Invalid input. Please provide all required fields.';
}
?>