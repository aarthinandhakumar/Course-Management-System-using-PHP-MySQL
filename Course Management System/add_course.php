<?php
require_once('database.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the course form data
    $course_id = filter_input(INPUT_POST, 'course_id', FILTER_SANITIZE_STRING);
    $course_name = filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_STRING);

    // Validate inputs
    if ($course_id && $course_name) {
        // Add the course to the database  
        $query = 'INSERT INTO sk_courses (courseID, courseName)
                  VALUES (:course_id, :course_name)';
        $statement = $db->prepare($query);
        $statement->bindValue(':course_id', $course_id);
        $statement->bindValue(':course_name', $course_name);
        $statement->execute();
        $statement->closeCursor();
        
        // Redirect to the Course List page
        header('Location: course_list.php');
        exit();
    } else {
        echo 'Invalid input. Please provide both course ID and course name.';
    }
}
?>