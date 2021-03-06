<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 2/11/19
 * Time: 6:00 PM
 */

namespace App\Repositories;

use App\AppUser;
use App\Hymn;
use App\HymnCategory;
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

    public function edit($id, $data)
    {
        $hymn = Hymn::find($id);

        $hymn->number = $data['number'];
        $hymn->extra = $data['extra'];
        $hymn->title = $data['title'];
        $hymn->chorus = $data['chorus'];

        foreach ($hymn->verses as $index => $verse) {
            $verse->forceDelete();
        }
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
        $hymn->verses()->saveMany($verses);
        $hymn->save();
        return $hymn;
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

    protected function updateRecord($id)
    {
        $record = Record::findOrFail($id);
        $record->enabled = true;
        $record->save();
    }

    public function getHymn($number)
    {
        $hymn = $this->model->where('number', $number)->first();
        $verses = $hymn->verses()->get();
        $hymn["verses"] = $verses;
        return $hymn;
    }

    public function all()
    {
        $hymns = $this->model->with('verses')->get();
        return $hymns;
    }

    public function userHymns($user)
    {
        $language = AppUser::where('user_id', $user->id)->first()->language;
        $hymns = $this->model->with('verses')->orderBy('number', 'asc')->get();
        return $hymns;
    }

    public function categories($user = null)
    {
        if ($user) {
            $language = $user->appUser->language;
            return HymnCategory::where('language', 'yoruba')->get();
        }
        return HymnCategory::all();
    }

    public function getUnfilledHymnNumbers()
    {
        $list = range(1, 601);
        $hymnNumbers = $this->model->pluck('number')->toArray();
        $unfilledHymnNumbers = array_diff($list, $hymnNumbers);

        return array_values($unfilledHymnNumbers);
    }

    public function new($data)
    {
        $data["user_id"] = Auth::user()->id;
        $hymn = $this->create($data);
        $verses = [];
        foreach ($data['verses'] as $verse) {
            $newVerse = new Verse([
                'number' => $verse["number"],
                'content' => $verse["content"]
            ]);
            array_push($verses, $newVerse);
        }
        $hymn->verses()->saveMany($verses);
        return $hymn;
    }

    public function newHymn($data)
    {
        $data["user_id"] = Auth::user()->id;
        $hymn = $this->create($data);
        $verses = [];
        foreach ($data['verses'] as $index => $verse) {
            $newVerse = new Verse([
                'number' => $index + 1,
                'content' => $verse
            ]);
            array_push($verses, $newVerse);
        }
        $hymn->verses()->saveMany($verses);
        return $hymn;
    }

    protected function stripVerses($verses)
    {
        $strippedVerses = [];
        $count = 0;
        foreach ($verses as $verse) {
            $strippedContent = $verse->getStrippedContent();
            $currentVerse = $verse;
            $currentVerse->strippedContent = $strippedContent;
            array_push($strippedVerses, $currentVerse);
            $count++;
        }
        return collect($strippedVerses);
    }
}
