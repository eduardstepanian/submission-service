# SubmissionAPI

## Setup

1. Clone the repository https://github.com/eduardstepanian/submission-service.
2. Run `composer install`.
3. Set up your `.env` file or copy from .env.example
4. Run `php artisan migrate`.
5. Run `./start.sh`
6. Run `php artisan test` for unittests

## Testing

You can test the API by sending a POST request to `/v1/submissions` with the following JSON payload:

```json
{
    "name": "John Smith",
    "email": "john.Smith@example.com",
    "message": "This is a test message."
}
