#!/bin/bash

# Script to deploy the application with Traefik

echo "🚀 Starting deployment for oficiosgarupa.com.ar"

# Create traefik network if it doesn't exist
docker network create traefik-network 2>/dev/null || echo "Network traefik-network already exists"

# Create acme.json file for Let's Encrypt certificates
touch traefik/acme.json
chmod 600 traefik/acme.json

# Stop existing containers
echo "📦 Stopping existing containers..."
docker compose -f docker-compose.prod.yaml down

# Build the application
echo "🔨 Building application..."
docker compose -f docker-compose.prod.yaml build

# Copy .env file for production
if [ ! -f .env.prod ]; then
    echo "📝 Creating production .env file..."
    cp .env .env.prod
    sed -i 's/APP_ENV=dev/APP_ENV=prod/g' .env.prod
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' .env.prod
    echo "⚠️  Please update database credentials in .env.prod"
fi

# Start containers
echo "🎯 Starting containers..."
docker compose -f docker-compose.prod.yaml up -d

# Wait for PHP container to be ready
echo "⏳ Waiting for PHP container..."
sleep 10

# Run migrations
echo "🗄️  Running database migrations..."
docker exec oficio_php_prod php bin/console doctrine:migrations:migrate --no-interaction

# Run database seeds
echo "🌱 Seeding database with oficios..."
docker exec oficio_php_prod php bin/console doctrine:fixtures:load --no-interaction --env=prod

# Clear cache
echo "🧹 Clearing cache..."
docker exec oficio_php_prod php bin/console cache:clear --env=prod
docker exec oficio_php_prod php bin/console cache:warmup --env=prod

# Set permissions
echo "🔒 Setting permissions..."
docker exec oficio_php_prod chmod -R 777 var/

echo "✅ Deployment complete!"
echo "🌐 Your application should be available at https://oficiosgarupa.com.ar"
echo ""
echo "📌 Next steps:"
echo "1. Make sure your domain DNS A records point to this server's IP"
echo "2. Update the email in traefik/traefik.yml"
echo "3. Change Let's Encrypt to production mode in traefik/traefik.yml"
echo "4. Run the Traefik container separately: cd traefik && docker-compose -f docker-compose.traefik.yaml up -d"