<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeletedAdminScope implements Scope{
    public function apply(Builder $builder, Model $model)
    {
        if(Auth::check() && Auth::user()->is_admin){
            //擇一
            // $builder->withTrashed();
            $builder->withoutGlobalScope(SoftDeletingScope::class);
        }
    }
}

