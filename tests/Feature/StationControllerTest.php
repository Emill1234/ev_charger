<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Station;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Services\StationService;

class StationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $companyRepository;
    protected $stationService;

    public function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new CompanyRepository();
        $this->stationService = new StationService($this->companyRepository);
    }

    public function testIndex()
    {
        factory(Station::class, 5)->create();

        $response = $this->get('/api/stations');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['id', 'name', 'latitude', 'longitude', 'company_id', 'address'],
        ]);
        $response->assertJsonCount(5, '*');
    }

    public function testShow()
    {
        $station = factory(Station::class)->create();

        $response = $this->get('/api/stations/' . $station->id);

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'name', 'latitude', 'longitude', 'company_id', 'address']);
        $response->assertJson(['id' => $station->id]);
    }

    public function testStore()
    {
        $stationData = factory(Station::class)->make()->toArray();

        $response = $this->post('/api/stations', $stationData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('stations', $stationData);
    }

    public function testUpdate()
    {
        $station = factory(Station::class)->create();
        $newData = factory(Station::class)->make()->toArray();

        $response = $this->put('/api/stations/' . $station->id, $newData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('stations', $newData);
        $this->assertDatabaseMissing('stations', $station->toArray());
    }

    public function testDestroy()
    {
        $station = factory(Station::class)->create();

        $response = $this->delete('/api/stations/' . $station->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('stations', $station->toArray());
    }

    public function testStationsWithinRadius()
    {
        $companyA = factory(Company::class)->create();
        $companyB = factory(Company::class)->create(['parent_company_id' => $companyA->id]);
        $stationA = factory(Station::class)->create(['company_id' => $companyA->id]);
        $stationB = factory(Station::class)->create(['company_id' => $companyB->id]);

        $latitudeA = 10.0;
        $longitudeA = 20.0;
        $latitudeB = 10.1;
        $longitudeB = 20.1;

        $this->companyRepository->shouldReceive('getChildCompanyIds')->with($companyA->id)->andReturn([$companyB->id]);

        $response = $this->json('GET', '/api/stations-within-radius', [
            'latitude' => $latitudeA,
            'longitude' => $longitudeA,
            'radius' => 50,
            'company_id' => $companyA->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['latitude', 'longitude', 'company_id'],
        ]);
        $response->assertJsonCount(2, '*');
        $response->assertJsonFragment(['latitude' => $latitudeA, 'longitude' => $longitudeA]);
        $response->assertJsonFragment(['latitude' => $latitudeB, 'longitude' => $longitudeB]);
    }
}