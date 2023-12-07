<?php
require_once "Article.php";

class ArticleManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllArticles() {
        $articles = [];

        $result = $this->db->query("SELECT * FROM articles");

        while ($row = $result->fetch_assoc()) {
            $article = new Article($row['id'], $row['title'], $row['content'], $row['category'], $row["user_id"]);
            $articles[] = $article;
        }

        return $articles;
    }
    public function createArticle($title, $content, $user_id, $category) {
        $title = $this->db->real_escape_string($title);
        $content = $this->db->real_escape_string($content);
        $category = $this->db->real_escape_string($category);

        $query = "INSERT INTO articles (title, content, user_id, category) VALUES ('$title', '$content', $user_id, '$category')";

        if ($this->db->query($query) === TRUE) {
            return true; // Article creation successful
        } else {
            return false; // Article creation failed
        }
    }
}

?>