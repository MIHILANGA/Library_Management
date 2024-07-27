<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';
include '../classes/Book.php'; // Ensure this path is correct
include '../templates/header.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book = new Book($conn);
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->publication_year = $_POST['publication_year'];
    $book->genre = $_POST['genre'];
    $book->user_id = $_SESSION['user_id'];

    if ($book->create()) {
        redirect('dashboard.php');
    } else {
        echo 'Failed to add book';
    }
}
?>
<h2>Add Book</h2>
<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" required>
    <label>Author:</label>
    <input type="text" name="author" required>
    <label>Publication Year:</label>
    <input type="number" name="publication_year" required>
    <label>Genre:</label>
    <input type="text" name="genre">
    <button type="submit">Add</button>
</form>
<?php include '../templates/footer.php'; ?>
