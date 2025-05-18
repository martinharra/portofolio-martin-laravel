<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;
    
    protected $table = 'admin'; // Specify the table name if it's different from the model name
    protected $fillable = ['name', 'email', 'password', 'role']; // Fillable fields for mass assignment
    protected $hidden = ['password', 'remember_token']; // Hidden fields for serialization
}
