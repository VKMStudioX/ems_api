<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectTechnology;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Methodology;
use App\Models\Purpose;
use App\Models\Type;


class ProjectsController extends Controller
{

    /**
     * Get all projects
     *
     * @param int $id
     * @return array
     */
    public function getAllProjects(Request $request): object
    {
        $projects = Project::with('project_technology')->get();
        $prjTechs = ProjectTechnology::with('purpose')->with('type')->with('methodology')->with('project')->with('technology')->get();
        $purposes = Purpose::all();
        $types = Type::all();
        $methodologies = Methodology::all();
        $technologies = Technology::all();

         return response([
            'projects' => $projects,
            'prjTechs' => $prjTechs,
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
        // $userAbsencesBG = Absence::with('defaults')->get();
        // $reminders = ReminderTemplate::all();

         return response([
            'prjTech' => $prjTech,
            // 'user_absences' => $userAbsences,
            // 'user_absences_BG' => $userAbsencesBG
        ], 200);

    }


}
