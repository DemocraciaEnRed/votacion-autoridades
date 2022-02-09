<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerification extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSendNotification()
    {

        $user = User::find(1);

        $user->notify(new EmailVerification($user));

        $this->assertTrue(true);
    }
}
