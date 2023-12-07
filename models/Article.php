<?php


class Article {
    private $id;
    private $title;
    private $content;
    private $user_id;

    private $category;

    public function __construct($id, $title, $content,  $category, $user_id,) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
        $this->user_id = $user_id;

    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getContent() {
        return $this->content;
    }
    public function getCategory() {
        return $this->category;
    }
}

?>