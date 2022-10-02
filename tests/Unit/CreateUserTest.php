<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\Models\User;

class CreateUserTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function test_create_user_and_get_name()
    {
        $this->user->factory()->create([
            'name' => 'John Doe',
            'email' => 'asdfsdf@asdasd.com',
            'password' => '123456789'
        ]);

        $allUsers = $this->user->all();

        $this->assertCount(1, $allUsers);
        $this->assertEquals('John Doe', $allUsers[0]->name);
    }
}
