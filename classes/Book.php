<?php

class Book {
    private $conn;
    private $table = 'books';

    public $id;
    public $title;
    public $author;
    public $publication_year;
    public $genre;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create book
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (title, author, publication_year, genre) VALUES (?, ?, ?, ?)';
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bind_param('ssis', $this->title, $this->author, $this->publication_year, $this->genre);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Read books
    public function read() {
        $query = 'SELECT id, title, author, publication_year, genre FROM ' . $this->table;
        $result = $this->conn->query($query);
        return $result;
    }

    // Search books
    public function search($keyword) {
        $query = 'SELECT id, title, author, publication_year, genre FROM ' . $this->table . ' WHERE title LIKE ? OR author LIKE ? OR genre LIKE ?';
        $stmt = $this->conn->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bind_param('sss', $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

?>
