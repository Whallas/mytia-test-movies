# Mytia Test Movies

## About the Project

Mytia Test Movies is a Laravel-based web application designed to manage movies, reviews, and user interactions. It leverages Laravel's robust ecosystem to provide a scalable and maintainable architecture.

## Getting Started

### Prerequisites

Ensure you have the following installed:

- Docker and Docker Compose
- Git

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Whallas/mytia-test-movies.git
   cd mytia-test-movies
   ```

2. Copy the `.env.example` file to `.env` and configure the environment variables:
   ```bash
   cp .env.example .env
   ```
   **Note:** 
   - Ensure you set the `OMDB_API_KEY` variable in the `.env` file with a valid API key from OMDB.
   - If port 80 is unavailable on your system, you can change the `APP_PORT` variable in the `.env` file to a different port (e.g., `8080`).
<br><br>
3. Build and start the Docker containers:
   ```bash
   docker-compose up --build
   ```

4. Use Sail to run your commands (optional):
    ```bash
    ./vendor/bin/sail
    ```
    If you choose to use Sail, prepend `./vendor/bin/sail` to all artisan commands. For example:
    ```bash
    ./vendor/bin/sail artisan db:seed
    ```

5. Seed the database:
   ```bash
   docker exec -it -u sail mytia-test-movies-app php artisan db:seed
   ```

6. Sync movies data with OMDB (run this command only the first time):
   ```bash
   docker exec -it -u sail mytia-test-movies-app php artisan movies:sync-omdb
   ```
    - Valuable logs are shown in the `storage/logs` directory. You can check these files to monitor the command's behavior.
<br><br>
7. Access the application at [http://localhost](http://localhost).

### Viewing Emails with Mailpit

The application uses [Mailpit](https://github.com/axllent/mailpit) for local email testing. To view the invitation email:

1. Ensure the Docker containers are running.
2. Open your browser and navigate to [http://localhost:8025](http://localhost:8025).
3. Locate the invitation email in the Mailpit interface.

You can click the email to view its content, including the invitation link.

## Architecture Overview

The project follows a modular architecture with the following components:

- **Controllers**: Handle HTTP requests and responses.
- **Models**: Represent the application's data and business logic.
- **Views**: Blade templates for rendering the user interface.
- **Services**: Encapsulate business logic for better reusability.
- **API Documentation**: Swagger is used to document the API endpoints.

This architecture ensures separation of concerns, making the application easier to maintain and scale.

## Running Tests

To execute the tests, follow these steps:

1. Ensure the Docker containers are running.
2. Access the application container:
   ```bash
   docker exec -it -u sail mytia-test-movies-app bash
   ```
3. Run the tests using PHPUnit:
   ```bash
   php artisan test
   ```

Test results will be displayed in the terminal.

## API Documentation

The API is documented using Swagger. Access the documentation at [http://localhost/api/documentation](http://localhost/api/documentation) after starting the application.

