<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Project;
use App\Models\Purpose;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'availableUsers' => User::notAdmin()->get(),
            'projects' => Project::with(['technologies', 'users'])->get(),
            'purposes' => Purpose::with('types.methodologies.technologies')->get(),
        ];
    }
}
