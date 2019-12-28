<?php

namespace Tests\Feature\CRUD;

use App\Models\Book;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

abstract class BaseCRUD extends TestCase
{
    use DatabaseTransactions;

    protected $modelName;
    /** @var Model $model*/
    protected $model;
    protected $tableName;
    protected $userToken;

    public function setUp(): void
    {
        parent::setUp();

        factory($this->modelName, 5)->create();
        $this->model = new $this->modelName;
        $this->tableName = $this->model->getTable();

        $user = factory(User::class)->create(['email' => 'test@test.com']);
        $token = $user->createToken(config('app.name'));
        $token->token->expires_at = Carbon::now()->addDay();
        $token->token->save();
        $this->userToken = $token->accessToken;
    }

    public function testGet()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        $this->json('get', '/api/'.$this->tableName, [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'status_code'
            ]);
    }

    public function testGetInvalidPath()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        $this->json('get', '/api/'.$this->tableName.'dskifdsfsdfs', [], $headers)
            ->assertStatus(404);
    }

    public function testGetUnauthenticated()
    {
        $this->json('get', '/api/'.$this->tableName)
            ->assertStatus(401);
    }

    public function testCreateUnauthenticated()
    {
        $someData = ['key' => 'value'];
        $this->json('post', '/api/'.$this->tableName, $someData)
            ->assertStatus(401);
    }

    public function testDeleteUnauthenticated()
    {
        $this->json('delete', '/api/'.$this->tableName.'/1')
            ->assertStatus(401);
    }

    abstract public function testCreate();
}
