<?php

namespace TMS;

use Illuminate\Database\Eloquent\Model;

class MirrorSheet extends Model
{
	protected $table = 'mirrorsites_sheet';
    protected $primaryKey = 'id';
	
    protected $fillable = [
        'website', 'upwork_code', 'quote','amount','date','trello_url','status','payment_status','comments'
    ];
}
