<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $request = request();

        $validateProjectName = 'required|string|min:3|max:45|unique:App\Models\Project,project_name';
        
        if(!empty($request->id)) {
            $validateProjectName = 'required|string|min:3|max:45';
        } 
                
        return [
            'project_info.id' => 'integer',
            'project_info.project_name' => $validateProjectName,
            'project_info.client_name' => 'required|string|min:3|max:45',
            'project_info.project_info' => 'required|string|min:3|max:255',
            'project_info.project_start' => 'required',
            'project_info.project_end' => 'required',
            'project_users' => 'required',
            'project_technologies' => 'required'
        ];
    }
}
