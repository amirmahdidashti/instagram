<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;
use Carbon\Carbon;
Carbon::setLocale('fa');
class comment extends Model
{
    use HasFactory;
}
