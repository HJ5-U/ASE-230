#!/bin/bash

# Laravel Student API Setup Script - Sets up Project2Laravel as student-api
# - Creates MySQL database and user
# - Copies all Project2Laravel content
# - Configures .env with correct DB credentials
# - Runs migrations and seeds
# - Starts the Laravel development server

# Always operate from the script's directory
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

SOURCE_DIR="Student_API"
TARGET_DIR="student-api"
DB_NAME="student_api"
DB_USER="student_user"
DB_PASSWORD="P@ssword123"

echo "🚀 Setting up Student API from Student_API..."

# -------------------------------------------------
# 1️⃣ MySQL Database Setup
# -------------------------------------------------
echo "🗄️ Creating MySQL database and user..."

MYSQL="mysql"

# Try sudo mysql first (auth_socket), fall back to password prompt
if sudo $MYSQL -e "SELECT 1;" >/dev/null 2>&1; then
    echo "  ↳ Using sudo mysql..."
    sudo $MYSQL <<EOF
DROP DATABASE IF EXISTS $DB_NAME;
CREATE DATABASE $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED WITH mysql_native_password BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF
else
    # Prompt for root password if sudo doesn't work
    if [ -z "$MYSQL_ROOT_PASSWORD" ]; then
        read -s -p "Enter MySQL root password: " MYSQL_ROOT_PASSWORD
        echo
    fi
    
    MYSQL_CNF=$(mktemp)
    chmod 600 "$MYSQL_CNF"
    cat > "$MYSQL_CNF" <<EOF
[client]
user=root
password=$MYSQL_ROOT_PASSWORD
EOF
    
    if ! $MYSQL --defaults-file="$MYSQL_CNF" -e "SELECT 1;" >/dev/null 2>&1; then
        echo "❌ Cannot connect to MySQL. Aborting."
        rm -f "$MYSQL_CNF"
        exit 1
    fi
    
    $MYSQL --defaults-file="$MYSQL_CNF" <<EOF
DROP DATABASE IF EXISTS $DB_NAME;
CREATE DATABASE $DB_NAME;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED WITH mysql_native_password BY '$DB_PASSWORD';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF
    rm -f "$MYSQL_CNF"
fi

# Verify app user can connect
if ! $MYSQL -u "$DB_USER" -p"$DB_PASSWORD" -e "SELECT 1" "$DB_NAME" >/dev/null 2>&1; then
    echo "❌ Database user verification failed."
    exit 1
fi
echo "✅ Database '$DB_NAME' and user '$DB_USER' configured."

# -------------------------------------------------
# 2️⃣ Create Laravel Project Directory
# -------------------------------------------------
if [ ! -d "$TARGET_DIR" ]; then
    echo "📁 Creating $TARGET_DIR directory..."
    mkdir -p "$TARGET_DIR"
    
    # Copy Laravel starter files
    if [ -d "$SOURCE_DIR" ]; then
        echo "📋 Copying Project2Laravel structure..."
        cp -r "$SOURCE_DIR"/* "$TARGET_DIR"/ 2>/dev/null || true
        cp -r "$SOURCE_DIR"/.[!.]* "$TARGET_DIR"/ 2>/dev/null || true
    fi
else
    echo "📁 Directory $TARGET_DIR already exists, updating files..."
    if [ -d "$SOURCE_DIR" ]; then
        cp -r "$SOURCE_DIR"/* "$TARGET_DIR"/ 2>/dev/null || true
    fi
fi

cd "$TARGET_DIR" || exit

# -------------------------------------------------
# 3️⃣ Configure .env
# -------------------------------------------------
echo "⚙️ Configuring environment..."

if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
    else
        # Create minimal .env
        cat > .env <<ENVEOF
APP_NAME="Student API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=$DB_NAME
DB_USERNAME=$DB_USER
DB_PASSWORD=$DB_PASSWORD

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
ENVEOF
    fi
fi

# Update DB credentials in .env
upsert_env() {
    local key="$1"
    local value="$2"
    if grep -q "^${key}=" .env 2>/dev/null; then
        sed -i "s#^${key}=.*#${key}=${value}#" .env
    else
        echo "${key}=${value}" >> .env
    fi
}

upsert_env "DB_CONNECTION" "mysql"
upsert_env "DB_HOST" "127.0.0.1"
upsert_env "DB_PORT" "3306"
upsert_env "DB_DATABASE" "$DB_NAME"
upsert_env "DB_USERNAME" "$DB_USER"
upsert_env "DB_PASSWORD" "$DB_PASSWORD"
upsert_env "CACHE_STORE" "file"
upsert_env "SESSION_DRIVER" "file"
upsert_env "QUEUE_CONNECTION" "sync"

echo "✅ Environment configured."

# -------------------------------------------------
# 4️⃣ Install Dependencies
# -------------------------------------------------
echo "📦 Installing dependencies..."

if [ -f "composer.json" ]; then
    composer install --no-interaction --optimize-autoloader
else
    echo "⚠️ No composer.json found, skipping PHP dependencies"
fi

if [ ! -f ".env" ] || ! grep -q "APP_KEY=base64:" .env; then
    php artisan key:generate --force 2>/dev/null || true
fi

if [ -f "package.json" ]; then
    npm install
    npm run build 2>/dev/null || true
fi

# -------------------------------------------------
# 5️⃣ Database Migrations and Seeding
# -------------------------------------------------
echo "🗄️ Setting up database..."

php artisan config:clear
php artisan migrate:fresh --seed --force

echo "✅ Database migrated and seeded."

# -------------------------------------------------
# 6️⃣ Start Development Server
# -------------------------------------------------
echo ""
echo "✅ Setup complete!"
echo ""
echo "🔐 Database Credentials:"
echo "  Database: $DB_NAME"
echo "  Username: $DB_USER"
echo "  Password: $DB_PASSWORD"
echo ""
echo "🌐 Starting Laravel development server..."
echo "  Access at: http://localhost:8000"
echo ""
echo "  Press Ctrl+C to stop the server"
echo ""

# Start server (use --host=0.0.0.0 for WSL2)
if grep -qi microsoft /proc/version 2>/dev/null; then
    php artisan serve --host=0.0.0.0
else
    php artisan serve
fi
