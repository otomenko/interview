<?php

class Test
{
	/**
	 * Example:
	 *  [
	 *      1 => 'Robert De Niro',
	 *      2 => 'Leonardo DiCaprio',
	 *      3 => 'Tom Hanks',
	 *      4 => 'Angelina Jolie',
	 *  ]
	 *
	 * @return array[]
	 */
	public function getUserNamesMap(): array
	{
		return [];
	}

	/**
	 * Example:
	 *  [
	 *      ['id' => 1, 'name' => 'Robert De Niro', 'city' => 'Lutsk'],
	 *      ['id' => 2, 'name' => 'Leonardo DiCaprio', 'city' => 'Donetsk'],
	 *      ['id' => 3, 'name' => 'Tom Hanks', 'city' => 'Lutsk'],
	 *      ['id' => 4, 'name' => 'Angelina Jolie', 'city' => ''],
	 *  ]
	 *
	 * @return array[]
	 */
	public function getUsersInfo(): array
	{
		return [];
	}

	/**
	 * Example:
	 *  [
	 *      'Lutsk' => 2,
	 *      'Donetsk' => 1,
	 *      'Kyiv' => 0,
	 *  ]
	 *
	 * @return array[]
	 */
	public function getPopulation(): array
	{
		return [];
	}

	private function getUsers(): array
	{
		return [
			['id' => 1, 'name' => 'Robert De Niro', 'city_id' => 1],
			['id' => 2, 'name' => 'Leonardo DiCaprio', 'city_id' => 2],
			['id' => 3, 'name' => 'Tom Hanks', 'city_id' => 1],
			['id' => 4, 'name' => 'Angelina Jolie', 'city_id' => 3],
		];
	}

	private function getCities(): array
	{
		return [
			['id' => 1, 'name' => 'Lutsk'],
			['id' => 2, 'name' => 'Donetsk'],
			['id' => 4, 'name' => 'Kyiv'],
		];
	}
}

$test = new Test();

echo 'UserNamesMap:' . PHP_EOL;
var_dump($test->getUserNamesMap());

echo 'UsersInfo:' . PHP_EOL;
var_dump($test->getUsersInfo());

echo 'Population:' . PHP_EOL;
var_dump($test->getPopulation());
