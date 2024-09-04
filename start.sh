#!/bin/bash

php artisan serve &
SERVER_PID=$!
php artisan queue:work
wait $SERVER_PID
