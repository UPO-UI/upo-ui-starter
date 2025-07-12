<?php
// api/database/seeders/20241001_150000_users_seeder.php - Users seeder

class Seeder_20241001_150000_users_seeder {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function run() {
        // Sample user data
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567891',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'phone' => '+1234567892',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $stmt = $this->pdo->prepare('
            INSERT INTO users (name, email, phone, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?)
        ');
        
        foreach ($users as $user) {
            $stmt->execute([
                $user['name'],
                $user['email'],
                $user['phone'],
                $user['created_at'],
                $user['updated_at']
            ]);
        }
        
        echo "Seeded " . count($users) . " users\n";
    }
}
?> 