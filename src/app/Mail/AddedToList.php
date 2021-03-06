<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Applicant;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddedToList extends Mailable
{
    use SerializesModels;

    public User $user;

    public Applicant $applicant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Applicant $applicant, User $user)
    {
        $this->applicant = $applicant;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.list.added_to_list');
    }
}
