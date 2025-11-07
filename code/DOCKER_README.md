# Docker Setup for Project2Laravel

This guide will help you containerize and run the Project2Laravel application using Docker.

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **Docker**: [Install Docker](https://docs.docker.com/get-docker/)
- **Docker Compose**: [Install Docker Compose](https://docs.docker.com/compose/install/)

## 🚀 Quick Start

### Option 1: Using the Setup Script (Recommended)

1. **Navigate to the project directory:**
   ```bash
   cd /home/hj5u/projects/Project2/project2/code/Project2Laravel
   ```

2. **Run the setup script:**
   ```bash
   ./docker-setup.sh
   ```

3. **Choose option 1 (Initial Setup)** from the menu

4. **Access the application:**
   - Application: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

### Option 2: Manual Setup

1. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Update .env file for Docker:**
   ```bash
   DB_HOST=mysql
   DB_DATABASE=student_api
   DB_USERNAME=student_user
   DB_PASSWORD=P@ssword123
   ```

3. **Build and start containers:**
   ```bash
   docker-compose build
   docker-compose up -d
   ```

4. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

5. **Run migrations and seed database:**
   ```bash
   docker-compose exec app php artisan migrate --force
   docker-compose exec app php artisan db:seed --force
   ```

6. **Set permissions:**
   ```bash
   docker-compose exec app chown -R www-data:www-data /var/www/html/storage
   docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
   ```

## 🐳 Docker Services

The Docker setup includes three services:

### 1. **Laravel Application (app)**
- **Container**: project2_laravel_app
- **Port**: 8080
- **Access**: http://localhost:8080
- **Technology**: PHP 8.3 with Apache

### 2. **MySQL Database (mysql)**
- **Container**: project2_mysql
- **Port**: 3307 (host) → 3306 (container)
- **Database**: student_api
- **Username**: student_user
- **Password**: P@ssword123
- **Root Password**: rootpassword

### 3. **phpMyAdmin (phpmyadmin)**
- **Container**: project2_phpmyadmin
- **Port**: 8081
- **Access**: http://localhost:8081
- **Login**: Use MySQL credentials above

## 📝 Common Commands

### Container Management

```bash
# Start all containers
docker-compose up -d

# Stop all containers
docker-compose down

# Restart containers
docker-compose restart

# View running containers
docker-compose ps

# View logs
docker-compose logs -f

# View logs for specific service
docker-compose logs -f app
```

### Laravel Commands

```bash
# Run artisan commands
docker-compose exec app php artisan [command]

# Examples:
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan route:list

# Access container shell
docker-compose exec app bash

# Run composer commands
docker-compose exec app composer install
docker-compose exec app composer update
```

### Database Commands

```bash
# Access MySQL CLI
docker-compose exec mysql mysql -u student_user -pP@ssword123 student_api

# Create database backup
docker-compose exec mysql mysqldump -u root -prootpassword student_api > backup.sql

# Restore database backup
docker-compose exec -T mysql mysql -u root -prootpassword student_api < backup.sql
```

### NPM Commands

```bash
# Install NPM dependencies
docker-compose exec app npm install

# Build assets
docker-compose exec app npm run build

# Watch for changes (development)
docker-compose exec app npm run dev
```

## 🔧 Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="Student Database"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=student_api
DB_USERNAME=student_user
DB_PASSWORD=P@ssword123
```

### Port Conflicts

If ports 8080, 8081, or 3307 are already in use, modify `docker-compose.yml`:

```yaml
services:
  app:
    ports:
      - "9000:80"  # Change 8080 to 9000
  
  phpmyadmin:
    ports:
      - "9001:80"  # Change 8081 to 9001
  
  mysql:
    ports:
      - "3308:3306"  # Change 3307 to 3308
```

## 🛠️ Troubleshooting

### Container Won't Start

```bash
# Check container status
docker-compose ps

# View error logs
docker-compose logs

# Rebuild containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

### Permission Issues

```bash
# Fix storage permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 775 /var/www/html/storage

# Fix cache permissions
docker-compose exec app chown -R www-data:www-data /var/www/html/bootstrap/cache
docker-compose exec app chmod -R 775 /var/www/html/bootstrap/cache
```

### Database Connection Issues

```bash
# Check MySQL is running
docker-compose ps mysql

# Test database connection
docker-compose exec mysql mysql -u student_user -pP@ssword123 -e "SELECT 1"

# Restart MySQL
docker-compose restart mysql
```

### Clear All Caches

```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
docker-compose exec app composer dump-autoload
```

## 🔄 Development Workflow

### 1. Make Code Changes
Edit files in your local directory - changes are automatically reflected in the container.

### 2. Run Migrations
```bash
docker-compose exec app php artisan migrate
```

### 3. Clear Caches
```bash
docker-compose exec app php artisan cache:clear
```

### 4. Rebuild Assets
```bash
docker-compose exec app npm run build
```

### 5. View Changes
Visit http://localhost:8080 to see your changes.

## 📦 Production Deployment

For production deployment:

1. **Update .env:**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://yourdomain.com
   ```

2. **Optimize Laravel:**
   ```bash
   docker-compose exec app php artisan config:cache
   docker-compose exec app php artisan route:cache
   docker-compose exec app php artisan view:cache
   docker-compose exec app composer install --optimize-autoloader --no-dev
   ```

3. **Use production-ready database** (not included in docker-compose)

4. **Enable HTTPS** with a reverse proxy (nginx, Traefik, etc.)

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Docker Documentation](https://docs.docker.com)
- [Docker Compose Documentation](https://docs.docker.com/compose)

## 🤝 Support

If you encounter issues:

1. Check the logs: `docker-compose logs`
2. Verify containers are running: `docker-compose ps`
3. Restart containers: `docker-compose restart`
4. Rebuild if necessary: `docker-compose build --no-cache`

## 📄 License

This project is part of Project2Laravel student database management system.
