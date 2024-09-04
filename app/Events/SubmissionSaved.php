<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubmissionSaved
{
    use Dispatchable, SerializesModels;

    public string $name;
    public string $email;

    /**
     * @param $name
     * @param $email
     */
    public function __construct($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
}
