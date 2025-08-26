<?php
require_once 'Database.php';

class Attendance extends Database {
    private $table = 'attendance';
    
    public function __construct() {
        parent::__construct();
        $this->createTable();
    }
    
    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT NOT NULL,
            date DATE NOT NULL,
            status ENUM('present', 'absent', 'late') NOT NULL,
            remarks TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
        )";
        
        $this->pdo->exec($sql);
    }
    
    public function addAttendance($data) {
        return $this->create($this->table, $data);
    }
    
    public function getAttendance() {
        $sql = "SELECT a.*, s.first_name, s.last_name, s.student_id as student_number 
                FROM $this->table a 
                JOIN students s ON a.student_id = s.id 
                ORDER BY a.date DESC, s.last_name";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAttendanceRecord($id) {
        return $this->read($this->table, ['id' => $id], 1);
    }
    
    public function updateAttendance($id, $data) {
        return $this->update($this->table, $data, ['id' => $id]);
    }
    
    public function deleteAttendance($id) {
        return $this->delete($this->table, ['id' => $id]);
    }
    
    public function getAttendanceByDate($date) {
        $sql = "SELECT a.*, s.first_name, s.last_name, s.student_id as student_number 
                FROM $this->table a 
                JOIN students s ON a.student_id = s.id 
                WHERE a.date = :date 
                ORDER BY s.last_name";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['date' => $date]);
        return $stmt->fetchAll();
    }
}
?>
