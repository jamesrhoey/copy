<?php
require_once __DIR__ . '/../controllers/EmployeeController.php';

$method = $_SERVER["REQUEST_METHOD"];
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$employeeController = new EmployeeController();

if ($method == "GET" && $path == "/employees") {
    // Get all employees
    $employeeController->getEmployees();
} elseif ($method == "POST" && $path == "/employees") {
    // Add new employee
    $employeeController->addEmployee();
} elseif ($method == "PUT" && preg_match("/\/employees\/(\d+)/", $path, $matches)) {
    // Update employee
    $id = $matches[1]; // Extract employee ID
    $employeeController->updateEmployee($id);
} elseif ($method == "DELETE" && preg_match("/\/employees\/(\d+)/", $path, $matches)) {
    // Delete employee
    $id = $matches[1]; // Extract employee ID
    $employeeController->deleteEmployee($id);
} else {
    // Route not found
    echo json_encode(["status" => "error", "message" => "Route not found"]);
}
?>
