<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testSuccessfulRegisteration()
    {

        $registerForm = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => '00000000'
        ];

        $response = $this->json('POST','/api/register' , $registerForm , ['accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'accessToken',
                'message'
            ]);



    }

    public function testLoginForm()
    {

        $this->postJson('/api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }


    public function testSuccessfulLogin()
    {
        $loginForm = [
            'email' => 'test@test.com',
            'password' => '00000000'
        ];

        $response = $this->postJson('api/login' , $loginForm , ['accept' => 'application/json' ])
            ->assertStatus(200)
            ->assertJsonStructure([
                "user" => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
                'accessToken',
                'message'
            ]);

        $this->assertAuthenticated();
        DB::table('users')->delete();






    }
}
