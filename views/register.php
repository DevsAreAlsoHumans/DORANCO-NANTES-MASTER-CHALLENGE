<form action="/register" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateToken(); ?>">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Créer un compte</button>
</form>
