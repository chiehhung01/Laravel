<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function viewAnyEmployer(User $user): bool
    {
        return true;
    }
    
    public function view(?User $user, Job $job): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->employer!== null;
    }

    
    public function update(User $user, Job $job): bool|Response
    {
        if($job->employer->user_id !== $user->id)
        {
            return false;
        }
        //這段程式碼確保在已經有人應聘的工作職位上，不允許進行特定的更改操作。
        if($job->jobApplications()->count() > 0)
        {
            return Response::deny('Connot change the job with applications');
        }

        return true;
    }

    
    public function delete(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }

    public function restore(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }

   
    public function forceDelete(User $user, Job $job): bool
    {
        return $job->employer->user_id === $user->id;
    }

    public function apply(User $user, Job $job) : bool
    {
        return !$job->hasUserApplied($user);
    }
}
