<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Quiz;

class QuizPolicy
{
    public function create(User $user)
    {
        return $user->id !== null; // Any authenticated user can create a quiz
    }

    public function update(User $user, Quiz $quiz)
    {
        return $user->id === $quiz->user_id;
    }

    public function delete(User $user, Quiz $quiz)
    {
        return $user->id === $quiz->user_id;
    }

    public function publish(User $user)
    {
        return $user->id === 1; // Only admin can publish quizzes
    }
}
