<?php
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the login page')->get('/auth/login')->assertOk();

it('redirects an authenticated user', function() {
    expect(User::factory()->create())->toBeRedirectedFor('/auth/login');
});

it('is Thai', function () {
    expect('Thai')->toBeThai();
});

/*it('redirects an authenticated user', function () {
    //$user = User::factory()->create();
    actingAs(User::factory()->create())
        ->get('/auth/login')
        ->assertStatus(302);
});*/

it('shows an error if details are not provided')
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