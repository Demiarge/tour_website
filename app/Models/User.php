<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'userId';
    protected $table= 'users';
    protected $fillable= ['id','name','email','phone','password','role'];
}
