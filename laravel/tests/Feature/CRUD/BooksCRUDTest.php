<?php

namespace Tests\Feature\CRUD;

use App\Models\Book;

class BooksCRUDTest extends BaseCRUD
{
    protected $modelName = Book::class;

    public function testCreate()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        $bookData = [
            'name'=> 'Name from test',
            'year_of_writing' => '2000',
            'number_of_pages' => '99'
        ];

        $this->json('post', '/api/'.$this->tableName, $bookData, $headers)
            ->assertStatus(201)
            ->assertExactJson([
                'message' => 'Successfully added',
                'status_code' => 201
            ]);
    }

    public function testCreateInvalidData()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        $bookData = [
            'name'=> 'Name from test',
            'year_of_writing' => '20000000',
            'number_of_pages' => '-99'
        ];

        $this->json('post', '/api/'.$this->tableName, $bookData, $headers)
            ->assertStatus(422);
    }

    public function testSort()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        // обычный запрос
        $response = $this->json('get', '/api/'.$this->tableName, [], $headers)
            ->assertStatus(200)->decodeResponseJson();

        // отсортированный
        $sortByYearResponse = $this->json('get', '/api/'.$this->tableName.'?sort=year', [], $headers)
            ->assertStatus(200)->decodeResponseJson();

        // по убыванию
        $sortByYearDescResponse = $this->json('get', '/api/'.$this->tableName.'?sort=-year', [], $headers)
            ->assertStatus(200)->decodeResponseJson();

        // сравниваем, что получили разные
        $this->assertNotEquals($sortByYearResponse, $response);
        $this->assertNotEquals($sortByYearDescResponse, $response);

        // получаем массив из годов, из запроса отсортированных
        $sortedYears = array_map(function ($item) {
            return $item['year_of_writing'];
        }, $sortByYearResponse['message']);

        // из запроса по убыванию
        $sortedDescYears = array_map(function ($item) {
            return $item['year_of_writing'];
        }, $sortByYearDescResponse['message']);

        // из обычного
        $sortedInTestYears = array_map(function ($item) {
            return $item['year_of_writing'];
        }, $response['message']);

        // сортируем обычние и справниваем с отсортированными из запроса
        sort($sortedInTestYears);
        $this->assertEquals($sortedInTestYears, $sortedYears);

        // сортируем обычние по убыванию и справниваем с отсортированными по убыванию из запроса
        rsort($sortedInTestYears);
        $this->assertEquals($sortedInTestYears, $sortedDescYears);
    }

    public function testGetLimit()
    {
        $headers = ['Authorization' => "Bearer $this->userToken"];

        for ($i=1; $i<=3; $i++) {
            $response = $this->json('get', '/api/'.$this->tableName.'?limit='.$i, [], $headers)
                ->assertStatus(200)->decodeResponseJson();
            $this->assertEquals($i, count($response['message']));
        }
    }
}
