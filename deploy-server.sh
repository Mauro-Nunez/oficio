#!/bin/bash
set -e

echo "🚀 Starting deployment for oficiosgarupa.com.ar on server"

# Check if traefik network exists
if ! docker network ls | grep -q traefik-network; then
    echo "Creating traefik-network..."
    docker network create traefik-network
fi

# Create production .env if it doesn't exist
if [ ! -f .env.prod ]; then
    echo "📝 Creating production .env file..."
    cat > .env.prod << 'EOF'
APP_ENV=prod
APP_DEBUG=0
DATABASE_URL="mysql://gustavo:prod_password_12345678@oficio_mysql_prod:3306/gustavo?serverVersion=8.0"
MAILER_DSN="smtp://registrodeoficios.ar@gmail.com:pljywrotbeifctza@smtp.gmail.com:587"
EOF
fi

# Copy .env.prod to .env for the build
cp .env.prod .env

# Stop existing containers
echo "📦 Stopping existing containers..."
docker-compose -f docker-compose.prod.yaml down || true

# Build without cache
echo "🔨 Building application locally..."
DOCKER_BUILDKIT=0 docker-compose -f docker-compose.prod.yaml build --no-cache

echo "🎯 Starting containers..."
docker-compose -f docker-compose.prod.yaml up -d

# Wait for services
echo "⏳ Waiting for services to be ready..."
sleep 15

# Run migrations
echo "🗄️  Running database migrations..."
docker exec oficio_php_prod php bin/console doctrine:migrations:migrate --no-interaction --env=prod || echo "Migrations might already be up to date"

# Clear cache
echo "🧹 Clearing cache..."
docker exec oficio_php_prod php bin/console cache:clear --env=prod
docker exec oficio_php_prod php bin/console cache:warmup --env=prod

# Set permissions
echo "🔒 Setting permissions..."
docker exec oficio_php_prod chmod -R 777 var/ || true

# Check status
echo "📊 Checking container status..."
docker-compose -f docker-compose.prod.yaml ps

# Start Traefik if not running
echo "🚀 Starting Traefik..."
cd traefik && docker-compose -f docker-compose.traefik.yaml up -d || echo "Traefik might already be running"
cd ..

echo "✅ Deployment complete!"
echo "🌐 Application should be accessible at: https://oficiosgarupa.com.ar"
echo ""
echo "📌 Important: Make sure your DNS A records point to this server's IP"