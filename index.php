<?php
require_once 'Student.php';
require_once 'Attendance.php';

$student = new Student();
$attendance = new Attendance();

$action = $_GET['action'] ?? '';
$type = $_GET['type'] ?? '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($type === 'student') {
        if ($action === 'add') {
            $data = [
                'student_id' => $_POST['student_id'],
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'course' => $_POST['course'],
                'year_level' => $_POST['year_level']
            ];
            $student->addStudent($data);
        } elseif ($action === 'edit') {
            $data = [
                'student_id' => $_POST['student_id'],
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'course' => $_POST['course'],
                'year_level' => $_POST['year_level']
            ];
            $student->updateStudent($_POST['id'], $data);
        }
    } elseif ($type === 'attendance') {
        if ($action === 'add') {
            $data = [
                'student_id' => $_POST['student_id'],
                'date' => $_POST['date'],
                'status' => $_POST['status'],
                'remarks' => $_POST['remarks']
            ];
            $attendance->addAttendance($data);
        } elseif ($action === 'edit') {
            $data = [
                'student_id' => $_POST['student_id'],
                'date' => $_POST['date'],
                'status' => $_POST['status'],
                'remarks' => $_POST['remarks']
            ];
            $attendance->updateAttendance($_POST['id'], $data);
        }
    }
    header('Location: index.php');
    exit;
}

// Handle delete actions
if ($action === 'delete') {
    if ($type === 'student') {
        $student->deleteStudent($_GET['id']);
    } elseif ($type === 'attendance') {
        $attendance->deleteAttendance($_GET['id']);
    }
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .header { background: #2c3e50; color: white; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .nav { background: #34495e; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        .nav a { color: white; text-decoration: none; padding: 10px 15px; margin: 0 5px; border-radius: 3px; }
        .nav a:hover { background: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #34495e; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { padding: 8px 15px; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #3498db; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-success { background: #2ecc71; color: white; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .card { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>School Management System</h1>
        </div>
        
        <div class="nav">
            <a href="index.php?section=students">Students</a>
            <a href="index.php?section=attendance">Attendance</a>
        </div>

        <?php
        $section = $_GET['section'] ?? 'students';
        
        if ($section === 'students') {
            include 'students_section.php';
        } elseif ($section === 'attendance') {
            include 'attendance_section.php';
        }
        ?>
    </div>
</body>
</html>
