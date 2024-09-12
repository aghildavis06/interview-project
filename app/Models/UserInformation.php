<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;
    protected $table = 'user_informations';

    protected $fillable = ['name', 'contact_no', 'profile_pic'];

    public function categories()
    {
        return $this->hasMany(UserCategory::class, 'user_id');
    }

    public function hobbies()
    {
        return $this->hasMany(UserHobby::class, 'user_id');
    }
}
