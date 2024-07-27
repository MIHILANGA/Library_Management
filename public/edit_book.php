<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';
include '../classes/Book.php';
include '../templates/header.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$book = new Book($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book->id = $_POST['id'];
    $book->title = $_POST['title'];
    $book->author = $_POST['author'];
    $book->publication_year = $_POST['publication_year'];
    $book->genre = $_POST['genre'];

    if ($book->update()) {
        redirect('dashboard.php');
    } else {
        echo 'Failed to update book';
    }
} else {
    $book->id = $_GET['id'];
    $result = $book->read()->fetch_assoc();
}
?>
<h2>Edit Book</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $result['title']; ?>" required>
    <label>Author:</label>
    <input type="text" name="author" value="<?php echo $result['author']; ?>" required>
    <label>Publication Year:</label>
    <input type="number" name="publication_year" value="<?php echo $result['publication_year']; ?>" required>
    <label>Genre:</label>
    <input type="text" name="genre" value="<?php echo $result['genre']; ?>">
    <button type="submit">Update</button>
</form>
<?php include '../templates/footer.php'; ?>
