<?php
include '../includes/config.php';
include '../includes/functions.php';
include '../classes/User.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->username = $_POST['username'];
    $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if ($user->register()) {
        redirect('login.php');
    } else {
        echo 'Registration failed';
    }
}
?>
<h2>Register</h2>
<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
</form>
<?php include '../templates/footer.php'; ?>
