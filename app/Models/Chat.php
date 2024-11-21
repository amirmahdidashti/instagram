<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\message;
use App\Models\User;
class Chat extends Model
{
    use HasFactory;

    public function messages(){
        return $this->hasMany(message::class);
    }
    
}
