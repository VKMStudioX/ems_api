<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface 
{
    private Project $projectModel;

    public function __construct(Project $projectModel)
    {
        $this->projectModel = $projectModel;
    }
    
    public function get(int $id)
    {

    }

    public function all() 
    {
        return $this->projectModel->withRelations()->get();
    }

    public function store(array $data)
    {
        $project = $this->projectModel->create($data['project_info']);
        $project->users()->attach($data['project_users']);
        $project->technologies()->attach($data['project_technologies']);
    }

    public function update(array $data, int $id)
    {
        $project = $this->projectModel->getOne($id);
        $project->update($data['project_info']);
        $project->users()->sync($data['project_users']);
        $project->technologies()->sync($data['project_technologies']);
    }
    
    public function delete(int $id)
    {
        $project = $this->projectModel->withRelations()->getOne($id);
        $project->delete();
    }

    public function participate(int $projectId, int $userId)
    {
        $project = $this->projectModel->withRelations()->getOne($projectId);
        $project->users()->attach([$userId]);
    }

    public function exit(int $projectId, int $userId)
    {
        $project = $this->projectModel->withRelations()->getOne($projectId);
        $project->users()->detach([$userId]);
    }

}