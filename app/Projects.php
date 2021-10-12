<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
	protected $table = 'projects';
    protected $primaryKey = 'id';

	protected $fillable = [
        'department_ids', 'project_title', 'url','start_date','end_date', 'priority', 'description', 'created_at', 'updated_at','billing_type','project_cost','hourly_rate','platform','time_allocated','client_name','client_email','client_skype','client_country','sales_executive','status','hired_by_other','upwork_profile_name'
    ];
}
