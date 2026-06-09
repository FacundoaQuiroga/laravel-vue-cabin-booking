# Cabin Reservation Platform

Full-stack cabin reservation management system built with Laravel 13, Vue 3, MySQL and Docker.

## Overview

This project is a cabin booking management platform focused on creating, editing, filtering and managing reservations through a REST API and a Vue-based admin interface.

It includes reservation status management, date validation to prevent overlapping bookings, and a Dockerized local development environment.

## Tech Stack

- Backend: Laravel 13, PHP 8.3
- Frontend: Vue 3, Vite, Pinia, Element Plus
- Database: MySQL
- API: RESTful endpoints
- Dev environment: Docker, Nginx, Redis, Mailhog
- Tools: Git, Composer, npm

## Features

- Create, update and delete cabin reservations
- List reservations from a Laravel REST API
- Prevent overlapping reservations for the same cabin
- Manage reservation status: pending, confirmed and cancelled
- Filter reservations by guest name and status
- Reservation dashboard with status counters
- Dockerized development environment
- Environment variables handled through `.env.example`

## Project Structure

```text
backend/          Laravel API
frontend/         Vue 3 application
docker/           Docker configuration
docker-compose.yml