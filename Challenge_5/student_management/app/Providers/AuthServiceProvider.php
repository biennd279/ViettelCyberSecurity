<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Challenge;
use App\Models\Message;
use App\Models\Submission;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\ChallengePolicy;
use App\Policies\MessagePolicy;
use App\Policies\SubmissionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Assignment::class => AssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
        Challenge::class => ChallengePolicy::class,
        Message::class => MessagePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
