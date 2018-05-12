<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function destroy(User $user, Topic $topic)
    {
        return true;
    }

    public function update(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id;
    }
}
