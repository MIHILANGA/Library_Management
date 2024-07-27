<?php
include '../includes/config.php';
include '../includes/functions.php';
include '../classes/User.php';
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User($conn);
    $user->username = $_POST['username'];
    $user->password = $_POST['password'];

    if ($user->login()) {
        session_start();
        $_SESSION['user_id'] = $user->id;
        redirect('dashboard.php');
    } else {
        echo 'Login failed';
    }
}
?>
<h2>Login</h2>
<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
<?php include '../templates/footer.php'; ?>
