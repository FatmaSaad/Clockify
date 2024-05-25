<?php

namespace Tests\Feature;

use App\Globals\CONSTANTS;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\FrontApiTestCase;
use Illuminate\Support\Facades\Log;

class DistanceTest extends FrontApiTestCase
{
    //  use RefreshDatabase;
    protected $route = 'clock-ins';
    protected $full_attribute = [];

    /**
     * {@inheritDoc}
     */
    protected function responseShape(): array
    {
        return [
            '0.id' => 'integer',
            '0.lat' => 'double',
            '0.lon' => 'double',
            '0.user_id' => 'integer',
            '0.timestamp' => 'integer',
        ];
    }
    protected function attributes($missing = []): array
    {
        $full_attribute = array(
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'user_id' => User::all()->random()->id,
            'timestamp' => $this->faker->unixTime(),
        );
        return array_diff_key($full_attribute, array_flip($missing));
    }


    /**
     * Test Case for POST validaion data
     * and make sure that data not saved in database
     *
     * @return void
     */
    public function test_post_validation()
    {
        //check if data missing (lon and timestamp) attributes

        $this->failValidationPost($this->attributes(['lon','timestamp']),'','clock_ins');

    }

     /**
     * Test Case for POST rejection becouse location is out of ALLOWED_DISTANCE range
     * and make sure that data not saved in database
     *
     * @return void
     */
    public function test_post_rejected()
    {

        $this->attributes()['lat']=CONSTANTS::Consoleya_LAT +random_int(50,100);
        $this->attributes()['lon']=CONSTANTS::Consoleya_LON +random_int(50,100);
        $this->failPost($this->attributes(),'','clock_ins');

    }
    /**
     * Test Case for POST response
     * and make sure the response shape
     *
     * @return void
     */
    public function test_post_content()
    {
        $attributes=$this->attributes();
        $distance_between_points=vincentyGreatCircleDistance(
            $attributes['lat'],
            $attributes['lon'],
            CONSTANTS::Consoleya_LAT,
            CONSTANTS::Consoleya_LON 
        
        );
        Log::info($distance_between_points);

        if($distance_between_points > CONSTANTS::ALLOWED_DISTANCE)
        {
            $this->failPost($attributes,'','clock_ins');

        }else{
            $this->successPost($attributes,'','clock_ins');
        }


    }


    /**
     * Test Case for get response of content page
     * and make sure the response shape
     *
     * @return void
     */
    public function test_get_content()
    {

        $this->successGet($this->responseShape(),'/'.$this->attributes()['user_id']);
    }
    

  
  



 }
