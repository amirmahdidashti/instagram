<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'amirdashti264@gmail.com';
        $user->password = bcrypt(trim('amir1400'));
        $avatar = 'https://www.gravatar.com/avatar/'.hash( 'sha256', strtolower( trim( $user->email ) )).'?d=mp';
        $user->save();
        Image::create(['image' =>  $avatar, 'type' => 0 , 'subject_id' => $user->id]);
    }
}
