<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class BAWorkSheet extends Model
{
	protected $table = 'business_analyst_work_sheet';
    protected $primaryKey = 'id';
	
    protected $fillable = [
        'id', 'employee_id', 'date', 'platform','profile_id','job_title','job_url','cost','cost_type','status','comments'
    ];
}
