# Робота з масивами (3 підзадачі)

**Файл для змін:** `Task.php`  
**Запуск:** `make run-t1`

### Дані доступні через приватні методи
- `getUsers()` => `[['id'=>1,'name'=>'...','city_id'=>...], ...]`
- `getCities()` => `[['id'=>1,'name'=>'Lutsk'], ...]`

## Підзадача A — `getUserNamesMap()`
Повернути мапу `id => name`.  
**Приклад:**
```php
[
  1 => 'Robert De Niro',
  2 => 'Leonardo DiCaprio',
  3 => 'Tom Hanks',
  4 => 'Angelina Jolie',
]
```

## Підзадача B — `getUsersInfo()`
Для кожного юзера додати city (назва міста). Якщо міста немає у довіднику — порожній рядок.
**Приклад:**
```php
[
  ['id' => 1, 'name' => 'Robert De Niro', 'city' => 'Lutsk'],
  ['id' => 2, 'name' => 'Leonardo DiCaprio', 'city' => 'Donetsk'],
  ['id' => 3, 'name' => 'Tom Hanks', 'city' => 'Lutsk'],
  ['id' => 4, 'name' => 'Angelina Jolie', 'city' => ''],
]
```

## Підзадача C — `getPopulation()`
Порахувати кількість користувачів у кожному місті (включно з містами, де 0).
**Приклад:**
```php
[
  'Lutsk' => 2,
  'Donetsk' => 1,
  'Kyiv' => 0,
]
```