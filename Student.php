<?php
require_once 'Database.php';

class Student extends Database {
    private $table = 'students';
    
    public function __construct() {
        parent::__construct();
        $this->createTable();
    }
    
    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS $this->table (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(20) UNIQUE NOT NULL,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            course VARCHAR(50) NOT NULL,
            year_level INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $this->pdo->exec($sql);
    }
    
    public function addStudent($data) {
        return $this->create($this->table, $data);
    }
    
    public function getStudents() {
        return $this->read($this->table);
    }
    
    public function getStudent($id) {
        return $this->read($this->table, ['id' => $id], 1);
    }
    
    public function updateStudent($id, $data) {
        return $this->update($this->table, $data, ['id' => $id]);
    }
    
    public function deleteStudent($id) {
        return $this->delete($this->table, ['id' => $id]);
    }
}
?>
