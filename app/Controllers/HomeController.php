<?php

declare(strict_types=1);

namespace App\Controllers;

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

        // count pending and overdue for home page
        $pendingCount = 0;
        $overdueCount = 0;
        $today = date('Y-m-d');

        foreach ($allTasks as $t) {
            if ($t['status'] === 'pending') {
                $pendingCount++;
            }
            if (!empty($t['due_date']) && $t['status'] !== 'completed' && $t['due_date'] < $today) {
                $overdueCount++;
            }
        }

        $html = $this->view->page('home/index', [
            'projectCount' => count($this->projects->all()),
            'taskCount' => count($allTasks),
            'pendingCount' => $pendingCount,
            'overdueCount' => $overdueCount,
            'recentTasks' => array_slice($allTasks, 0, 5),
        ]);

        return Response::html($html);
    }
}
