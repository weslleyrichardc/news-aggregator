<?php

use App\Models\User;

describe('Laravel Sanctum', function () {
    test('can register', function () {
        $userFactory = User::factory()->make();

        $response = $this->post('/api/user/register', [
            "name" => $userFactory->getAttribute('name'),
            "email" => $userFactory->getAttribute('email'),
            "password" => "password"
        ]);
        $json = $response->json();

        expect($response->getStatusCode())
            ->toBe(201)
            ->and($json)->toHaveKeys(["user", "token"])
            ->and($json["user"]["name"])->toBeString($userFactory->getAttribute('name'))
            ->and($json["user"]["email"])->toBeString($userFactory->getAttribute('email'))
            ->and($json["token"])->not()->toBeNull();

        $userCreated = User::query()->where("email", $userFactory->getAttribute('email'))->first();
        expect($userCreated->getAttribute('name'))->toEqual($userFactory->getAttribute('name'))
            ->and($userCreated->getAttribute('email'))->toEqual($userFactory->getAttribute('email'))
            ->and($userCreated->getAttribute('token'))->toEqual($userFactory->getAttribute('token'))
            ->and($userCreated->getAttribute('token_type'))->toEqual($userFactory->getAttribute('token_type'));
    });

    test('can login', function () {
        $userFactory = User::factory()->create();

        $response = $this->post('/api/user/login', [
            "email" => $userFactory->getAttribute('email'),
            "password" => "password"
        ]);
        $json = $response->json();

        expect($response->getStatusCode())->toBe(200)
            ->and($json)->toHaveKeys(["user", "token", "token_type"])
            ->and($json["user"]["name"])->toBeString($userFactory->getAttribute('name'))
            ->and($json["user"]["email"])->toBeString($userFactory->getAttribute('email'))
            ->and($json["token"])->not()->toBeNull()
            ->and($json["token_type"])->toBeString('Bearer');
    });

    test('can logout', function () {
        $userFactory = User::factory()->create();
        $token = $userFactory->createToken('auth_token')->plainTextToken;

        $response = $this
            ->withToken($token)
            ->post('/api/user/logout');
        $json = $response->json();

        expect($response->getStatusCode())->toBe(200)
            ->and($json)->toHaveKeys(["message"])
            ->and($json["message"])->toBeString("Logged Out");
    });
});
