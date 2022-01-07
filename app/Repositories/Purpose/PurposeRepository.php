<?php

namespace App\Repositories\Purpose;


use App\Models\Purpose;
use App\Repositories\Purpose\PurposeRepositoryInterface;

class PurposeRepository implements PurposeRepositoryInterface 
{
    private Purpose $purposeModel;

    public function __construct(Purpose $purposeModel)
    {
        $this->purposeModel = $purposeModel;
    }
    
    public function all() 
    {
        return $this->purposeModel->withRelations()->get();
    }


}