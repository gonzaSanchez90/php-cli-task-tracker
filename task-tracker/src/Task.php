<?php

class Task {
    public $id;
    public $description;
    public $status;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $description, $status, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->description = $description;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}