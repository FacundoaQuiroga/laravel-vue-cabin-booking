# Cabin Reservation Platform

Small cabin reservation system built with Laravel and Vue.

## About

This project is a simple admin panel for managing cabins and reservations.

The backend is built with Laravel and exposes a REST API. The frontend is built with Vue 3 and uses Pinia to manage state.

I added basic admin authentication, cabin management, reservation validation and feature tests for the main rules of the system.

## Stack

Laravel 13, PHP 8.3, Vue 3, Pinia, Element Plus, MySQL, Docker, Laravel Sanctum and PHPUnit.

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net)
[![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?style=flat&logo=vuedotjs&logoColor=white)](https://vuejs.org)
[![Pinia](https://img.shields.io/badge/Pinia-FFD859?style=flat&logo=vuedotjs&logoColor=black)](https://pinia.vuejs.org)
[![Element Plus](https://img.shields.io/badge/Element%20Plus-409EFF?style=flat&logo=element&logoColor=white)](https://element-plus.org)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)](https://www.docker.com)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-366488?style=flat&logo=php&logoColor=white)](https://phpunit.de)

## Main Features

Cabin CRUD, reservation CRUD, admin login, protected admin routes, reservation filters, dashboard counters, and validations for overlapping dates, cabin capacity and unavailable cabins.

## Project Structure

backend: Laravel API  
frontend: Vue app  
docker: Docker files  
docker-compose.yml: Local services

## Tests

Run all tests:

docker compose exec php php artisan test

Run reservation tests:

docker compose exec php php artisan test --filter=ReservationValidationTest

Run cabin tests:

docker compose exec php php artisan test --filter=CabinApiTest
