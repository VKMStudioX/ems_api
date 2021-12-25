<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ProjectTechnology;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Methodology;
use App\Models\Purpose;
use App\Models\Type;
use App\Models\User;
use App\Models\ProjectUser;
use Illuminate\Validation\ValidationException;

class ProjectsController extends Controller
{

    /**
     * Get all projects
     *
     * @param void
     * @return array
     */
    public function getAllProjects(Request $request): object
    {
        $availableUsers = User::where('is_admin', '0')->get();
        $projectUsers = ProjectUser::with('user')->get();
        $projects = Project::with('project_technology')->get();
        $prjTechs = ProjectTechnology::with('purpose')->with('type')->with('methodology')->with('project')->with('technology')->get();
        $purposes = Purpose::all();
        $types = Type::all();
        $methodologies = Methodology::all();
        $technologies = Technology::all();

         return response([
            'availableUsers' => $availableUsers,
            'projectUsers' =>$projectUsers,
            'projects' => $projects,
            'prjTechs' => $prjTechs,
            'purposes' => $purposes,
            'types' => $types,
            'methodologies' => $methodologies,
            'technologies' => $technologies,
        ], 200);
    }

     /**
     * Validate user data for insert/update in DB.
     *
     * @param Request $request
     * @return object|null
     */
    private function validatedProjectData(Request $request)
    {
        try {
            $request->validate([
                'project_info.project_name' => 'required|string|min:3|max:45|unique:App\Models\Project,project_name',
                'project_info.client_name' => 'required|string|min:3|max:45',
                'project_info.project_info' => 'required|string|min:3|max:255',
                'project_info.project_start' => 'required',
                'project_info.project_end' => 'required',
            ]);
        } catch (ValidationException $e) {
            return $e->errors();
        }

        return null;
    }


    /**
     * Wrapper for the project info data from request
     *
     * @param Request $request
     * @return object|null
     */
    private function projectInfoData(Request $request)
    {
        $projectData = [
            'project_name' => $request->project_info['project_name'],
            'project_info' => $request->project_info['project_info'],
            'project_start' => date('Y-m-d 23:59:59', strtotime($request->project_info['project_start'])),
            'project_end' => date('Y-m-d 23:00:00', strtotime($request->project_info['project_end'])),
            'client_name' => $request->project_info['client_name'],
        ];

        if(property_exists($request, 'id') && !empty($request->id)) {
            $projectData['id'] = $request->id;
        }

        return $projectData;
    }

    /**
     * Wrapper for the project info data from request
     *
     * @param Request $request
     * @return object|null
     */
    private function projectUserData(Int $projectId, Array $projectUser, Int $id = null)
    {
        $projectUserData = [
            'project_id' => $projectId,
            'user_id' => $projectUser['id']
        ];

        if(!empty($id)) {
            $projectUserData['id'] = $id;
        }

        return $projectUserData;
    }

    /**
     * Wrapper for the project info data from request
     *
     * @param Request $request
     * @return object|null
     */
    private function projectTechData(Int $projectId, Array $projectTech, Int $id = null)
    {
        $projectTechData = [
            'project_id' => $projectId,
            'purpose_id' => $projectTech['purpose_id'],
            'type_id' => $projectTech['type_id'],
            'methodology_id' => $projectTech['methodology_id'],
            'technology_id' => $projectTech['id']
        ];

        if(!empty($id)) {
            $projectTechData['id'] = $id;
        }

        return $projectTechData;
    }



    /**
     * Only for EMS admins.
     * Add new EMS project.
     *
     * @param Request $request
     * @return Response
     */
    public function newProject(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        $validation = $this->validatedProjectData($request);

        if($validation) return response([
                'message' => $validation
            ], 406);

        try {

        $projectData = $this->projectInfoData($request);
        $project = Project::create($projectData);
        $projectId = $project->id;

        if(!empty($projectId)) {
        foreach ($request->project_users as $projectUser) {
        $projectUserData = $this->projectUserData($projectId, $projectUser);
        ProjectUser::create($projectUserData);
        }

        foreach ($request->project_technologies as $projectTech) {
            $projectTechData = $this->projectTechData($projectId, $projectTech);
            ProjectTechnology::create($projectTechData);
            }
        }

            $response = [
                'message' => 'New EMS project sucessfully added',
            ];

            return response($response, 201);

        } catch (Exception $e) {
           return response([
                'message' => 'Can not create project',
                'error' => $e], 401);
        }

    }


    private function getDiffOfArrays(Array $filter, Array $source) 
    {
        $compare = array_udiff($filter, $source, function ($obj_a, $obj_b) {
        return $obj_a['id'] - $obj_b['id'];});

        return $compare;
    }


