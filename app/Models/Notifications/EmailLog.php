<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [ 'reciver_id', 'reciver_model' ,'to_email', 'subject', 'body', 'user_id', 'user_ip'];
}
