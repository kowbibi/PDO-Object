<?php
require_once 'config.php';

class Database {
    protected $pdo;
    
    public function __construct() {
        try {
            $dsn = "mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_NAME . ";charset=" . Config::DB_CHARSET;
            $this->pdo = new PDO($dsn, Config::DB_USER, Config::DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    // Create (Insert)
    protected function create($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute($data);
    }
    
    // Read (Select)
    protected function read($table, $conditions = [], $limit = null) {
        $sql = "SELECT * FROM $table";
        
        if (!empty($conditions)) {
            $whereClause = [];
            foreach ($conditions as $key => $value) {
                $whereClause[] = "$key = :$key";
            }
            $sql .= " WHERE " . implode(' AND ', $whereClause);
        }
        
        if ($limit) {
            $sql .= " LIMIT :limit";
        }
        
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        if ($limit) {
            $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    // Update
    protected function update($table, $data, $conditions) {
        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        
        $whereClause = [];
        foreach ($conditions as $key => $value) {
            $whereClause[] = "$key = :where_$key";
        }
        
        $sql = "UPDATE $table SET " . implode(', ', $setClause) . 
               " WHERE " . implode(' AND ', $whereClause);
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bind data values
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        // Bind condition values
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }
        
        return $stmt->execute();
    }
    
    // Delete
    protected function delete($table, $conditions) {
        $whereClause = [];
        foreach ($conditions as $key => $value) {
            $whereClause[] = "$key = :$key";
        }
        
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $whereClause);
        $stmt = $this->pdo->prepare($sql);
        
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        return $stmt->execute();
    }
    
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
?>
