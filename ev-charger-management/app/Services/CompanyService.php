<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAllCompanies()
    {
        return $this->companyRepository->getAll();
    }

    public function getCompanyById($id)
    {
        return $this->companyRepository->find($id);
    }

    public function createCompany($data)
    {
        return $this->companyRepository->create($data);
    }

    public function updateCompany($id, $data)
    {
        return $this->companyRepository->update($id, $data);
    }

    public function deleteCompany($id)
    {
        $this->companyRepository->delete($id);
    }
}