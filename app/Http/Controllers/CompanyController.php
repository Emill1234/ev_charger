<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Requests\CompanyShowRequest;
use App\Http\Requests\CompanyDeleteRequest;
use App\Services\CompanyService;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Company",
 *     description="Endpoints related to companies"
 * )
 * @OA\Info(
 *     title="Company API",
 *     version="1.0",
 *     description="API documentation for Company operations",
 *     @OA\Contact(name="Swagger API Team")
 * )
 * @OA\Server(
 *     url="https://example.localhost",
 *     description="API server"
 * )
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Company",
 *         @OA\Property(property="id", type="integer", description="Company ID"),
 *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
 *         @OA\Property(property="name", type="string", description="Company name"),
 *     ),
 *     @OA\RequestBody(
 *         request="CompanyRequest",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", description="Company ID"),
 *             @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
 *             @OA\Property(property="name", type="string", description="Company name"),
 *         )
 *     ),
 *     @OA\Schema(
 *         schema="CompanyResponse",
 *         @OA\Property(property="id", type="integer", description="Company ID"),
 *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
 *         @OA\Property(property="name", type="string", description="Company name"),
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Company not found"
 *     ),
 * )
 */

class CompanyController extends Controller
{
    protected $companyService;

    /**
     * CompanyController constructor.
     *
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Get all companies.
     *
     * @OA\Get(
     *     path="/api/companies",
     *     summary="Get all companies",
     *     tags={"Company"},
     *     @OA\Response(response=200, description="List of companies", @OA\JsonContent(type="array", @OA\Items(
     *         @OA\Property(property="id", type="integer", description="Company ID"),
     *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *         @OA\Property(property="name", type="string", description="Company name"),
     *     ))),
     * )
     */
    public function index()
    {
        $companies = $this->companyService->getAllCompanies();
        return response()->json($companies);
    }

    /**
     * Get a specific company by ID.
     *
     * @OA\Get(
     *     path="/api/companies/{id}",
     *     summary="Get a specific company",
     *     tags={"Company"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Company ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Company data", @OA\JsonContent(type="object", @OA\Property(
     *         property="id", type="integer", description="Company ID"),
     *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *         @OA\Property(property="name", type="string", description="Company name"),
     *     )),
     *     @OA\Response(response=404, description="Company not found"),
     * )
     */
    public function show($id)
    {
        $company = $this->companyService->getCompanyById($id);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json($company);
    }

    /**
     * Create a new company.
     *
     * @OA\Post(
     *     path="/api/companies",
     *     summary="Create a new company",
     *     tags={"Company"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="Company ID"),
     *             @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *             @OA\Property(property="name", type="string", description="Company name"),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Company created", @OA\JsonContent(type="object", @OA\Property(
     *         property="id", type="integer", description="Company ID"),
     *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *         @OA\Property(property="name", type="string", description="Company name"),
     *     )),
     * )
     */
    public function store(CompanyCreateRequest $request)
    {
        $companyData = $request->validated();
        $company = $this->companyService->createCompany($companyData);

        return response()->json($company, 201);
    }

    /**
     * Update a company by ID.
     *
     * @OA\Put(
     *     path="/api/companies/{id}",
     *     summary="Update a company",
     *     tags={"Company"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Company ID", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="Company ID"),
     *             @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *             @OA\Property(property="name", type="string", description="Company name"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Company updated", @OA\JsonContent(type="object", @OA\Property(
     *         property="id", type="integer", description="Company ID"),
     *         @OA\Property(property="parent_company_id", type="integer", description="Parent Company ID"),
     *         @OA\Property(property="name", type="string", description="Company name"),
     *     )),
     *     @OA\Response(response=404, description="Company not found"),
     * )
     */
    public function update(CompanyUpdateRequest $request, $id)
    {
        $company = $this->companyService->getCompanyById($id);

        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        $companyData = $request->validated();
        $company = $this->companyService->updateCompany($id, $companyData);

        return response()->json($company, 200);
    }

    /**
     * Delete a company by ID.
     *
     * @OA\Delete(
     *     path="/api/companies/{id}",
     *     summary="Delete a company",
     *     tags={"Company"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Company ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Company deleted"),
     *     @OA\Response(response=404, description="Company not found"),
     * )
     */
    public function destroy($id)
    {
        $this->companyService->deleteCompany($id);

        return response()->json(null, 204);
    }
}