<?php


class Article {
    private $id;
    private $title;
    private $content;
    private $author_id;
    private $category;
    private $status;
    private $statusMessage;

    public function __construct($id, $title, $content,  $category, $author_id, $status, $statusMessage) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
        $this->author_id = $author_id;
        $this->status = $status;
        $this->statusMessage = $statusMessage;

    }

    public function getId() {
        return $this->id;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getStatusMessage(){
        return $this->statusMessage;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }
}

?>