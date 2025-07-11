<?php
// api/core/BaseModel.php - Base class for all database models

class BaseModel {
    protected $pdo;
    protected static $table = '';

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->table = static::$table;
    }

    public function findAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error fetching all records: ' . $e->getMessage());
        }
    }

    public function findById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error fetching record by ID: ' . $e->getMessage());
        }
    }

    public function create($data) {
        try {
            $keys = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($keys) VALUES ($placeholders)");
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception('Error creating record: ' . $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            $set = '';
            foreach (array_keys($data) as $key) {
                $set .= "$key = :$key, ";
            }
            $set = rtrim($set, ', ');
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
            $stmt->bindValue(':id', $id);
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error updating record: ' . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception('Error deleting record: ' . $e->getMessage());
        }
    }

    // Override in child classes to define table schema
    public static function schema() {
        return [];
    }

    // Generate and execute migration SQL
    public static function migrate($pdo) {
        $schema = static::schema();
        if (empty($schema)) {
            throw new Exception('No schema defined for ' . static::class);
        }

        $table = static::$table;
        $fields = [];
        foreach ($schema as $field => $definition) {
            $fields[] = "$field $definition";
        }
        $fieldsSql = implode(', ', $fields);

        $sql = "CREATE TABLE IF NOT EXISTS $table ($fieldsSql)";
        try {
            $pdo->exec($sql);
            echo "Migrated table: $table\n";
        } catch (PDOException $e) {
            throw new Exception('Migration failed for $table: ' . $e->getMessage());
        }
    }
}
?> 