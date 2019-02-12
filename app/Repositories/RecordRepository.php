<?php
namespace App\Repositories;

use App\Record;
use Illuminate\Support\Facades\Auth;

/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/2/19
 * Time: 8:28 AM
 */
class RecordRepository extends BaseRepository implements IRecordRepository
{
    const LIMIT = 10;

    public function __construct(Record $model)
    {
        parent::__construct($model);
    }

    public function newRecord(string $data)
    {
        $user = Auth::user();
        $records = json_decode($data, true);
        $ids = [];
        foreach ($records as $record) {
            $extra = '';
            $content = '';
            $number = -1;
            $title = '';

            if (!empty($record['extra'])) {
                $extra = $record['extra'];
            }
            if (!empty($record['verse'])) {
                $content = json_encode($record['verse']);
            }
            if (!empty($record['number'])) {
                $number = intval($record['number']);
            }
            if (!empty($record['title'])) {
                $title = $record['title'];
            }

            $data = [
                'extra' => $extra,
                'number' => $number,
                "data" => $content,
                'title' => $title,
                'user_id' => $user->id
            ];
            $result = $this->create($data);
            array_push($ids, $result->id);
        }
        return $ids; // TODO: Change the autogenerated stub
    }

    public function fetch($page)
    {
        $paginateCount = $page * self::LIMIT;
        $result = $this->model->where('enabled', false)->where('disabled', false)->paginate($paginateCount);
        return $result;
    }

    public function show($id)
    {
        //return $this->model->where('enabled', false)->where('disabled', false)->where('id', $id)->first();
           return parent::show($id); // TODO: Change the autogenerated stub
    }

    public function disable($id)
    {
        $record = parent::show($id);
        $record->disabled = true;
        $record->save();
        return $record;
    }
}
