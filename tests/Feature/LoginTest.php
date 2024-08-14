<?php
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects an authenticated user', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
        ->get('/auth/login')
        ->assertStatus(302);
});

it('shows an error if details are ot provided')
    ->post('login')
    ->assertSessionHasErrors(['email', 'password']);

it('logs the user in', function () {
    $user = User::factory()->create([
       'password' => bcrypt('thaitestpsw')
    ]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'thaitestpsw'
    ])
        ->assertRedirect('/');

    $this->assertAuthenticated();
});