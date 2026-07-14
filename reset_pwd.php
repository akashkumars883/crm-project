<?php
$user = App\Models\User::whereHasRole('employee')->first();
if($user) {
    $user->password = bcrypt('password123');
    $user->save();
    echo $user->email;
} else {
    echo 'No employee found';
}
