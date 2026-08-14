<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityLogHelper
{
    public static function log(string $action, string $description, ?int $userId = null): void
    {
        DB::table('activity_logs')->insert([
            'user_id'     => $userId ?? Auth::id(),
            'action'      => $action,
            'description' => $description,
            'created_at'  => now(),
        ]);
    }
}