<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Requests\Api\Auth\RegisterFormRequest;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Http\Request;

class ApiRegisterControllerTest extends TestCase
{

    public function testRegisterUser()
    {
        $request = new class extends RegisterFormRequest {

            public $password = 123456;
            public $name = 'test';
            public $email = 'test@test.ru';

            public function only($aa)
            {
                return [
                    'name' => 'test',
                    'email' => 'test@test.ru'
                ];
            }
        };

        $controller = new RegisterController();

        $response = $controller($request);

        $code = $response->getStatusCode();

        $this->assertTrue($code == 200);

        $user = DB::table('users')->where('name', '=', 'test')->first();

        $this->assertEquals($user->email, 'test@test.ru');
    }

    /**
     * @depends testRegisterUser
     */
    public function testLogin()
    {
        $request = new class extends Request {

            public $password = 123456;
            public $email = 'test@test.ru';

            public function only($aa)
            {
                return [
                    'email' => 'test@test.ru',
                    'password' => '123456'
                ];
            }
        };

        $controller = new LoginController();

        $response = $controller($request);

        print_r($response);

        $code = $response->getStatusCode();

        $this->assertTrue($code == 200);
    }
}
