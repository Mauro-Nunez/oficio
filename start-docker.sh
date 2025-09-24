#!/bin/bash

echo "🚀 Iniciando proyecto Symfony con Docker..."

# Limpiar contenedores anteriores
echo "📦 Limpiando contenedores anteriores..."
docker compose down

# Limpiar cache si existe
if [ -d "var/cache" ]; then
    echo "🧹 Limpiando cache..."
    rm -rf var/cache/*
fi

# Construir y levantar contenedores
echo "🏗️  Construyendo contenedores..."
docker compose up -d --build

# Esperar a que MySQL esté listo
echo "⏳ Esperando a que MySQL esté listo..."
until docker exec oficio_mysql mysqladmin ping -h localhost -u gustavo -p12345678 --silent; do
    echo "   MySQL no está listo todavía, esperando..."
    sleep 5
done
echo "✅ MySQL está listo!"

# Ejecutar migraciones
echo "📊 Ejecutando migraciones de base de datos..."
docker exec oficio_php php bin/console doctrine:migrations:migrate --no-interaction

# Limpiar cache de Symfony
echo "🧹 Limpiando cache de Symfony..."
docker exec oficio_php php bin/console cache:clear

echo "✅ ¡Proyecto iniciado!"
echo "🌐 Accede a http://localhost:8082"
echo "📧 Mailpit UI: http://localhost:$(docker port oficio-1-mailer-1 8025 | cut -d: -f2)"
echo "🗄️  MySQL: localhost:3307 (usuario: gustavo, contraseña: 12345678)"