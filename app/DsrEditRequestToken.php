<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class DsrEditRequestToken extends Model
{
	protected $table = 'dsr_edit_request_token';
    protected $primaryKey = 'id';

	protected $fillable = [
        'employee_id','issued_by','issued_for_date','valid_till_date','token_number','issued_at','requested_at'
    ];
}
