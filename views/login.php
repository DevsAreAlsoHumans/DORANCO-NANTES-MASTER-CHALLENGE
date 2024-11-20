<?php
// Inclure le fichier de configuration et les classes nécessaires
require_once '../config/config.php';
require_once '../app/utils/CSRF.php';

// Vérifier si l'utilisateur est déjà connecté
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: /dashboard');
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier le token CSRF
    if (!CSRF::validateToken($_POST['csrf_token'])) {
        die('Token CSRF invalide.');
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validation des entrées
    $validator = new Validator();
    $errors = $validator->validateLogin($username, $password);

    if (empty($errors)) {
        // Vérifier les informations d'identification
        $userModel = new UserModel($db);
        $user = $userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Gérer la session
            $_SESSION['user_id'] = $user['id'];
            header('Location: /dashboard');
            exit();
        } else {
            $errors[] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
}

?>

<div class="login-container">
    <h2>Connexion</h2>
    <?php if (isset($errors) && !empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateToken(); ?>">
        <div class="form-group">
            <label for="username">Nom d'utilisateur ou Email:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
</div>
