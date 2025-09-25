#!/bin/bash

echo "🔐 Docker Hub Authentication Setup"
echo ""
echo "Docker Hub now requires authentication to pull images."
echo "Please login to Docker Hub:"
echo ""

# Login to Docker Hub
sudo docker login

# Pull required images
echo ""
echo "📦 Pulling required Docker images..."
sudo docker pull php:8.2-fpm
sudo docker pull nginx:alpine
sudo docker pull mysql:8.0

echo ""
echo "✅ Docker images pulled successfully!"
echo "You can now run ./deploy.sh"