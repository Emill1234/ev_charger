<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function getAll()
    {
        return Company::all();
    }

    public function find($id)
    {
        return Company::findOrFail($id);
    }

    public function create($data)
    {
        return Company::create($data);
    }

    public function update($id, $data)
    {
        $company = Company::findOrFail($id);
        $company->update($data);
        return $company;
    }

    public function delete($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
    }

    public function getChildCompanyIds($parentId)
    {
        return Company::descendantsAndSelfWithCTE($parentId);
    }
}