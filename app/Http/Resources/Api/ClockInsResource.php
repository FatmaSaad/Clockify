<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;


class ClockInsResource extends JsonResource
{
   
     /**
     *
     * @OA\Schema(
     *     schema="ClockIn",
     *   @OA\Xml(name="ClockIn"),
     *   @OA\Property(property="message", type="string", example="ClockIn"),
     *   @OA\Property(property="errors", type="object",
     *     @OA\AdditionalProperties(type="array",
     *       @OA\Items(
     *           @OA\Property(format="int64", title="user_id", default=1, description="user_id", property="user_id"),
     *           @OA\Property(format="string", title="lat", default="30.04938057206335", description="lat", property="lat"),
     *           @OA\Property(format="string", title="lon", default="31.240298953189804", description="lon", property="lon"),
     *           @OA\Property(format="integer", title="timestamp", default="1716001402", description="timestamp", property="timestamp"),
     *
     *       )
     *     )
     *   ),
     * )

     *
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'timestamp'=>$this->timestamp
            
        ];
    }
}
