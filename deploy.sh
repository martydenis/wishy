#!/bin/bash

SSH_HOST="wishy"
APP_PATH="/var/www/wishy"

echo "Connecting to the server..."

ssh $SSH_HOST << EOF

# Navigate to the app directory
cd $APP_PATH

# Install/update Composer dependencies
composer install --no-interaction --no-dev --prefer-dist

# Pull from git repository
git pull origin main

# Run database migration
php artisan migrate

# Clean up cache
php artisan optimize:clear

# restart Apache
sudo systemctl restart apache2

EOF

echo "Deployment completed."

read -p "Press Enter to exit..."