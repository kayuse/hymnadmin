<?php

namespace App\Repositories;



use Illuminate\Http\Request;

interface IInspirationRepository extends IBaseRepository
{
    public function newInspiration(Request $request);
    public function updateInspiration(Request $request, $id);
}
