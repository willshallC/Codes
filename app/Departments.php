<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
	protected $table = 'departments';
    protected $primaryKey = 'id';

	protected $fillable = [
        'department', 
    ];
}
