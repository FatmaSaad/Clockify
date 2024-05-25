<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;

abstract class FrontApiTestCase extends ApiTestCase
{
    /**
     * Route of test case
     *
     * @var string
     */
    protected $route;

    /**
     * Route of test case
     *
     * @var string
     */
    protected $attributes;

    /**
     * Route of test case
     *
     * @var string
     */

    protected function generalAttributes($full_attribute, $missing = []): array
    {
        return array_diff_key($full_attribute, array_flip($missing));
    }
    /**
     * Define the response shape will be returned
     *
     * @return array
     */
    abstract protected function responseShape(): array;

    /**
     * Fail POST request
     *
     * @return void
     */
    protected function failPost($attributes, $uri = '', $tableName)
    {
        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(403);
        $this->assertDatabaseMissing($tableName, $attributes);

    }

    /**
     * Fail Validation POST request
     *
     * @return void
     */
    protected function failValidationPost($attributes, $uri = '', $tableName)
    {
        Log::info($attributes);

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(422);
        $this->assertDatabaseMissing($tableName, $attributes);
    }
    /**
     * Fail Validation POST request
     *
     * @return void
     */
    protected function failValidationPostWithoutDatabaseCheck($attributes, $uri = '')
    {

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(422);
    }
    /**
     * success POST request
     *
     * @return void
     */
    protected function successPost($attributes, $uri = '', $tableName = null)
    {

        $route = $this->route . $uri;
        $response = $this->post($route, $attributes);
        $response->assertStatus(201);
        if ($tableName != null) {
            $this->assertDatabaseHas($tableName, $attributes);
        }
    }

    /**
     * success GET request
     *
     * @return void
     */
    protected function successGet($responseShape, $uri = '')
    {
        $route = $this->route . $uri;
        $response = $this->get($route);
        $response->assertStatus(200);
         if ($response->getData()->data) {
            $response->assertJson(function (AssertableJson $json) use ($responseShape) {
                $data = Arr::dot($responseShape);
                foreach ($data as $key => $value) {
                    $json->whereType('data.' . $key, $value);
                }
                $json->etc();
            });
         }
    }
}
