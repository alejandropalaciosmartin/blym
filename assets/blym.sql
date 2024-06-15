CREATE DATABASE blym;

USE blym;

-- TABLA USUARIOS
CREATE TABLE users (
  user_id INT NOT NULL AUTO_INCREMENT,
  user_handle VARCHAR(25) NOT NULL UNIQUE,
  email_address VARCHAR(50) NOT NULL UNIQUE,
  first_name VARCHAR(25) NOT NULL,
  profile_img VARCHAR(255),
  follower_count INT NOT NULL DEFAULT 0,
  active INT NOT NULL DEFAULT 0,
  password VARCHAR(10) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id)
);

-- TABLA SEGUIDORES
CREATE TABLE followers (
    follower_id INT NOT NULL,
    following_id INT NOT NULL,
    FOREIGN KEY (follower_id) REFERENCES users(user_id),
    FOREIGN KEY (following_id) REFERENCES users(user_id),
    PRIMARY KEY (follower_id, following_id)
);

-- TABLA POSTS
CREATE TABLE posts (
    post_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    post_text VARCHAR(300) NOT NULL,
    post_img VARCHAR(255),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    PRIMARY KEY (post_id)
);

-- TABLA STORIES
CREATE TABLE stories (
    story_id INT AUTO_INCREMENT PRIMARY KEY,
    src VARCHAR(255) NOT NULL,
    user_id INT NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- TABLA SUPPORT
CREATE TABLE support (
    support_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- TABLA LIKES
CREATE TABLE likes (
    like_id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id),
    PRIMARY KEY (like_id)
);

-- EVENTO PARA ELIMINAR STORIES DESPUÉS DE 24 HORAS
DELIMITER //
CREATE EVENT delete_old_stories
    ON SCHEDULE EVERY 1 HOUR
    DO
      DELETE FROM stories WHERE created_at <= NOW() - INTERVAL 24 HOUR;
//
DELIMITER ;

-- TRIGGERS
DELIMITER //
CREATE TRIGGER increase_follower_count
    AFTER INSERT ON followers
    FOR EACH ROW
    BEGIN
        UPDATE users
        SET follower_count = follower_count + 1
        WHERE user_id = NEW.following_id;
    END //
DELIMITER ;





-- INSERTAR DATOS DE PRUEBA

INSERT INTO users (user_handle, email_address, first_name, password)
VALUES ('paco', 'paca@gmail.com', 'Alex', '1234'),
        ('blym', 'papab@gmail.com', 'Blym', '1234'),
        ('carlos', 'papac@gmail.com', 'Carlos', '1234'),
        ('daniel', 'papad@gmail.com', 'Daniel',  '1234'),
        ('eduardo', 'papae@gmail.com', 'Eduardo',  '1234'),
        ('alexpalacios', 'srjalean@gmail.com', 'Alejandro',  '1234'),
        ('fernando', 'papaf@gmail.com', 'Fernando', '1234');


INSERT INTO support (user_id, message) VALUES 
    (1, 'No puedo iniciar sesión en mi cuenta.'),
    (2, 'Mi pedido no ha llegado.'),
    (3, '¿Este producto tiene garantía?'),
    (4, 'Deseo cancelar mi subscripción.'),
    (5, 'He recibido un artículo incorrecto.'),
    (6, '¿Cómo puedo cambiar mi dirección de envío?'),
    (7, 'Necesito actualizar mi información de pago.'),
    (8, 'El producto llegó dañado.'),
    (9, 'Quisiera cambiar mi correo electrónico asociado.'),
    (10, '¿Cuándo estará disponible este producto nuevamente?');