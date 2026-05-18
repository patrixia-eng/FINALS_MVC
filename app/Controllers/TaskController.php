<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\TaskStatus;
use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Support\Validator;
use Core\Http\Request;
use Core\Http\Response;
use Core\View\Engine;

class TaskController
{
    public function __construct(
        private TaskRepositoryInterface $tasks,
        private ProjectRepositoryInterface $projects,
        private Engine $view,
    ) {}

    public function index(Request $request): Response
    {
        return Response::html($this->view->page('tasks/index', [
            'tasks' => $this->tasks->withProject(),
        ]));
    }

    public function create(Request $request): Response
    {
        return Response::html($this->view->page('tasks/create', [
            'projects' => $this->projects->all(),
            'statuses' => TaskStatus::options(),
            'errors' => [],
            'old' => ['project_id' => $request->input('project_id')],
        ]));
    }

    public function store(Request $request): Response
    {
        $data = [
            'project_id' => (string) $request->input('project_id', ''),
            'title' => trim((string) $request->input('title', '')),
            'description' => trim((string) $request->input('description', '')),
            'due_date' => trim((string) $request->input('due_date', '')),
            'status' => (string) $request->input('status', TaskStatus::Pending),
        ];

        $validator = new Validator();
        $rules = [
            'project_id' => ['required'],
            'title' => ['required', 'max:255'],
            'due_date' => ['date'],
            'status' => ['required', 'in:' . implode(',', TaskStatus::values())],
        ];

        if (!$validator->validate($data, $rules)) {
            return Response::html($this->view->page('tasks/create', [
                'projects' => $this->projects->all(),
                'statuses' => TaskStatus::options(),
                'errors' => $validator->errors(),
                'old' => $data,
            ]));
        }

        $this->tasks->create([
            'project_id' => (int) $data['project_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?: null,
            'due_date' => $data['due_date'] ?: null,
            'status' => $data['status'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return Response::redirect('/projects/' . $data['project_id']);
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->route('id');
        $task = $this->tasks->find($id);

        if ($task === null) {
            return Response::notFound('Task not found');
        }

        return Response::html($this->view->page('tasks/edit', [
            'task' => $task,
            'projects' => $this->projects->all(),
            'statuses' => TaskStatus::options(),
            'errors' => [],
        ]));
    }

    public function update(Request $request): Response
    {
        $id = (int) $request->route('id');
        $task = $this->tasks->find($id);

        if ($task === null) {
            return Response::notFound('Task not found');
        }

        $data = [
            'project_id' => (string) $request->input('project_id', ''),
            'title' => trim((string) $request->input('title', '')),
            'description' => trim((string) $request->input('description', '')),
            'due_date' => trim((string) $request->input('due_date', '')),
            'status' => (string) $request->input('status', TaskStatus::Pending),
        ];

        $validator = new Validator();
        $rules = [
            'project_id' => ['required'],
            'title' => ['required', 'max:255'],
            'due_date' => ['date'],
            'status' => ['required', 'in:' . implode(',', TaskStatus::values())],
        ];

        if (!$validator->validate($data, $rules)) {
            return Response::html($this->view->page('tasks/edit', [
                'task' => array_merge($task, $data),
                'projects' => $this->projects->all(),
                'statuses' => TaskStatus::options(),
                'errors' => $validator->errors(),
            ]));
        }

        $this->tasks->update($id, [
            'project_id' => (int) $data['project_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?: null,
            'due_date' => $data['due_date'] ?: null,
            'status' => $data['status'],
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return Response::redirect('/projects/' . $data['project_id']);
    }

    public function destroy(Request $request): Response
    {
        $id = (int) $request->route('id');
        $task = $this->tasks->find($id);

        $this->tasks->delete($id);

        if ($task && isset($task['project_id'])) {
            return Response::redirect('/projects/' . $task['project_id']);
        }

        return Response::redirect('/tasks');
    }
}
