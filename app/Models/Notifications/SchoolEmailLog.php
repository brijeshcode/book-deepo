<?php

namespace App\Models\Notifications;

use App\Traits\Authorable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolEmailLog extends Model
{
    use HasFactory,SoftDeletes,Authorable;
    protected $fillable = [ 'school_order_id', 'reciver_id', 'reciver_type', 'reciver_email', 'reciver_name', 'subject', 'body'];
}
