<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EncryptedMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'encrypted_message', 'url_token',
    ];

    public $timestamps = false;
}
