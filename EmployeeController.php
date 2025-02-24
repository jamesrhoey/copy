<?php
require_once __DIR__ . '/../database/db.php';

class EmployeeController {

    public function getEmployees() {
        global $conn;

        $result = $conn->query("SELECT * FROM employees");

        if ($result->num_rows > 0) {
            $employees = [];
            while ($row = $result->fetch_assoc()) {
                $employees[] = $row;
            }
            echo json_encode(["status" => "success", "data" => $employees]);
        } else {
            echo json_encode(["status" => "error", "message" => "No employees found"]);
        }
    }

    public function addEmployee() {
        global $conn;

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['full_name'], $data['birth_date'], $data['address'], $data['number'], $data['emergency_contact'])) {
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
            return;
        }

        $stmt = $conn->prepare("INSERT INTO employees (full_name, birth_date, address, number, emergency_contact) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $data['full_name'], $data['birth_date'], $data['address'], $data['number'], $data['emergency_contact']);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Employee added successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add employee"]);
        }
    }

    public function updateEmployee($id) {
        global $conn;

        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("UPDATE employees SET full_name = ?, birth_date = ?, address = ?, number = ?, emergency_contact = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $data['full_name'], $data['birth_date'], $data['address'], $data['number'], $data['emergency_contact'], $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Employee updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update employee"]);
        }
    }

    public function deleteEmployee($id) {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(["status" => "success", "message" => "Employee deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Employee not found"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete employee"]);
        }
    }
}
?>

