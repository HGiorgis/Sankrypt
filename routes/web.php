<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/debug-users', function () {
    $users = DB::table('users')->get();
    
    echo "<h1>Users in Database</h1>";
    foreach ($users as $user) {
        echo "Email: " . $user->email . "<br>";
        echo "Hash: " . $user->auth_key_hash . "<br>";
        echo "Hash Length: " . strlen($user->auth_key_hash) . "<br><br>";
    }
    
});