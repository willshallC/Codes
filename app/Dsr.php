<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class Dsr extends Model
{
	protected $table = 'dsr';
    protected $primaryKey = 'id';

	protected $fillable = [
        'project_id','category_id','subcategory_id','employee_id','dsr_date','time_spent','description','filled_by_token_id' ,'created_at','updated_at'
    ];
}
