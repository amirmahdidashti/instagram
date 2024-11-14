<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\message;
class Chat extends Model
{
    use HasFactory;

    public function messages(){
        return $this->hasMany(message::class);
    }
}
