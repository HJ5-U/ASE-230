<?php
/**
 * Simple CRUD Handlers for Student Management
 * 
 * These functions handle the basic Create, Read, Update, Delete operations
 * for students stored in a JSON file.
 */

// make require explicit and robust
require_once __DIR__ . '/students.php';

/**
 * Get all students
 */
function get_all_students()
{
    $students = load_students();
    echo json_encode([
        'success' => true,
        'data' => $students,
        'count' => count($students)
    ]);
}

/**
 * Get a specific student by ID
 */
function get_student($id)
{
    $students = load_students();

    foreach ($students as $student) {
        if ($student['id'] == $id) {
            echo json_encode([
                'success' => true,
                'data' => $student
            ]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Get specific students by Course
 */
function get_students_by_course($course)
{
    $students = load_students();

    $matches = [];

    foreach ($students as $student) {
        if (isset($student['course']) && strcasecmp($student['course'], $course) === 0) {
            $matches[] = $student;
        }
    }

    if (count($matches) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $matches,
            'count' => count($matches)
        ]);
        return;
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Get specific students by Major
 */
function get_students_by_major($major)
{
    $students = load_students();

    $matches = [];

    foreach ($students as $student) {
        if (isset($student['major']) && stripos($student['major'], $major) !== false) {
            $matches[] = $student;
        }
    }

    if (count($matches) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $matches,
            'count' => count($matches)
        ]);
        return;
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Get specific students by Year
 */
function get_students_by_year($year)
{
    $students = load_students();

    $matches = [];

    foreach ($students as $student) {
        if (isset($student['year']) && (string)$student['year'] === (string)$year) {
            $matches[] = $student;
        }
    }

    if (count($matches) > 0) {
        echo json_encode([
            'success' => true,
            'data' => $matches,
            'count' => count($matches)
        ]);
        return;
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Get a specific student by name
 */
function get_student_by_name($name)
{
    $students = load_students();

    foreach ($students as $student) {
        if (stripos($student['name'], $name) !== false) {
            echo json_encode([
                'success' => true,
                'data' => $student
            ]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Create a new student
 */
function create_student()
{
    // Get JSON input
    $input = getRequestData();

    if (!$input) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid JSON data'
        ]);
        return;
    }

    // Load existing students
    $students = load_students();

    // Generate new ID
    $new_id = get_next_id($students);

    // Create new student
    $new_student = new Student();
    $new_student->setId($new_id);
    $new_student->setName($input['name'] ?? '');
    $new_student->setCourse($input['course'] ?? '');
    $new_student->setMajor($input['major'] ?? '');
    $new_student->setYear($input['year'] ?? '');

    // Add to students array
    $students[] = $new_student->toArray();

    // Save to file
    $ok = save_students($students);
    if (!$ok) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to persist student data (file write error)'
        ]);
        return;
    }

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Student created successfully',
        'data' => $new_student->toArray()
    ]);
}

/**
 * Update an existing student
 */
function update_student($id)
{
    // Get JSON input
    $input = getRequestData();

    if (!$input) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Invalid JSON data'
        ]);
        return;
    }

    // Load students
    $students = load_students();

    // Find and update student
    for ($i = 0; $i < count($students); $i++) {
        if ($students[$i]['id'] == $id) {
            // Update fields if provided
            if (isset($input['name']))
                $students[$i]['name'] = $input['name'];
            if (isset($input['course']))
                $students[$i]['course'] = $input['course'];
            if (isset($input['major']))
                $students[$i]['major'] = $input['major'];
            if (isset($input['year']))
                $students[$i]['year'] = $input['year'];

            // Update timestamp
            $students[$i]['updated_at'] = date('Y-m-d H:i:s');

            // Save to file
            save_students($students);

            echo json_encode([
                'success' => true,
                'message' => 'Student updated successfully',
                'data' => $students[$i]
            ]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Delete a student
 */
function delete_student($id)
{
    $students = load_students();

    // Find and remove student
    for ($i = 0; $i < count($students); $i++) {
        if ($students[$i]['id'] == $id) {
            $deleted_student = $students[$i];
            array_splice($students, $i, 1);

            // Save to file
            save_students($students);

            echo json_encode([
                'success' => true,
                'message' => 'Student deleted successfully',
                'data' => $deleted_student
            ]);
            return;
        }
    }

    http_response_code(404);
    echo json_encode([
        'success' => false,
        'error' => 'Student not found'
    ]);
}

/**
 * Delete all students
 */
function delete_all_students()
{
   
    // Clear students
    save_students([]);
    echo json_encode([
        'success' => true,
        'message' => 'All students deleted successfully'
    ]);
}

/**
 * Load students from JSON file
 */
function load_students()
{
    $file_path = __DIR__ . '/data/studentsdata.json';

    if (!file_exists($file_path)) {
        return [];
    }

    $json_data = @file_get_contents($file_path);
    if ($json_data === false) {
        // return empty and log error
        error_log("Failed to read students file: $file_path");
        return [];
    }

    $students = json_decode($json_data, true);
    return $students ?: [];
}

/**
 * Save students to JSON file
 */
function save_students($students)
{
    $dir = __DIR__ . '/data';
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true) && !is_dir($dir)) {
            error_log("Failed to create data directory: $dir");
            return false;
        }
    }

    $file_path = $dir . '/studentsdata.json';
    $json_data = json_encode($students, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if ($json_data === false) {
        error_log('Failed to encode students JSON: ' . json_last_error_msg());
        return false;
    }

    $bytes = @file_put_contents($file_path, $json_data, LOCK_EX);
    if ($bytes === false) {
        error_log("Failed to write students file: $file_path");
        return false;
    }
    return true;
}

/**
 * Get the request data from the input stream
 * 
 * This function reads the raw input data and decodes it as JSON.
 * If decoding fails, it returns an empty array.
 */
function getRequestData()
{
    $input = @file_get_contents('php://input');
    if ($input === false || trim($input) === '') {
        return null;
    }
    $decoded = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Invalid JSON input: ' . json_last_error_msg());
        return null;
    }
    return $decoded;
}

/**
 * Get the next available ID
 */
function get_next_id($students)
{
    $max_id = 0;
    foreach ($students as $student) {
        if ($student['id'] > $max_id) {
            $max_id = $student['id'];
        }
    }
    return $max_id + 1;
}
