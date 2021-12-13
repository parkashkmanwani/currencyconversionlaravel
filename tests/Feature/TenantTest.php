<?php

namespace Tests\Feature;

use App\Models\Reseller;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class TenantTest extends TestCase
{
    private $reseller;

    public function setUp(): void
    {
        parent::setUp();

        $this->reseller = Reseller::factory()->make();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testListTenant()
    {
        $this->json('GET', 'reseller/'.$this->reseller->id.'/tenants')
            ->assertStatus(200);
    }
}
