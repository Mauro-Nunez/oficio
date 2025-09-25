#!/bin/bash
echo "🚀 Iniciando MySQL de prueba..."

# Detener si existe
docker compose -f docker-compose.mysql-test.yaml down

# Iniciar
docker compose -f docker-compose.mysql-test.yaml up -d

# Esperar a que esté listo
echo "⏳ Esperando que MySQL esté listo..."
sleep 10

# Verificar estado
echo "📊 Estado del contenedor:"
docker ps | grep mysql_test

# Ver logs
echo "📋 Logs de MySQL:"
docker logs mysql_test --tail 10

# Probar conexión local
echo "🔧 Probando conexión local:"
docker exec mysql_test mysql -u testuser -ptestpass123 -e "SELECT 'Conexión exitosa!' as resultado;"

# Probar conexión desde fuera
echo "🔧 Probando conexión desde el host:"
mysql -h 127.0.0.1 -P 3308 -u testuser -ptestpass123 -e "SELECT 'Conexión desde host exitosa!' as resultado;" 2>/dev/null || echo "Cliente MySQL no instalado en el host"