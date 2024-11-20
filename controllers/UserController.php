<?php
class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validation
            $validator = new Validator();
            $errors = $validator->validateRegistration($username, $email, $password);

            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $this->userModel->createUser($username, $email, $hashedPassword);
                header('Location: /login');
                exit();
            } else {
                // Afficher les erreurs
            }
        }

        // Afficher le formulaire de création de compte
        include 'views/auth/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validation
            $validator = new Validator();
            $errors = $validator->validateLogin($username, $password);

            if (empty($errors)) {
                $user = $this->userModel->getUserByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    // Gérer la session
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: /dashboard');
                    exit();
                } else {
                    // Afficher les erreurs
                }
            } else {
                // Afficher les erreurs
            }
        }

        // Afficher le formulaire de connexion
        include 'views/auth/login.php';
    }

    public function deleteAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $this->userModel->deleteUser($userId);
            session_destroy();
            header('Location: /');
            exit();
        }

        // Afficher le formulaire de suppression de compte
        include 'views/auth/delete_account.php';
    }
}
?>
