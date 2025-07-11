<?php
// api/controllers/UserController.php - Controller for user operations

require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function index() {
        try {
            $users = $this->userModel->findAll();
            echo json_encode($users);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Add other methods like store, show, update, destroy as needed
}
?> 