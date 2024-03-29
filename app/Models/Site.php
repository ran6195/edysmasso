<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'domainName',
        'J4',
        'token'
    ];

    public function utenti(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(SiteUser::class)->withTimestamps()->wherePivot('deleted_at');
    }
}
