CREATE TABLE role (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL,
    privileges VARCHAR(255),
    description TEXT
);

CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    points INT DEFAULT 0,
    status ENUM('active', 'banned', 'inactive') DEFAULT 'active',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    latest_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

CREATE TABLE friend_list (
    user_id_1 INT,
    user_id_2 INT,
    status ENUM('friends','not-friends','blocked') DEFAULT 'not-friends',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id_1, user_id_2),
    FOREIGN KEY (user_id_1) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id_2) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE thread (
    thread_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE thread_bridge (
    user_id INT,
    thread_id INT,
    joined_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, thread_id),
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES thread(thread_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE post (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    thread_id INT,
    contents LONGBLOB,
    likes INT DEFAULT 0,
    caption VARCHAR(255),
    visibility ENUM('public', 'friends', 'private') DEFAULT 'public',
    is_deleted BOOLEAN DEFAULT FALSE,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    latest_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES thread(thread_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    contents VARCHAR(500),
    is_deleted BOOLEAN DEFAULT FALSE,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (post_id) REFERENCES post(post_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE chat (
    chat_id INT AUTO_INCREMENT PRIMARY KEY,
    chat_type VARCHAR(50),
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    last_message_at DATETIME
);

CREATE TABLE chat_bridge (
    chat_id INT,
    user_id INT,
    joined_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    role ENUM('member', 'admin') DEFAULT 'member',
    PRIMARY KEY (chat_id, user_id),
    FOREIGN KEY (chat_id) REFERENCES chat(chat_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE message (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT,
    user_id INT NOT NULL,
    chat_id INT,
    content VARCHAR(1000),
    is_deleted BOOLEAN DEFAULT FALSE,
    is_edited BOOLEAN DEFAULT FALSE,
    sent_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (chat_id) REFERENCES chat(chat_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (thread_id) REFERENCES thread(thread_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE game (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255),
    points INT DEFAULT 0,
    time_limit INT,
    difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    latest_update DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE game_bridge (
    game_id INT,
    user_id INT,
    score INT DEFAULT 0,
    completed_on DATETIME,
    PRIMARY KEY (game_id, user_id),
    FOREIGN KEY (game_id) REFERENCES game(game_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(user_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
