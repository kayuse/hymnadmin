<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 4/17/20
 * Time: 8:09 AM
 */

namespace App\Repositories;


use App\CreditLog;
use App\Mail\ManualAssigned;
use App\Payment;
use App\PendingCreditLogs;
use App\RequestCopy;
use App\SundaySchoolCategory;
use App\SundaySchoolManual;
use App\SundaySchoolTopic;
use App\User;
use App\UserSundaySchoolManual;
use Illuminate\Support\Facades\Mail;

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

    public function getUnpaidManuals($id, $email = '')
    {
        $unpaidManuals = [];
        $manuals = $this->model->where('is_free', 0)->get();
        foreach ($manuals as $manual) {
            if (!$manual->isPaid($id)) {
                if ($this->sponsored($email, $manual->id)) {
                    $manual->sponsored = true;
                } else {
                    $manual->sponsored = false;
                }
                array_push($unpaidManuals, $manual);
            }
        }
        return $unpaidManuals;
    }

    public function sponsored($email, $manualId)
    {
        $log = PendingCreditLogs::where('assigned_to', $email)->where('reference_id', $manualId)->where('reference', 'sundayschool')->first();
        return $log != null;
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

    public function claim($manualId, $user)
    {
        $manual = SundaySchoolManual::find($manualId);

        $pendingCopy = PendingCreditLogs::where('assigned_to', $user->email)
            ->where('reference', 'sundayschool')->where('reference_id', $manualId)->first();
        if ($pendingCopy->claimed == true) {
            return UserSundaySchoolManual::where('manual_id', $manualId)->where('user_id', $user->id)->first();
        }
        $pendingCopy->claimed = true;
        $pendingCopy->save();
        $logData = [
            'from_user' => $pendingCopy->from_user_id,
            'to_user' => $user->id
        ];
        CreditLog::create($logData);
        $userManualData = [
            'user_id' => $user->id,
            'manual_id' => $manual->id,
            'copy' => 1,
        ];
        $userManualData = UserSundaySchoolManual::create($userManualData);
        return $userManualData;
    }

    public function getSponsored($manualId, $user)
    {
        return PendingCreditLogs::where('reference_id', $manualId)->where('from_user_id', $user->id)->get();
    }

    public function revoke($manualId, $email, $user)
    {
        $logs = PendingCreditLogs::where('assigned_to', $email)->where('reference_id', $manualId)->where('reference', 'sundayschool')->get();
        $userSSM = UserSundaySchoolManual::where('manual_id', $manualId)->where('user_id', $user->id)->first();
        $userSSM->copy++;
        $userSSM->save();
        foreach ($logs as $log) {
            $log->delete();
        }
        return true;
    }

    public function assign($manualId, $emails, $user)
    {
        $logs = [];
        $copy = count($emails);
        if (!$this->doesUserHasThisAvailableCopy($manualId, $user->id, $copy)) {
            return $logs;
        }
        $manual = $this->model->find($manualId);
        foreach ($emails as $email) {
            //send the person an email

            if ($this->doesUserHaveAccess($manualId, $email)) {
                continue;
            }
            $logData = [
                'from_user_id' => $user->id,
                'assigned_to' => $email,
                'reference' => 'sundayschool',
                'claimed' => false,
                'reference_id' => $manual->id
            ];
            $log = PendingCreditLogs::create($logData);
            $ssm = UserSundaySchoolManual::where('user_id', $user->id)->where('manual_id', $manualId)->first();
            $ssm->copy--;
            $ssm->save();
            Mail::to($email)->bcc(['ilanaa.soft@gmail.com'])->send(new ManualAssigned($manual, $user));
            array_push($logs, $log);
        }
        return $logs;
    }

    private function doesUserHasThisAvailableCopy($manualId, $userId, $copy)
    {
        $userManual = UserSundaySchoolManual::where('manual_id', $manualId)->where('user_id', $userId)->first();
       // dd($manualId,$userId);
        if ($userManual == null) {
            return false;
        }
        return ($userManual->copy - 1) >= $copy;
    }

    private function doesUserHaveAccess($manualId, $email)
    {
        $userManualCount = 0;
        $pendingRequestCount = PendingCreditLogs::where('assigned_to', $email)
            ->where('reference', 'sundayschool')->where('reference_id', $manualId)->count();

        $user = User::where('email', $email)->first();
        if ($user != null) {
            $userManualCount = UserSundaySchoolManual::where('manual_id', $manualId)->where('user_id', $user->id)->count();
        }
        return $pendingRequestCount > 0 || $userManualCount > 0;
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
