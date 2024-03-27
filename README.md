<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Cruddy by Design
I designed this API following the "Cruddy by Design" principle explained in "Cruddy by Design" - Adam Wathan - Laracon US 2017 talk.
. This principle is a design pattern that encourages organizing Laravel controllers around the standard REST/CRUD actions. By adhering to this convention, controllers remain focused and maintainable, preventing them from becoming bloated with too many responsibilities.
The "Cruddy by Design" principle encourages organizing Laravel controllers around the standard REST/CRUD actions:

* Index
* Show
* Create
* Store
* Edit
* Update
* Destroy

By adhering to this convention, controllers remain focused and maintainable, preventing them from becoming bloated with too many responsibilities.


## What can be added
* Search functionality
* Pagination
* Sorting
* Filtering

These features could be added by creating Traits that can be used in the controllers. This way, the controllers remain focused on their primary responsibilities, and the Traits can be reused across multiple models.

Also I opted out of using Repository pattern because it is not necessary in this case. The Eloquent ORM is already a pattern and i think using them both is anti-pattern and it is not necessary.



## Installation

1. Clone the repository
2. Run `composer install`
3. Copy the `.env.example` file to `.env`
4. Create a new database and add the database credentials to the `.env` file
5. Run `php artisan migrate --seed`
6. Run `php artisan serve`
7. Visit `http://localhost:8000` in your browser
8. Or for swagger documentation visit `http://localhost:8000/api/documentation`

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

 
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
