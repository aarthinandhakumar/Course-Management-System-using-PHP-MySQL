<?php
require_once('database.php');

// Get all courses
$query = 'SELECT * FROM sk_courses ORDER BY courseID'; // Update table name and column names
$statement = $db->prepare($query);
$statement->execute();
$courses = $statement->fetchAll(PDO::FETCH_ASSOC); // Use associative array for column names
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Course List</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
<header><h1>Course Manager</h1></header>
<main>
    <h1>Course List</h1>
    <table>
        <tr>
            <th>ID</th><th>Name</th>
        </tr>
        <?php foreach ($courses as $course) : ?>
        <tr>
            <td><?php echo htmlspecialchars($course['courseID']); ?></td> <!-- Update column names -->
            <td><?php echo htmlspecialchars($course['courseName']); ?></td> <!-- Update column names -->
        </tr>
        <?php endforeach; ?>
    </table>
    <p>
    <h2>Add Course</h2>
    
    <form action="add_course.php" method="post" id="add_course_form">

        <label>Course ID:</label>
        <input type="text" name="course_id" required><br> <!-- Update input name -->
        <label>Course Name:</label>
        <input type="text" name="course_name" required><br> <!-- Update input name -->
        
        <label>&nbsp;</label>
        <input type="submit" value="Add Course"><br>

    </form>

    <br>
    <p><a href="index.php">List Students</a></p>

    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Suresh Kalathur</p>
    </footer>
</body>
</html>