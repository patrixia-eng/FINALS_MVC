<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProjectRepositoryInterface;
use App\Repositories\TaskRepositoryInterface;
use App\Support\Validator;
use Core\Http\Request;
use Core\Http\Response;
use Core\View\Engine;

class ProjectController
{
    public function __construct(
        private ProjectRepositoryInterface $projects,
        private TaskRepositoryInterface $tasks,
        private Engine $view,
    ) {}

    public function index(Request $request): Response
    {
        return Response::html($this->view->page('projects/index', [
            'projects' => $this->projects->all(),
        ]));
    }

    public function create(Request $request): Response
    {
        return Response::html($this->view->page('projects/create', [
            'errors' => [],
            'old' => [],
        ]));
    }

    public function store(Request $request): Response
    {
        $data = [
            'name' => trim((string) $request->input('name', '')),
            'description' => trim((string) $request->input('description', '')),
        ];

        $validator = new Validator();

        if (!$validator->validate($data, [
            'name' => ['required', 'max:255'],
        ])) {
            return Response::html($this->view->page('projects/create', [
                'errors' => $validator->errors(),
                'old' => $data,
            ]));
        }

        $id = $this->projects->create([
            'name' => $data['name'],
            'description' => $data['description'] ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return Response::redirect("/projects/{$id}");
    }

    public function show(Request $request): Response
    {
        $id = (int) $request->route('id');
        $project = $this->projects->find($id);

        if ($project === null) {
            return Response::notFound('Project not found.');
        }

        return Response::html($this->view->page('projects/show', [
            'project' => $project,
            'tasks' => $this->tasks->forProject($id),
        ]));
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->route('id');
        $project = $this->projects->find($id);

        if ($project === null) {
            return Response::notFound('Project not found.');
        }

        return Response::html($this->view->page('projects/edit', [
            'project' => $project,
            'errors' => [],
        ]));
    }

    public function update(Request $request): Response
    {
        $id = (int) $request->route('id');
        $project = $this->projects->find($id);

        if ($project === null) {
            return Response::notFound('Project not found.');
        }

        $data = [
            'name' => trim((string) $request->input('name', '')),
            'description' => trim((string) $request->input('description', '')),
        ];

        $validator = new Validator();

        if (!$validator->validate($data, [
            'name' => ['required', 'max:255'],
        ])) {
            return Response::html($this->view->page('projects/edit', [
                'project' => array_merge($project, $data),
                'errors' => $validator->errors(),
            ]));
        }

        $this->projects->update($id, [
            'name' => $data['name'],
            'description' => $data['description'] ?: null,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return Response::redirect("/projects/{$id}");
    }

    public function destroy(Request $request): Response
    {
        $id = (int) $request->route('id');
        $this->projects->delete($id);

        return Response::redirect('/projects');
    }
}
