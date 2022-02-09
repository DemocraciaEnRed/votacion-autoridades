<?php

namespace Tests\Feature\App;

use App\Models\User;
use App\Notifications\ChangePassword;
use App\Notifications\UserNotValidated;
use App\Notifications\UserValidated;
use App\Notifications\VoteReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function getUser () {

        $user = User::where('email', 'rodri@bitopia.digital')
            ->first();

        if(empty($user)) {
            $this->assertFalse(false);
        }

        return $user;
    }

    public function testNotificationNotValidated()
    {
        $user = $this->getUser();

        $user->notify(new UserNotValidated($user));

        $this->assertTrue(true);
    }

    public function testNotificationValidated()
    {
        $user = $this->getUser();

        $user->notify(new UserValidated($user));

        $this->assertTrue(true);
    }

    public function testNotificationVoteReceived()
    {
        $user = $this->getUser();

        $user->notify(new VoteReceived($user));

        $this->assertTrue(true);
    }

    public function testNotificationChangePassword()
    {
        $user = $this->getUser();

        $user->notify(new ChangePassword($user));

        $this->assertTrue(true);
    }
}