      /**
     * Only for EMS admins.
     * Update EMS reminder.
     *
     * @param Request $request
     * @return Response
     */
    public function updateProject(Request $request)
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {

            $projectId = $request->id;

            $projectData = $this->projectInfoData($request);
            Project::updateOrCreate($projectData);

            $projectsUsersDb = ProjectUser::with('user')->where('project_id', '=', $projectId)->get()->toArray();
            $projectsUsers = array_map(function($o) { return $o['user'];}, $projectsUsersDb);
            $prjUsersToAdd = $this->getDiffOfArrays($request->project_users, $projectsUsers);
            $prjUsersToDelete = $this->getDiffOfArrays($projectsUsers, $request->project_users);

            foreach($prjUsersToDelete as $delete) {
                ProjectUser::where('user_id', '=', $delete['id'])->delete();
            }
            foreach($prjUsersToAdd as $add) {
                $projectUserData = $this->projectUserData($projectId, $add);
                ProjectUser::updateOrCreate($projectUserData);
            }

            $projectsTechs = ProjectTechnology::where('project_id', '=', $projectId)->get()->toArray();
            $prjTechsToAdd = $this->getDiffOfArrays($request->project_technologies, $projectsTechs);
            $prjTechsToDelete = $this->getDiffOfArrays($projectsTechs, $request->project_technologies);

            foreach($prjTechsToDelete as $delete) {
                ProjectTechnology::where('id', '=', $delete['id'])->delete();
            }
            foreach ($prjTechsToAdd as $add) {
                $projectTechData = $this->projectTechData($projectId, $add);
                ProjectTechnology::updateOrCreate($projectTechData);
            }

            return response([
                'message' => 'Project data updated'
            ], 200);

        } catch (Exception $e) {
            return response([
                'message' => 'Can not update project',
                'error' => $e
            ], 401);
        }
    }


    /**
     * Only for EMS admins.
     * Delete EMS user.
     *
     * @param Request $request
     * @return Response
     */
    public function deleteProject(Request $request): object
    {
        if (!auth()->user()->is_admin) {
            return response(['message' => 'permit deny'], 403);
        }

        try {
            $projectId = $request->id;

            $project = Project::where('id', '=', $projectId)->get();
            if(!empty($project)) {
            Project::destroy($project[0]['id']);
            }

            $projectsUsers = ProjectUser::where('project_id', '=', $projectId)->get();
             if(!empty($projectsUsers)) {
             foreach($projectsUsers as $projectUser) {
                ProjectUser::destroy($projectUser['id']);
                }
             };

             $projectsTechnologies = ProjectTechnology::where('project_id', '=', $projectId)->get();
             if(!empty($projectsTechnologies)) {
             foreach($projectsTechnologies as $projectTechnology) {
                ProjectTechnology::destroy($projectTechnology['id']);
                }
            };

            return response([
                'project' => $request->id,
                'message' => 'Project deleted',
                'prj' => $project,
            ], 200);

        } catch (Exception $e) {
           
            return response([
                'message' => 'Can not delete project',
                'error' => $e
            ], 403);
        }
    }


       /**
     * Only for EMS users.
     * Participate or exit user for (from) project.
     *
     * @param Request $request
     * @return Response
     */
    public function participateInProject(Request $request)
    {

        try {

            $projectId = $request->input('project_id');
            $userId = $request->input('user_id');

            $projectUser = ProjectUser::where('project_id', '=', $projectId)->where('user_id', '=', $userId)->first();

            if(!empty($projectUser)) {
                $projectUser->delete();
            } else {
                $projectUser = new ProjectUser;
                $projectUser->project_id = $projectId;
                $projectUser->user_id = $userId;
                $projectUser->save();
            }

            return response([
                'message' => 'Project data updated'
            ], 200);

        } catch (Exception $e) {
            return response([
                'message' => 'Can not update project',
                'error' => $e
            ], 401);
        }
    }

    /**
     * Get all projects techs
     *
     * @param int $id
     * @return array
     */
    public function getAllTechTemplates(Request $request): object
    {
        $purposes = Purpose::all();
        $types = Type::all();
        $methodologies = Methodology::all();
        $technologies = Technology::all();

         return response([
            'purposes' => $purposes,
            'types' => $types,
            'methodologies' => $methodologies,
            'technologies' => $technologies,
        ], 200);

    }

    /**
     * Get all projects techs
     *
     * @param int $id
     * @return array
     */
    public function getAllProjectTechnologies(Request $request): object
    {
        $prjTech = ProjectTechnology::with('type')->with('methodology')->with('project')->with('technology')->get();

         return response([
            'prjTech' => $prjTech,
        ], 200);

    }


}
