<?php
require 'database.php';

// Convert an associative array to XML
function array_to_xml($data, &$xml_data, $item_name) {
    foreach ($data as $key => $value) {
        // Handle associative arrays (objects) and numeric arrays (lists)
        if (is_array($value)) {
            // If item_name is provided, create a new element for each item
            if ($item_name) {
                $subnode = $xml_data->addChild($item_name);
                array_to_xml($value, $subnode, null);
            } else {
                array_to_xml($value, $xml_data, null);
            }
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

// Function to get courses and return in the specified format
function get_courses($format) {
    global $db; // Use the global PDO connection

    $sql = "SELECT * FROM sk_courses";
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Query failed: " . htmlspecialchars($e->getMessage());
        exit();
    }

    if ($format == 'json') {
        header('Content-Type: application/json');
        echo json_encode($courses);
    } else {
        header('Content-Type: application/xml');
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><courses></courses>');
        array_to_xml($courses, $xml_data, 'course');
        echo $xml_data->asXML();
    }
}

// Function to get students and return in the specified format
function get_students($format, $course_id) {
    global $db;

    $sql = "SELECT * FROM sk_students WHERE courseID = :course_id";
    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':course_id', $course_id, PDO::PARAM_STR);
        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        

        foreach ($students as &$student) {
            $student['studentID'] = (string) $student['studentID'];
            $student['courseID'] = (string) $student['courseID'];
        }

        
        if ($format == 'json') {
            header('Content-Type: application/json');
            echo json_encode($students);
        } else {
            header('Content-Type: application/xml');
            $xml_data = new SimpleXMLElement('<?xml version="1.0"?><students></students>');

            if (empty($students)) {
                echo $xml_data->asXML(); // Return an empty XML document
            } else {
                array_to_xml($students, $xml_data, 'student');
                echo $xml_data->asXML();
            }
        }
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo "Database query error: " . htmlspecialchars($e->getMessage());
        exit();
    }
}

// Handle the request based on the format and action
if (isset($_GET['format']) && isset($_GET['action'])) {
    $format = $_GET['format'];
    $action = $_GET['action'];

    if ($action == 'courses') {
        get_courses($format);
    } elseif ($action == 'students' && isset($_GET['course'])) {
        $course_id = $_GET['course']; // No need to convert to integer
        get_students($format, $course_id);
    } else {
        http_response_code(400);
        echo "Invalid action or missing parameters.";
    }
} else {
    http_response_code(400);
    echo "Invalid request.";
}
?>