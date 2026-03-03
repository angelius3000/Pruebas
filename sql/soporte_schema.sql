-- Schema for Soporte ticket system

CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('solicitante','tecnico','admin') NOT NULL DEFAULT 'solicitante',
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS categories (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS assets (
    id INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(100) NOT NULL,
    etiqueta_activo VARCHAR(100) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    serie VARCHAR(100) DEFAULT NULL,
    hostname VARCHAR(255) DEFAULT NULL,
    ubicacion VARCHAR(255) DEFAULT NULL,
    notas TEXT DEFAULT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tickets (
    id INT NOT NULL AUTO_INCREMENT,
    folio VARCHAR(30) NOT NULL UNIQUE,
    asunto VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    categoria_id INT NOT NULL,
    asset_id INT DEFAULT NULL,
    impacto ENUM('Bajo','Medio','Alto') NOT NULL DEFAULT 'Medio',
    urgencia ENUM('Baja','Media','Alta') NOT NULL DEFAULT 'Media',
    prioridad_calculada ENUM('P1','P2','P3','P4') NOT NULL DEFAULT 'P4',
    prioridad_override ENUM('P1','P2','P3','P4') DEFAULT NULL,
    estado ENUM('Nuevo','Asignado','En proceso','En espera de usuario','En espera de tercero','Resuelto','Cerrado','Cancelado','Duplicado') NOT NULL DEFAULT 'Nuevo',
    solicitante_id INT NOT NULL,
    tecnico_id INT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    closed_at TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    INDEX idx_ticket_folio(folio),
    FOREIGN KEY (categoria_id) REFERENCES categories(id),
    FOREIGN KEY (asset_id) REFERENCES assets(id),
    FOREIGN KEY (solicitante_id) REFERENCES users(id),
    FOREIGN KEY (tecnico_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ticket_messages (
    id INT NOT NULL AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    author_id INT NOT NULL,
    body TEXT NOT NULL,
    is_internal TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS ticket_attachments (
    id INT NOT NULL AUTO_INCREMENT,
    ticket_id INT NOT NULL,
    message_id INT DEFAULT NULL,
    filename VARCHAR(255) NOT NULL,
    stored_path VARCHAR(500) NOT NULL,
    mime VARCHAR(100) NOT NULL,
    size INT NOT NULL,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (message_id) REFERENCES ticket_messages(id),
    FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS audit_log (
    id INT NOT NULL AUTO_INCREMENT,
    entity VARCHAR(100) NOT NULL,
    entity_id INT NOT NULL,
    action VARCHAR(50) NOT NULL,
    before_json TEXT DEFAULT NULL,
    after_json TEXT DEFAULT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- seed some categories and assets
INSERT IGNORE INTO categories (id,nombre,activo) VALUES
 (1,'Hardware',1),(2,'Software',1),(3,'Red',1);

INSERT IGNORE INTO assets (id,tipo,etiqueta_activo,marca,modelo) VALUES
 (1,'PC','PC-001','Dell','Optiplex 7070'),
 (2,'Switch','SW-01','Cisco','Catalyst 2960');

-- helper table for folio counter
CREATE TABLE IF NOT EXISTS ticket_folio_counter (
    year INT NOT NULL,
    counter INT NOT NULL,
    PRIMARY KEY (year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
