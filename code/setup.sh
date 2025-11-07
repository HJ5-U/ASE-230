#!/bin/bash

# Student_API Docker Setup Script
# This script helps you set up and run the Laravel application with Docker
# Can be run from any directory

set -e

# Get the directory where this script is located
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Define the Student_API directory
STUDENT_API_DIR="${SCRIPT_DIR}/Student_API"

# Check if Student_API directory exists
if [ ! -d "$STUDENT_API_DIR" ]; then
    echo "❌ Error: Student_API directory not found at: $STUDENT_API_DIR"
    exit 1
fi

echo "🐳 Student_API Docker Setup"
echo "================================"
echo "📂 Working directory: $STUDENT_API_DIR"
echo ""

# Function to display menu
show_menu() {
    echo ""
    echo "What would you like to do?"
    echo "1. Initial Setup (First time only)"
    echo "2. Start Containers"
    echo "3. Stop Containers"
    echo "4. Restart Containers"
    echo "5. View Logs"
    echo "6. Run Migrations"
    echo "7. Seed Database"
    echo "8. Access Application Shell"
    echo "9. Clear Cache"
    echo "10. Exit"
    echo ""
    read -p "Enter your choice [1-10]: " choice
}

# Initial setup
initial_setup() {
    echo "🚀 Running initial setup..."
    
    # Change to Student_API directory
    cd "$STUDENT_API_DIR" || exit 1
    
    # Copy .env file if it doesn't exist
    if [ ! -f .env ]; then
        echo "📝 Creating .env file..."
        cp .env.example .env
    fi
    
    # Update .env for Docker
    echo "⚙️ Configuring environment for Docker..."
    sed -i 's/DB_HOST=.*/DB_HOST=mysql/' .env
    sed -i 's/DB_DATABASE=.*/DB_DATABASE=student_api/' .env
    sed -i 's/DB_USERNAME=.*/DB_USERNAME=student_user/' .env
    sed -i 's/DB_PASSWORD=.*/DB_PASSWORD=P@ssword123/' .env
    
    # Build and start containers
    echo "🏗️ Building Docker containers..."
    docker-compose build
    
    echo "🚀 Starting containers..."
    docker-compose up -d
    
    # Wait for MySQL to be ready
    echo "⏳ Waiting for MySQL to be ready..."
    sleep 10
    
    # Generate application key
    echo "🔑 Generating application key..."
    docker-compose exec app php artisan key:generate
    
    # Set permissions
    echo "🔒 Setting permissions..."
    docker-compose exec app chown -R www-data:www-data /var/www/html/storage
    docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
    
    # Run migrations
    echo "🗄️ Running database migrations..."
    docker-compose exec app php artisan migrate --force
    
    # Seed database
    echo "🌱 Seeding database..."
    docker-compose exec app php artisan db:seed --force
    
    echo ""
    echo "✅ Setup complete!"
    echo "📍 Application: http://localhost:8080"
    echo "📍 phpMyAdmin: http://localhost:8081"
    echo ""
}

# Start containers
start_containers() {
    echo "🚀 Starting containers..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose up -d
    echo "✅ Containers started!"
    echo "📍 Application: http://localhost:8080"
    echo "📍 phpMyAdmin: http://localhost:8081"
}

# Stop containers
stop_containers() {
    echo "🛑 Stopping containers..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose down
    echo "✅ Containers stopped!"
}

# Restart containers
restart_containers() {
    echo "🔄 Restarting containers..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose restart
    echo "✅ Containers restarted!"
}

# View logs
view_logs() {
    echo "📋 Viewing logs (Ctrl+C to exit)..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose logs -f
}

# Run migrations
run_migrations() {
    echo "🗄️ Running migrations..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose exec app php artisan migrate --force
    echo "✅ Migrations complete!"
}

# Seed database
seed_database() {
    echo "🌱 Seeding database..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose exec app php artisan db:seed --force
    echo "✅ Database seeded!"
}

# Access shell
access_shell() {
    echo "🐚 Accessing application shell..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose exec app bash
}

# Clear cache
clear_cache() {
    echo "🧹 Clearing cache..."
    cd "$STUDENT_API_DIR" || exit 1
    docker-compose exec app php artisan cache:clear
    docker-compose exec app php artisan config:clear
    docker-compose exec app php artisan route:clear
    docker-compose exec app php artisan view:clear
    echo "✅ Cache cleared!"
}

# Main loop
while true; do
    show_menu
    
    case $choice in
        1)
            initial_setup
            ;;
        2)
            start_containers
            ;;
        3)
            stop_containers
            ;;
        4)
            restart_containers
            ;;
        5)
            view_logs
            ;;
        6)
            run_migrations
            ;;
        7)
            seed_database
            ;;
        8)
            access_shell
            ;;
        9)
            clear_cache
            ;;
        10)
            echo "👋 Goodbye!"
            exit 0
            ;;
        *)
            echo "❌ Invalid option. Please try again."
            ;;
    esac
done
