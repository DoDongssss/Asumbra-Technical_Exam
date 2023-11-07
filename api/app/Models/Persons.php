<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Firstname',
        'Lastname',
        'Middle_Initial',
        'Birthday',
        'Gender',
        'Date_registered',
    ];
}
