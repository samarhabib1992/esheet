<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These attributes can be filled through mass assignment.
     *
     * @var array
     */
    protected $fillable = ['company_name', 'mobile_number', 'phone_number', 'address', 'email', 'smtp_mail_host', 'smtp_mail_port', 'smtp_mail_username', 'smtp_mail_password', 'smtp_mail_from_address', 'smtp_mail_from_name', 'logo'];
}
