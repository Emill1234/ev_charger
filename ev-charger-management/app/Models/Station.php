<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $table = 'station';
    protected $fillable = ['name', 'latitude', 'longitude', 'company_id', 'address'];

    // Relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
