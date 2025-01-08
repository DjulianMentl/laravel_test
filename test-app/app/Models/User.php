<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'active'];

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withPivot('expired_at');
    }
}
