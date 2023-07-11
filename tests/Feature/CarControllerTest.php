<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_car(): void
    {
        $response = $this->postJson('/api/cars', [
            'name' => 'Sergiy',
            'registration_number' => 'AE1515DS',
            'color' => 'red',
            'vin_code' => '5NPE24AFXFH183476',
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Car save successful']);
        $this->assertDatabaseHas('cars', [
            'registration_number'=>'AE1515DS',
            'color'=>'red',
            'vin_code' => '5NPE24AFXFH183476',
            'model_year' => '2015'
        ]);
        $this->assertDatabaseHas('makes', [
            'name'=>'HYUNDAI'
        ]);
        $this->assertDatabaseHas('car_models', [
            'name'=>'Sonata'
        ]);
        $this->assertDatabaseHas('owners', [
            'name'=>'Sergiy'
        ]);
    }
}
