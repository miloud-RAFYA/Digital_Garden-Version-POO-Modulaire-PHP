<?php
class Note {
    private $id;
    private $title;
    private $importance;
    private $content;
    private $created_at;
    private $theme_id;

    public function __construct($title, $importance, $content, $theme_id = null) {
        $this->title = $title;
        $this->importance = $importance;
        $this->content = $content;
        $this->theme_id = $theme_id;
    }

    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setThemeId($theme_id) {
        $this->theme_id = $theme_id;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'importance' => $this->importance,
            'content' => $this->content,
            'theme_id' => $this->theme_id,
            'created_at' => $this->created_at
        ];
    }
}