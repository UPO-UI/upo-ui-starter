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

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['name']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Name and email are required']);
            return;
        }
        try {
            $id = $this->userModel->create($data);
            http_response_code(201);
            echo json_encode(['id' => $id, 'message' => 'User created']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Add other methods like show, update, destroy as needed
}
?> 