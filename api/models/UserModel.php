<?php
// api/models/UserModel.php - Model for users table

require_once __DIR__ . '/../core/BaseModel.php';

class UserModel extends BaseModel {
    protected static $table = 'users';

    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    public static function schema() {
        return [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) UNIQUE NOT NULL',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];
    }
}
?> 