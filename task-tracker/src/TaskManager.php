<?php

class TaskManager {
    private $tasks = [];
    private $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        $this->loadTasks();
    }

    private function loadTasks() {
        if (file_exists($this->filePath)) {
            $json = file_get_contents($this->filePath);
            $data = json_decode($json, true);
            foreach ($data as $taskData) {
                $this->tasks[] = new Task(
                    $taskData['id'],
                    $taskData['description'],
                    $taskData['status'],
                    $taskData['createdAt'],
                    $taskData['updatedAt']
                );
            }
        }
    }

    private function saveTasks() {
        $data = array_map(function($task) {
            return [
                'id' => $task->id,
                'description' => $task->description,
                'status' => $task->status,
                'createdAt' => $task->createdAt,
                'updatedAt' => $task->updatedAt
            ];
        }, $this->tasks);
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addTask($description) {
        $id = count($this->tasks) + 1;
        $createdAt = date('Y-m-d H:i:s');
        $task = new Task($id, $description, 'todo', $createdAt, $createdAt);
        $this->tasks[] = $task;
        $this->saveTasks();
        echo "Task added successfully (ID: $id)\n";
    }

    public function listTasks() {
        foreach ($this->tasks as $task) {
            echo "ID: $task->id\n";
            echo "Description: $task->description\n";
            echo "Status: $task->status\n";
            echo "Created At: $task->createdAt\n";
            echo "Updated At: $task->updatedAt\n";
            echo "\n";
        }
    }

    public function updateTask($id, $status) {
        $task = $this->findTask($id);
        if ($task) {
            $task->status = $status;
            $task->updatedAt = date('Y-m-d H:i:s');
            $this->saveTasks();
            echo "Task updated successfully\n";
        } else {
            echo "Task not found\n";
        }
    }

    private function findTask($id) {
        foreach ($this->tasks as $task) {
            if ($task->id == $id) {
                return $task;
            }
        }
        return null;
    }

    public function deleteTask($id) {
        $task = $this->findTask($id);
        if ($task) {
            $index = array_search($task, $this->tasks);
            array_splice($this->tasks, $index, 1);
            $this->reorderTaskIds();
            $this->saveTasks();
            echo "Task deleted successfully\n";
        } else {
            echo "Task not found\n";
        }
    }
    private function reorderTaskIds() {
        foreach ($this->tasks as $index => $task) {
            $task->id = $index + 1;
        }
    }
}