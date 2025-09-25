#!/bin/bash
set -e

echo "🚀 Starting local deployment for oficiosgarupa.com.ar"

# Check if traefik network exists
if ! docker network ls | grep -q traefik-network; then
    echo "Creating traefik-network..."
    docker network create traefik-network
fi

# Stop existing containers
echo "📦 Stopping existing containers..."
docker-compose -f docker-compose.prod.yaml down || true

# Build without pulling from Docker Hub
echo "🔨 Building application locally..."
DOCKER_BUILDKIT=0 docker-compose -f docker-compose.prod.yaml build --no-cache

echo "🎯 Starting containers..."
docker-compose -f docker-compose.prod.yaml up -d

# Wait for services
echo "⏳ Waiting for services to be ready..."
sleep 10

# Check status
echo "📊 Checking container status..."
docker-compose -f docker-compose.prod.yaml ps

echo "✅ Deployment complete!"
echo "🌐 Application should be accessible at: http://oficiosgarupa.com.ar"