<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\Project\ProjectRepository;

interface ProjectRepositoryInterface 
{
    public function get(int $id);

    public function all();

    public function store(array $data);

    public function update(array $data, int $id);
    
    public function delete(int $id);

    public function participate(int $projectId, int $userId);

    public function exit(int $projectId, int $userId);
}

