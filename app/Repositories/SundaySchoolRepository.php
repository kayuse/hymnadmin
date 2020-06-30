<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 4/17/20
 * Time: 8:09 AM
 */

namespace App\Repositories;


use App\SundaySchoolCategory;
use App\SundaySchoolManual;
use App\SundaySchoolTopic;

class SundaySchoolRepository
{
    protected $model;

    public function __construct(SundaySchoolManual $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->with('topics')->get();
    }

    public function topic($id)
    {
        $topic = SundaySchoolTopic::with('podcast')->where('id', $id)->get();
        return $topic;
    }

    public function categories()
    {
        return SundaySchoolCategory::all();
    }
}