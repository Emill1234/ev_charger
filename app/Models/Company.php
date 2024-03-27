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

    public static function descendantsAndSelf($parentId)
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

    public static function descendantsAndSelfWithCTE($parentId)
    {
        $cteQuery = "
            WITH RECURSIVE company_hierarchy AS (
                SELECT id
                FROM company
                WHERE id = ?
                UNION ALL
                SELECT c.id
                FROM company c
                INNER JOIN company_hierarchy ch ON ch.id = c.parent_company_id
            )
            SELECT id FROM company_hierarchy;
        ";

        $descendantsIds = \DB::select($cteQuery, [$parentId]);

        $descendantsAndSelfIds = array_map(function ($descendant) {
            return $descendant->id;
        }, $descendantsIds);

        return collect($descendantsAndSelfIds);
    }

}