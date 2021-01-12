<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 4/17/20
 * Time: 8:09 AM
 */

namespace App\Repositories;


use App\Payment;
use App\RequestCopy;
use App\SundaySchoolCategory;
use App\SundaySchoolManual;
use App\SundaySchoolTopic;
use App\UserSundaySchoolManual;

class SundaySchoolRepository
{
    protected $model;

    public function __construct(SundaySchoolManual $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $result = $this->model->where('is_free', 1)->with('topics')->get();

        return $result;
    }

    public function pay($data, $user)
    {
        $manual = SundaySchoolManual::find($data['manual_id']);
        $paymentData = [
            'reference' => $data['reference'],
            'amount' => $data['amount'],
            'currency' => 'NGN',
            'user_id' => $user->id
        ];
        $payment = new Payment();
        $payment->reference = $data['reference'];
        $payment->amount = $data['amount'];
        $payment->currency = 'NGN';
        $payment->user_id = $user->id;
        $payment->save();
        $userManualData = [
            'user_id' => $user->id,
            'manual_id' => $manual->id,
            'copy' => $data['copy'],
        ];
        $userManualData = UserSundaySchoolManual::create($userManualData);
        return $userManualData;
    }

    public function getUnpaidManuals($id)
    {
        $unpaidManuals = [];
        $manuals = $this->model->where('is_free', 0)->get();
        foreach ($manuals as $manual) {
            if (!$manual->isPaid($id)) {
                array_push($unpaidManuals, $manual);
            }
        }
        return $unpaidManuals;
    }

    public function topic($id)
    {
        $topic = SundaySchoolTopic::with('podcast')->where('id', $id)->get();
        return $topic;
    }

    public function editSundaySchool($id, $data)
    {
        $topic = SundaySchoolTopic::find($id);
        $topic->topic = $data['topic'];
        $topic->aim = $data['aim'];
        $topic->number = $data['number'];
        $topic->bible_text = $data['bible_text'];
        $topic->category = $data['category'];
        $topic->introduction = $data['introduction'];
        $topic->content = $data['content'];

        $topic->save();
        return $topic;
    }

    public function newManual($data)
    {
        return $this->model->create($data);
    }

    public function newTopic($data)
    {
        $lesson = SundaySchoolTopic::create($data);
        return $lesson;
    }

    public function categories()
    {
        return SundaySchoolCategory::all();
    }

    public function getPaidManuals($userId)
    {
        $paidManuals = [];
        $manuals = $this->model->where('is_free', 0)->get();

        foreach ($manuals as $manual) {
            if ($manual->isPaid($userId)) {
                $fullManual = $this->model->where('id', $manual->id)->with('topics')->first();
                array_push($paidManuals, $fullManual);
            }
        }
        return $paidManuals;
    }

    public function createRequestCopy($userId, $manualID)
    {
        $data = ['user_id' => $userId, 'reference_id' => $manualID, 'copy_reference' => 'sunday_school_manual'];
        $requestCopy = RequestCopy::create($data);
        return $requestCopy;
    }
}
