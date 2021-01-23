<?php

namespace App\Mail;

use App\SundaySchoolManual;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManualAssigned extends Mailable
{
    use Queueable, SerializesModels;
    public $manual;
    public $user;

    /**
     * Create a new message instance.
     * @param $manual
     * @param $user
     * @return void
     */
    public function __construct(SundaySchoolManual $manual, User $user)
    {
        $this->manual = $manual;
        $this->user = $user;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'manual' => $this->manual,
            'name' => $this->user->name
        ];
        return $this->subject('Congratulations, Someone just gifted you a free copy of ' . $this->manual->name)->view('mails.sundayschool.manual_assigned')->with($data);
    }
}
