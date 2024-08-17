<?php
require_once('database.php');

// Retrieve courses
$queryCourses = 'SELECT * FROM sk_courses';
$statementCourses = $db->prepare($queryCourses);
$statementCourses->execute();
$courses = $statementCourses->fetchAll(PDO::FETCH_ASSOC);
$statementCourses->closeCursor();

// Retrieve selected course ID from URL, default to first course if not set
$courseID = isset($_GET['courseID']) ? $_GET['courseID'] : ($courses[0]['courseID'] ?? null);
// This line checks if a `courseID` is provided in the URL via a GET request. If it is, `$courseID` is set to that value. If not, it defaults to the `courseID` of the first course in the `$courses` array retrieved from the database. If the `$courses` array is empty, `$courseID` is set to `null`. This ensures that `$courseID` always has a valid value, either from the URL, the first course, or `null`.
// Retrieve students for the selected course
if ($courseID) {
    $queryStudents = 'SELECT * FROM sk_students WHERE courseID = :courseID';
    $statementStudents = $db->prepare($queryStudents);
    $statementStudents->bindValue(':courseID', $courseID);
    $statementStudents->execute();
    $students = $statementStudents->fetchAll(PDO::FETCH_ASSOC);
    $statementStudents->closeCursor();

    // Get the course description for the selected course
    $queryCourseDescription = 'SELECT courseName FROM sk_courses WHERE courseID = :courseID';
    $statementCourseDescription = $db->prepare($queryCourseDescription);
    $statementCourseDescription->bindValue(':courseID', $courseID);
    $statementCourseDescription->execute();
    $courseDescription = $statementCourseDescription->fetchColumn();
    $statementCourseDescription->closeCursor();
} else {
    $students = [];
    $courseDescription = ''; // No description if course ID is not valid
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Course Manager</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<header><h1>Course Manager</h1></header>
<main>
    <center><h1>Student List</h1></center>
    <aside>
        <!-- display a list of courses -->
        <h2>Courses</h2>
        <nav>
            <ul>
                <?php foreach ($courses as $course): ?>
                    <li>
                        <a href="?courseID=<?php echo htmlspecialchars($course['courseID']); ?>">
                            <?php echo htmlspecialchars($course['courseID']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </aside>
    <section>
        <!-- display course description and a table of students -->
        <?php if ($courseDescription): ?>
            <h2><?php echo htmlspecialchars($courseID . ' - ' . $courseDescription); ?></h2>
        <?php endif; ?>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>&nbsp;</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($student['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><a href="delete_student.php?student_id=<?php echo $student['studentID']; ?>&courseID=<?php echo $courseID; ?>" class="delete-button" >Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="add_student_form.php">Add Student</a></p>
        <p><a href="course_list.php">List Courses</a></p>
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Suresh Kalathur</p>
</footer>
</body>
</html>