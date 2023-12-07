<?php
require_once "Article.php";

class ArticleManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function getMyArticles($userId) {
        $articles = [];

        $sql = "SELECT id, title, content,category, author_id, status, status_message
                FROM articles
                WHERE author_id = ?
                ORDER BY status";

        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $userId);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $article = new Article($row['id'], $row['title'], $row['content'],$row["category"], $row['author_id'], $row['status'], $row['status_message']);
                    $articles[] = $article;
                }
            }

            $stmt->close();
        }

        return $articles;
    }

    public function getAllArticles() {
        $articles = [];

        $result = $this->db->query("SELECT * FROM articles");

        while ($row = $result->fetch_assoc()) {
            $article = new Article($row['id'], $row['title'], $row['content'], $row['category'], $row["author_id"],$row["status"],$row["status_message"]);
            $articles[] = $article;
        }

        return $articles;
    }
    public function createArticle($title, $content, $author_id, $category) {
        $title = $this->db->real_escape_string($title);
        $content = $this->db->real_escape_string($content);
        $category = $this->db->real_escape_string($category);

        $query = "INSERT INTO articles (title, content, author_id, category) VALUES ('$title', '$content', $author_id, '$category')";

        if ($this->db->query($query) === TRUE) {
            return true; // Article creation successful
        } else {
            return false; // Article creation failed
        }
    }

    public function updateArticle($article) {
        $sql = "UPDATE articles SET title=?, content=?, category=?, status='waiting', status_message=NULL WHERE id=?";
        $stmt = $this->db->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssi", $article->getTitle(), $article->getContent(), $article->getCategory(), $article->getId());
            $stmt->execute();
            $stmt->close();
        }
    }

    public function getApprovedArticles() {
        $articles = [];

        $sql = "SELECT id, title, content, author_id, status, status_message, category FROM articles WHERE status='approved'";
        $result = $this->db->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $article = new Article(
                    $row['id'],
                    $row['title'],
                    $row['content'],
                    $row['author_id'],
                    $row['status'],
                    $row['status_message'],
                    $row['category']
                );
                $articles[] = $article;
            }
            $result->free();
        }

        return $articles;
    }

    public function updateArticleStatus($articleId, $status, $statusMessage)
    {
        $stmt = $this->db->prepare("UPDATE articles SET status = ?, status_message = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $statusMessage, $articleId);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    public function getArticleById($articleId) {
        $article = null;

        $stmt = $this->db->prepare("SELECT id, title, content, author_id, category, status, status_message FROM articles WHERE id = ?");
        $stmt->bind_param("i", $articleId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $article = new Article($row['id'], $row['title'], $row['content'],$row["category"], $row['author_id'], $row['status'], $row['status_message']);
            }
        }

        $stmt->close();
        return $article;
    }

}

?>