<?php
session_start();
include '../includes/config.php';
include '../includes/functions.php';
include '../classes/Book.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$book = new Book($conn);
$book->id = $_GET['id'];

if ($book->delete()) {
    redirect('dashboard.php');
} else {
    echo 'Failed to delete book';
}
?>
