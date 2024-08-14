<?php

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the register page')->get('/auth/register')->assertStatus(200);

/*it('has errors if the details are not provided', function () {
    $this->post('/register')
        ->assertSessionHasErrors(['name', 'email', 'password']);
});*/

//High order test
it('has errors if the details are not provided')
    ->post('/register')
    ->assertSessionHasErrors(['name', 'email', 'password']);

/*it('registers the user', function () {
    $this->post('/register', [
        'name' => 'Thai',
        'email' => 'thai@test.com',
        'password' => 'thaitestpsw'
    ])
    ->assertRedirect('/');

    $this->assertDatabaseHas('users', ['name' => 'Thai', 'email' => 'thai@test.com'])
        ->assertAuthenticated();
});*/

//High order test
it('registers the user')
    ->tap(function () {
        $this->post('register', [
            'name' => 'Thai',
            'email' => 'thai@test.com',
            'password' => 'thaitestpsw'
        ])
        ->assertRedirect('/');
    })
    ->assertDatabaseHas('users', ['name' => 'Thai', 'email' => 'thai@test.com'])
    ->assertAuthenticated();
    
