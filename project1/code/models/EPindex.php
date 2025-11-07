<?php
// ensure we return JSON and avoid HTML error pages in API responses
ini_set('display_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// catch fatal errors and return JSON (temporary debugging helper)
register_shutdown_function(function () {
    $err = error_get_last();
    if ($err !== null) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'fatal_error' => $err
        ]);
        // also write to php error log for persistent debugging
        error_log("FATAL: " . print_r($err, true));
    }
});

// correct path to sessionauth
$authPath = __DIR__ . '/sessionauth.php';
if (!file_exists($authPath)) { $authPath = __DIR__ . '/../authentication/sessionauth.php'; }
if (!file_exists($authPath)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Missing dependency: sessionauth.php', 'checked' => [$authPath]]);
    exit;
}
require_once $authPath;
// fix: ensure correct path and existence check for endpoints.php
$endpointsPath = __DIR__ . '/endpoints.php';
if (!file_exists($endpointsPath)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Missing dependency: endpoints.php', 'checked' => [$endpointsPath]]);
    exit;
}
require_once $endpointsPath;

$auth = new sessionauth();

// Protect API: require login
if (!$auth->is_logged_in()) {
	http_response_code(401);
	header('Content-Type: application/json');
	echo json_encode(['success' => false, 'error' => 'Unauthorized']);
	exit;
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;
$course = $_GET['course'] ?? null;
$major = $_GET['major'] ?? null;
$year = $_GET['year'] ?? null;

switch ($action) {
	case 'all':
		get_all_students();
		break;
	case 'get':
		if ($id === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing id']); break; }
		get_student($id);
		break;
	case 'course':
		if ($course === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing course']); break; }
		get_students_by_course($course);
		break;
	case 'major':
		if ($major === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing major']); break; }
		get_students_by_major($major);
		break;
	case 'name':
		$name = $_GET['name'] ?? null;
		if ($name === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing name']); break; }
		get_student_by_name($name);
		break;
	case 'year':
		if ($year === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing year']); break; }
		get_students_by_year($year);
		break;
	case 'create':
		create_student();
		break;
	case 'update':
		if ($id === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing id']); break; }
		update_student($id);
		break;
	case 'delete':
		if ($id === null) { http_response_code(400); echo json_encode(['success' => false, 'error' => 'Missing id']); break; }
		delete_student($id);
		break;
	case 'delete_all':
		delete_all_students();
		break;
	default:
		http_response_code(400);
		echo json_encode(['success' => false, 'error' => 'Invalid action']);
}

?>

