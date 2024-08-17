<?php
require('database.php');

// Retrieve all courses, ordered by courseID
$query = 'SELECT * FROM sk_courses ORDER BY courseID ASC';
$statement = $db->prepare($query);
$statement->execute();
$courses = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Add Student</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Course Manager</h1></header>

    <main>
        <h1>Add Student</h1>
        <form action="add_student.php" method="post" id="add_student_form">

            <label>Course:</label>
            <select name="course_id">
                <?php foreach ($courses as $course) : ?>
                    <option value="<?php echo htmlspecialchars($course['courseID']); ?>">
                        <?php echo htmlspecialchars($course['courseID']) . ' - ' . htmlspecialchars($course['courseName']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>First Name:</label>
            <input type="text" name="first_name" required><br>

            <label>Last Name:</label>
            <input type="text" name="last_name" required><br>

            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>&nbsp;</label>
            <input type="submit" value="Add Student"><br>
        </form>
        <p><a href="index.php">View Student List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Suresh Kalathur.</p>
    </footer>
</body>
</html>