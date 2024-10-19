# Laravel SB Admin 2

SB Admin 2 for Laravel.

| Laravel Version | Branch | Support     |
|-----------------|--------|-------------|
| 11.0            | main   |             |
| 10.0            | v10.0  |             |
| 9.0             | v9.0   | End of life |
| 8.0             | v8.0   | End of life |

## Requirements

- PHP >= 8.2
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- Filter PHP Extension
- Hash PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Session PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

- Clone the repo and `cd` into it
- Run `composer update`
- Rename or copy `.env.example` file to `.env`
- Run `php artisan key:generate`
- Set your database credentials in your `.env` file
- migration table`php artisan migrate --seed`