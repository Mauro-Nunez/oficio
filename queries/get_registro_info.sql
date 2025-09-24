-- Query para obtener información de registros sin repetir oficios por DNI
-- Solo incluye registros con fecha de creación

-- PostgreSQL Version
-- Usa DISTINCT ON para evitar duplicados de DNI + oficio
SELECT DISTINCT ON (r.dni, o.id)
    r.name AS nombre_persona,
    r.phone AS telefono,
    r.email AS correo,
    -- Nota: El campo 'date' parece ser fecha de registro, no fecha de nacimiento
    -- Si existe un campo de fecha de nacimiento, reemplazar r.date por ese campo
    EXTRACT(YEAR FROM AGE(CURRENT_DATE, r.date)) AS edad,
    o.name AS nombre_oficio,
    r.description AS descripcion,
    r.created_at AS fecha_creacion
FROM 
    registro r
INNER JOIN 
    oficio o ON r.oficio_id = o.id
WHERE 
    r.created_at IS NOT NULL
    AND r.status = true
    AND o.status = true
ORDER BY 
    r.dni, 
    o.id, 
    r.created_at DESC;

-- MySQL/MariaDB Version
-- Usa subconsulta para evitar duplicados de DNI + oficio
SELECT 
    r.name AS nombre_persona,
    r.phone AS telefono,
    r.email AS correo,
    -- Nota: El campo 'date' parece ser fecha de registro, no fecha de nacimiento
    -- Si existe un campo de fecha de nacimiento, reemplazar r.date por ese campo
    YEAR(CURDATE()) - YEAR(r.date) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(r.date, '%m%d')) AS edad,
    o.name AS nombre_oficio,
    r.description AS descripcion,
    r.created_at AS fecha_creacion
FROM 
    registro r
INNER JOIN 
    oficio o ON r.oficio_id = o.id
WHERE 
    r.created_at IS NOT NULL
    AND r.status = 1
    AND o.status = 1
    AND r.id IN (
        SELECT MIN(r2.id)
        FROM registro r2
        WHERE r2.created_at IS NOT NULL
        GROUP BY r2.dni, r2.oficio_id
    )
ORDER BY 
    r.dni, 
    o.name;