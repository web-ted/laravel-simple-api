<?php

namespace Tests\Feature;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\API\UsersController;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $users;

    private $usersCollection;

    /**
     * @test As a client I want to list all users
     * @covers UsersController::index
     *
     * @return void
     */
    public function isUserListingWorking()
    {
        $response = $this->json('GET', '/api/users');
        //dd($response);
        $response->assertJson(['count' => 10])
            ->assertJsonStructure([
                'count',
                'users' => [
                    '*' => [
                        'id',
                        'email',
                        'name',
                        'verified',
                    ],
                ],
            ])
            ->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->users = User::all();
        $this->usersCollection = new UserCollection($this->users);
    }
}
