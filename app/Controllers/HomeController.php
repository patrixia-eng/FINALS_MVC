<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\TaskStatus;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use Core\Http\Request;
use Core\Http\Response;
use Core\View\Engine;

class HomeController
{
    public function __construct(
        private ProjectRepositoryInterface $projects,
        private TaskRepositoryInterface $tasks,
        private Engine $view,
    ) {}

    public function index(Request $request): Response
    {
        $allTasks = $this->tasks->withProject();

        // Count task statuses for the home page summary.
        $pendingCount = 0;
        $completedCount = 0;
        $overdueCount = 0;
        $today = date('Y-m-d');

        foreach ($allTasks as $task) {
            $status = (string) ($task['status'] ?? '');
            $dueDate = (string) ($task['due_date'] ?? '');

            if ($status === TaskStatus::Pending) {
                $pendingCount++;
            }

            if ($status === TaskStatus::Completed) {
                $completedCount++;
            }

            if ($dueDate !== '' && $status !== TaskStatus::Completed && $dueDate < $today) {
                $overdueCount++;
            }
        }

        $html = $this->view->page('home/index', [
            'projectCount' => count($this->projects->all()),
            'taskCount' => count($allTasks),
            'pendingCount' => $pendingCount,
            'completedCount' => $completedCount,
            'overdueCount' => $overdueCount,
            'recentTasks' => array_slice($allTasks, 0, 5),
        ]);

        return Response::html($html);
    }

}
