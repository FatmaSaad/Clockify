<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClockInStoreRequest;
use App\Http\Resources\ClockInResource;
use App\Models\ClockIn;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Globals\CONSTANTS;

class ClockInController extends Controller
{
    use ApiResponse;


    /**
     * @OA\Get(
     *      path="/api/clock-ins/{user_id}",
     *      operationId="getUserClockIns",
     *      tags={"clock-ins"},
     *      summary="Get User Clock Ins",
     *      description="Returns list of Clock Ins",
     *      @OA\Parameter(
     *          name="user_id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(format="int64", title="user_id", default=1, description="user_id", property="user_id"),
     *              @OA\Property(format="string", title="lat", default="30.04938057206335", description="lat", property="lat"),
     *              @OA\Property(format="string", title="lon", default="31.240298953189804", description="lon", property="lon"),
     *              @OA\Property(format="integer", title="timestamp", default="1716001402", description="timestamp", property="timestamp"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function index(User $user)
    {
        $clockIns = $user->clockins;
        return $this->successResponse(ClockInResource::collection($clockIns));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *      path="/clock-ins",
     *      operationId="storeClockIn",
     *      tags={"clock-ins"},
     *      summary="Store new clock-in",
     *      description="Returns clock-in data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(format="int64", title="worker_id", default=1, description="worker_id", property="worker_id"),
     *              @OA\Property(format="string", title="lat", default="30.04938057206335", description="lat", property="lat"),
     *              @OA\Property(format="string", title="lon", default="31.240298953189804", description="lon", property="lon"),
     *              @OA\Property(format="integer", title="timestamp", default="1716001402", description="timestamp", property="timestamp"),
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="worker_id",
     *          description="worker id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="lat",
     *          description="lat",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="decimal"
     *          ),
     * 
     *      ),
     *      @OA\Parameter(
     *          name="lon",
     *          description="lon",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="decimal"
     *          ),
     * 
     *      ),
     *      @OA\Parameter(
     *          name="timestamp",
     *          description="timestamp",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="unix timestamp"
     *          ),
     * 
     *      ),
     * 
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(format="int64", title="user_id", default=1, description="user_id", property="user_id"),
     *              @OA\Property(format="string", title="lat", default="30.04938057206335", description="lat", property="lat"),
     *              @OA\Property(format="string", title="lon", default="31.240298953189804", description="lon", property="lon"),
     *              @OA\Property(format="integer", title="timestamp", default="1716001402", description="timestamp", property="timestamp"),

     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="The request was well-formed but there is validation error",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden, the distance is out of range."
     *      )
     * )
     */
    public function store(ClockInStoreRequest $request)
    {
        if ($request->lat  && $request->lon) {

            $distance = vincentyGreatCircleDistance(
                CONSTANTS::Consoleya_LAT,
                CONSTANTS::Consoleya_LON,
                $request->lat,
                $request->lon
            );
            if ($distance > CONSTANTS::ALLOWED_DISTANCE) {

                //client does not have access rights to the action; 

                return $this->errorResponse("the distance is " . $distance . " and it's out of range", 403);
            } else {

                $clockIn = ClockIn::create([
                    'user_id' =>   $request->worker_id,
                    'lat' =>  $request->lat,
                    'lon' =>  $request->lon,
                    'timestamp' =>  $request->timestamp,

                ]);

                return $this->successResponse(new ClockInResource($clockIn),201);
            }
        }
    }
}
