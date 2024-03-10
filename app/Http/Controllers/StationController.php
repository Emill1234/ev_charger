<?php

namespace App\Http\Controllers;

use App\Http\Requests\StationStoreRequest;
use App\Http\Requests\StationUpdateRequest;
use App\Http\Requests\StationsWithinRadiusRequest;
use App\Services\StationService;
use App\Repositories\StationRepository;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Station",
 *     description="Endpoints related to stations"
 * )
 * @OA\Server(
 *     url="https://localhost/",
 *     description="API server"
 * )
 */

class StationController extends Controller
{
    protected $stationService;
    protected $stationRepository;

    /**
     * StationController constructor.
     *
     * @param StationService $stationService
     * @param StationRepository $stationRepository
     */
    public function __construct(StationService $stationService, StationRepository $stationRepository)
    {
        $this->stationService = $stationService;
        $this->stationRepository = $stationRepository;
    }

    /**
     * Get all stations.
     *
     * @OA\Get(
     *     path="/api/stations",
     *     summary="Get all stations",
     *     tags={"Station"},
     *     @OA\Response(response=200, description="List of stations")),
     * )
     */
    public function index()
    {
        $stations = $this->stationRepository->all();
        return response()->json($stations);
    }

    /**
     * Get a specific station by ID.
     *
     * @OA\Get(
     *     path="/api/stations/{id}",
     *     summary="Get a specific station",
     *     tags={"Station"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Station ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Station data"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function show($id)
    {
        $station = $this->stationRepository->find($id);

        if (!$station) {
            return response()->json(['error' => 'Station not found'], 404);
        }

        return response()->json($station);
    }

    /**
     * Create a new station.
     *
     * @OA\Post(
     *     path="/api/stations",
     *     summary="Create a new station",
     *     tags={"Station"},
     *     @OA\Response(response=201, description="Station created"),
     * )
     */
    public function store(StationStoreRequest $request)
    {
        $station = $this->stationRepository->create($request->all());

        return response()->json($station, 201);
    }

    /**
     * Update a station by ID.
     *
     * @OA\Put(
     *     path="/api/stations/{id}",
     *     summary="Update a station",
     *     tags={"Station"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Station ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Station updated"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function update(StationUpdateRequest $request, $id)
    {
        $station = $this->stationRepository->find($id);

        if (!$station) {
            return response()->json(['error' => 'Station not found'], 404);
        }

        $station->update($request->all());

        return response()->json($station, 200);
    }

    /**
     * Delete a station by ID.
     *
     * @OA\Delete(
     *     path="/api/stations/{id}",
     *     summary="Delete a station",
     *     tags={"Station"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Station ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Station deleted"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function destroy($id)
    {
        $station = $this->stationRepository->find($id);

        if (!$station) {
            return response()->json(['error' => 'Station not found'], 404);
        }

        $station->delete();

        return response()->json(null, 204);
    }

    /**
     * Get stations within a specified radius.
     *
     * @OA\Post(
     *     path="/api/stations/within-radius",
     *     summary="Get stations within a specified radius",
     *     tags={"Station"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="latitude", type="number", description="Latitude of the center point"),
     *             @OA\Property(property="longitude", type="number", description="Longitude of the center point"),
     *             @OA\Property(property="radius", type="number", description="Radius in kilometers"),
     *             @OA\Property(property="company_id", type="integer", description="ID of the company"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Stations within the specified radius")),
     * )
     */
    public function stationsWithinRadius(StationsWithinRadiusRequest $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius');
        $company_id = $request->input('company_id');

        $stations = $this->stationService->getStationsWithinRadius($latitude, $longitude, $radius, $company_id);

        return response()->json($stations);
    }
}