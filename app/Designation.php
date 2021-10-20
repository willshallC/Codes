<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
	protected $table = 'designations';
    protected $primaryKey = 'id';

	protected $fillable = [
        'designation'
    ];
}
