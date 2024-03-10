<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = ['parent_company_id', 'name'];

    // Relationship with Stations
    public function stations()
    {
        return $this->hasMany(Station::class, 'company_id');
    }

    // Relationship with Parent Company
    public function parentCompany()
    {
        return $this->belongsTo(Company::class, 'parent_company_id');
    }

    // Relationship with Child Companies
    public function childCompanies()
    {
        return $this->hasMany(Company::class, 'parent_company_id');
    }

    public function descendantsAndSelf($parentId)
    {
        $parentCompany = Company::find($parentId);

        // Return an empty collection if the parent company is not found
        if (!$parentCompany) {
            return collect();
        }

        $descendantsAndSelf = collect([$parentId]);

        // Recursive function to fetch all descendants
        $fetchDescendants = function ($company) use (&$fetchDescendants, &$descendantsAndSelf) {
            $children = $company->childCompanies()->get();
            foreach ($children as $child) {
                $descendantsAndSelf->push($child->id); // Add child ID to the collection
                $fetchDescendants($child); // Recursively fetch descendants
            }
        };

        $fetchDescendants($parentCompany);

        return $descendantsAndSelf->unique();
    }

}