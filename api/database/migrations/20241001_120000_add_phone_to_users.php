<?php

class Migration_20241001120000addphonetousers {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function up() {
        $this->pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(255) NOT NULL DEFAULT ''");
    }

    public function down() {
        $this->pdo->exec("ALTER TABLE users DROP COLUMN phone");
    }
}
?> 