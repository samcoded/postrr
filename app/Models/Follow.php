<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'follower_id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}