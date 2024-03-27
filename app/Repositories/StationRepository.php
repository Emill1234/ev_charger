<?php 

namespace App\Repositories;

use App\Models\Station;
use App\Repositories\CompanyRepository;

class StationRepository
{
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function all()
    {
        return Station::all();
    }

    public function find($id)
    {
        return Station::findOrFail($id);
    }

    public function create($data)
    {
        return Station::create($data);
    }

    public function update($id, $data)
    {
        $station = Station::findOrFail($id);
        $station->update($data);
        return $station;
    }

    public function delete($id)
    {
        $station = Station::findOrFail($id);
        $station->delete();
    }

    public function withinRadius($latitude, $longitude, $radius, $company_id)   
    {
        // Get all child companies for the given $company_id
        $companyIds = $this->companyRepository->getChildCompanyIds($company_id);

        // Haversine formula for distance calculation
        $haversine = "(6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude))))";

        // Query to get stations within the specified radius, ordered by distance
        $stations = Station::select(['*', \DB::raw("{$haversine} AS distance")])
            ->whereIn('company_id', $companyIds)
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->get();

        // Group stations by latitude and longitude
        $groupedStations = $stations->groupBy(['latitude', 'longitude']);

        // Transform grouped stations to array for a readable JSON response
        $groupedStationsArray = $groupedStations->map(function ($group) {
            return $group->toArray();
        });

        $groupedStationsArray = $groupedStationsArray->toArray();    

        return $groupedStationsArray;
    }
}