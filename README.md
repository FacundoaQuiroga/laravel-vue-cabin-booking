# Cabin Reservation Platform

Small cabin reservation system built with Laravel and Vue.

## About

This project is a simple admin panel for managing cabins and reservations.

The backend is built with Laravel and exposes a REST API. The frontend is built with Vue 3 and uses Pinia to manage state.

I added basic admin authentication, cabin management, reservation validation and feature tests for the main rules of the system.

## Stack

Laravel 13, PHP 8.3, Vue 3, Pinia, Element Plus, MySQL, Docker, Laravel Sanctum and PHPUnit.

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
