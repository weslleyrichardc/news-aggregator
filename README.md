# News Aggregator API

A Laravel API that aggregates news from multiple news sources and provides endpoints for a frontend application to
consume.

## Requirements

- PHP >= 8.3
- Node >= 21
- Composer
- NPM

## Setup

Copy `.env.example` to `.env` and update the values.

Run `php artisan key:generate` to generate a new application key.

Run `php artisan migrate:fresh --seed` to create the database tables and seed the database.

Run `npm run build` to build the frontend assets.

Run `composer run dev` to start the development server.

Open [http://localhost:8000](http://localhost:8000) to view the application.

## Features

- [ ] User authentication using Laravel Sanctum
    - [X] Register
    - [X] Login
    - [X] Logout
    - [ ] Password reset
- [ ] Article management from multiple sources
    - [X] Listing with pagination
    - [ ] Filtering by category, keyword, source, and date
    - [X] Article details
- [ ] User preferences
    - [ ] Prefered sources, categories, and authors
- [ ] Data Aggregation
    - [ ] Scheduled fetching of articles from multiple sources
        - [X] News APIs
        - [ ] The Guardian
        - [ ] The New York Times
- [X] API Documentation
    - [X] Swagger/OpenAPI

## Testing

```bash
php artisan test
```

# Swagger

Open http://localhost:8000/swagger while in development environment.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT).
