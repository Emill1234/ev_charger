<?php 

namespace App\Services;

use App\Repositories\StationRepository;

class StationService
{
    protected $stationRepository;

    public function __construct(StationRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    public function getStationsWithinRadius($latitude, $longitude, $radius, $company_id)
    {
        return $this->stationRepository->withinRadius($latitude, $longitude, $radius, $company_id);
    }
}
