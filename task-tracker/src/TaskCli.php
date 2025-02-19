<?php

require_once 'Task.php';
require_once 'TaskManager.php';

$taskManager = new TaskManager('tasks.json');

function showMenu() {
    echo "Task CLI Menu:\n";
    echo "1. clAdd Task\n";
    echo "2. Update Task\n";
    echo "3. Delete Task\n";
    echo "4. List Tasks\n";
    echo "5. Exit\n";
    echo "Choose an option: ";
}

while (true) {
    showMenu();
    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case '1':
            echo "Enter task description: ";
            $description = trim(fgets(STDIN));
            $taskManager->addTask($description);
            break;

        case '2':
            echo "Enter task ID: ";
            $id = trim(fgets(STDIN));
            echo "Enter new status (1: todo, 2: in-progress, 3: done): ";
            $statusChoice = trim(fgets(STDIN));
            $statusMap = [
                '1' => 'ToDo',
                '2' => 'In-progress',
                '3' => 'Done'
            ];
            if (array_key_exists($statusChoice, $statusMap)) {
                $status = $statusMap[$statusChoice];
                $taskManager->updateTask((int)$id, $status);
            } else {
                echo "Invalid status choice. Please enter 1, 2, or 3.\n";
            }
            break;

        case '3':
            echo "Enter task ID: ";
            $id = trim(fgets(STDIN));
            $taskManager->deleteTask((int)$id);
            break;

        case '4':
            $taskManager->listTasks();
            break;

        case '5':
            echo "Exiting...\n";
            exit(0);

        default:
            echo "Invalid option. Please choose a valid option from the menu.\n";
            break;
    }
}