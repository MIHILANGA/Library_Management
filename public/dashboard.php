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

$keyword = '';
$books = null;

if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $books = $book->search($keyword);
} else {
    $books = $book->read();
}

if ($books === false) {
    echo "Error fetching books.";
    include '../templates/footer.php';
    exit;
}
?>
<h2>Dashboard</h2>
<a href="add_book.php" class="button">Add New Book</a>

<form method="GET" style="margin-top: 1em;">
    <input type="text" name="search" placeholder="Search by title, author, or genre" value="<?php echo htmlspecialchars($keyword); ?>">
    <button type="submit">Search</button>
</form>

<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Publication Year</th>
        <th>Genre</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $books->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['author']); ?></td>
            <td><?php echo htmlspecialchars($row['publication_year']); ?></td>
            <td><?php echo htmlspecialchars($row['genre']); ?></td>
            <td>
                <a href="edit_book.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button">Edit</a>
                <a href="delete_book.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<?php include '../templates/footer.php'; ?>
