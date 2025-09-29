# PHP Interview Tasks

## Правила
- Працюйте тільки у файлах `tasks/**/Task.php` (якщо не зазначено інакше).
- Запускай через відповідний run.php.
- Час на одне live-завдання: 10–15 хв (орієнтир).
- Пишіть чистий, читабельний код, уникайте global state, пояснюйте рішення короткими коментарями.
- Можна додавати допоміжні функції/класи в межах файлу завдання.
- Заборонено тягнути зовнішні пакети/фреймворки.

## Оцінювання (загальне)
- Коректність результату (працює як у прикладі/вимогах).
- Читабельність і структура (SRP, іменування, відсутність дублів).
- Уважність до краєвих випадків.
- Для архітектурних задач — дотримання DIP/OCP


## Як запустити (Docker)

### Запуск через Makefile
- Побудова образу
    - `make build`
- Запуск 1-го завдання
    - `make run-t1`
- Запуск 2-го завдання
    - `make run-t2`
- Запуск 3-го завдання
    - `make run-t3`
- Запуск 4-го завдання
    - `make run-t4`

### Запуск без Makefile
- Побудова образу
    - `docker build -t interview-php ./docker/images/php`
    - `docker compose build`
- Запуск 1-го завдання
    - `docker run --rm -it -v "$PWD/src":/app -w /app interview-php php tasks/01-arrays/run.php`
    - `docker compose run --rm app tasks/01-arrays/run.php`
- Запуск 2-го завдання
    - `docker run --rm -it -v "$PWD/src":/app -w /app interview-php php tasks/02-order/run.php`
    - `docker compose run --rm app tasks/02-order/run.php`
- Запуск 3-го завдання
    - `docker run --rm -it -v "$PWD/src":/app -w /app interview-php php tasks/03-invoice/run.php`
    - `docker compose run --rm app tasks/03-invoice/run.php`
- Запуск 4-го завдання
    - `docker run --rm -it -v "$PWD/src":/app -w /app interview-php php tasks/04-events/run.php`
    - `docker compose run --rm app tasks/04-events/run.php`

> Примітка для Windows: якщо \${PWD} не спрацьовує, заміни \${PWD} на повний шлях, напр. D:\path\to\repo.
> Вимкнути автоконвертацію шляхів: MSYS_NO_PATHCONV=1 MSYS2_ARG_CONV_EXCL='*' docker run -ti -v "/d/path-to/interview/src:/app" -w /app interview-php bash
