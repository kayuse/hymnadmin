<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/11/19
 * Time: 6:00 PM
 */

namespace App\Repositories;

use App\Hymn;
use App\Record;
use App\Verse;
use Illuminate\Support\Facades\Auth;

class HymnRepository extends BaseRepository implements IHymnRepository
{
    public function __construct(Hymn $model)
    {
        parent::__construct($model);
    }

    public function getStats()
    {
        // TODO: Implement getStats() method.
        $hymnCount = $this->model->count();
        $recordCount = Record::count();
        $verseCount = Verse::count();
        $todayHymnCount = $this->model->whereDate('created_at', '=', date('Y-m-d'))
            ->where('user_id', Auth::user()->id)->count();
        $disabledRecordCount = Record::where('disabled', true)->count();
        $response = [
            'hymnCount' => $hymnCount,
            'recordCount' => $recordCount,
            'verseCount' => $verseCount,
            'todayHymnCount' => $todayHymnCount,
            'disabledRecordCount' => $disabledRecordCount
        ];

        return $response;
    }

    public function saveHymn($data, $recordId = null)
    {
        $hymn = $this->model->where('number', $data['number'])->first();
        if ($hymn != null) {
            return new class ()
            {
                public $status = 0;
                public $message = "This hymn already exist";
            };
        }
        $newHymn = new Hymn([
            'title' => $data['title'],
            'number' => $data['number'],
            'extra' => $data['extra'],
            'chorus' => $data['chorus'],
            'user_id' => Auth::user()->id
        ]);
        $newHymn->save();
        $verses = [];
        $verseNumber = 1;

        foreach ($data['verses'] as $verse) {
            $verse = new Verse([
                'number' => $verseNumber,
                'content' => $verse
            ]);
            array_push($verses, $verse);
            $verseNumber++;
        }
        $newHymn->verses()->saveMany($verses);

        if ($recordId != null) {
            $this->updateRecord($recordId);
        }
        return new class($newHymn)
        {
            public $status = 1;
            public $hymn;

            public function __construct($hymn)
            {
                $this->hymn = $hymn;
            }
        };
    }

    public function getHymn($number)
    {
        return $this->model->where('number', $number)->first();
    }

    protected function updateRecord($id)
    {
        $record = Record::findOrFail($id);
        $record->enabled = true;
        $record->save();
    }
}
