<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Repositories\User\UserRepository;
use App\Repositories\Project\ProjectRepository;
use App\Repositories\Purpose\PurposeRepository;

class ProjectsController extends Controller
{
    private ProjectRepository $projectRepository;

    private UserRepository $userRepository;

    private PurposeRepository $purposeRepository;

    public function __construct(ProjectRepository $repository, UserRepository $userRepository, PurposeRepository $purposeRepository)
    {
        $this->projectRepository = $repository;
        $this->userRepository = $userRepository;
        $this->purposeRepository = $purposeRepository;
    }

    public function all()
    {
         return response([
            'availableUsers' => $this->userRepository->allNotAdmin(),
            'projects' => $this->projectRepository->all(),
            'purposes' => $this->purposeRepository->all(),
        ], 200);
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $this->projectRepository->store($data);
        return response(['message' => 'New EMS project sucessfully added',], 201);
    }    
     

    public function update(ProjectRequest $request)
    {
        $data = $request->validated();
        $this->projectRepository->update($data, $request->id);
        return response(['message' => 'Project ' . $data['project_info']['project_name'] . ' sucessfully updated',], 201);
    }

    public function delete(Request $request)
    {
        $this->projectRepository->delete($request->id);
        return response(['message' => 'Project sucessfully deleted'], 201);
    }

    public function participate(Request $request)
    {
        $projectId = $request->input('project_id');
        $userId = $request->input('user_id');
        $this->projectRepository->participate($projectId, $userId);
        return response(['message' => 'Sucessfully participated to the project'], 201);
    }

    public function exit(Request $request)
    {
        $projectId = $request->input('project_id');
        $userId = $request->input('user_id');
        $this->projectRepository->exit($projectId, $userId);
        return response(['message' => 'Sucessfully exited from project'], 201);
    }
    
}
