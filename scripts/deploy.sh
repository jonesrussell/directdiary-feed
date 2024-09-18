#!/bin/bash

# Error handling wrapper
function run_with_error_handling {
  command="$1"
  echo "Running: $command"
  eval "$command" || {
    echo "Error occurred: $?" >&2
    # Log the error details and notify someone
    exit 1
  }
}

# Navigation
run_with_error_handling "cd $PROJECT_DIR"

# Load environment variables
source $PROJECT_DIR/.env

# Maintenance mode
run_with_error_handling "php artisan down || true"

# Code updates
run_with_error_handling "git pull"

# Dependencies & assets
run_with_error_handling "composer install --no-dev --optimize-autoloader"
run_with_error_handling "npm ci"
run_with_error_handling "npm run build"

# Database migrations
run_with_error_handling "php artisan migrate --force"

# Clearing all caches
run_with_error_handling "php artisan cache:clear"
run_with_error_handling "php artisan route:clear"
run_with_error_handling "php artisan config:clear"
run_with_error_handling "php artisan view:clear"

# Caching
run_with_error_handling "php artisan optimize"

# Queue worker (optional)
if [[ "$ENABLE_QUEUE_WORKER" == "true" ]]; then
  run_with_error_handling "sudo supervisorctl restart your-worker-name"
fi

# Take out of maintenance mode
run_with_error_handling "php artisan up"

echo "Deployment successful!"
