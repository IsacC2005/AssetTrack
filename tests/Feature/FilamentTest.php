<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FilamentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_admin_panel_is_accessible_with_shield_permissions(): void
    {
        $adminRole = Role::create(['name' => 'super_admin']);

        $this->artisan('shield:install --quiet');

        $user = User::factory()->create();

        $user->assignRole($adminRole);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    // public function test_admin_panel_is_accessible(): void
    // {
    //     $user = User::factory()->create();

    //     $response = $this->actingAs($user)->get('/admin');

    //     $response->assertStatus(200);
    // }
}
