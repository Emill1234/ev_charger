<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Company;

class CompanyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        factory(Company::class, 5)->create();

        $response = $this->get('/api/companies');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'parent_company_id', 'name'],
        ]);
        $response->assertJsonCount(5, '*');
    }

    public function testShow()
    {
        $company = factory(Company::class)->create();

        $response = $this->get('/api/companies/' . $company->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'parent_company_id', 'name']);
        $response->assertJson(['id' => $company->id]);
    }

    public function testStore()
    {
        $companyData = factory(Company::class)->make()->toArray();

        $response = $this->post('/api/companies', $companyData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', $companyData);
    }

    public function testUpdate()
    {
        $company = factory(Company::class)->create();
        $newData = factory(Company::class)->make()->toArray();

        $response = $this->put('/api/companies/' . $company->id, $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', $newData);
        $this->assertDatabaseMissing('companies', $company->toArray());
    }

    public function testDestroy()
    {
        $company = factory(Company::class)->create();

        $response = $this->delete('/api/companies/' . $company->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('companies', $company->toArray());
    }
}