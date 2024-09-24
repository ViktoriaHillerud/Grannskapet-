CREATE DATABASE IF NOT EXISTS grannskapet;
USE grannskapet;

-- users
CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT, 
    userName VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL, 
    adress VARCHAR(255) NOT NULL DEFAULT '', 
	role INT NOT NULL DEFAULT 1,
    PRIMARY KEY (id)
);

-- grannskapsgrupper
CREATE TABLE IF NOT EXISTS neighbourgroups (
    id INT NOT NULL AUTO_INCREMENT,
    NName VARCHAR(50) NOT NULL,
    place VARCHAR(50) NOT NULL,
    descr VARCHAR(255),
    PRIMARY KEY (id)
);

-- Pivot table för relationen mellan users och neighbourgroups (many-to-many)
CREATE TABLE IF NOT EXISTS user_neighbourgroup (
    user_id INT NOT NULL,
    group_id INT NOT NULL,
    PRIMARY KEY (user_id, group_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES neighbourgroups(id) ON DELETE CASCADE
);

-- Meddelanden (one-to-many relation till users)
CREATE TABLE IF NOT EXISTS messages (
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    time DATETIME NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Pivot table för relationen mellan messages och neighbourgroups (many-to-many)
CREATE TABLE IF NOT EXISTS message_neighbourgroup (
    message_id INT NOT NULL,
    group_id INT NOT NULL,
    PRIMARY KEY (message_id, group_id),
    FOREIGN KEY (message_id) REFERENCES messages(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES neighbourgroups(id) ON DELETE CASCADE
);

-- Evenemang
CREATE TABLE IF NOT EXISTS events (
    id INT NOT NULL AUTO_INCREMENT,
    EventName VARCHAR(50) NOT NULL,
    time DATETIME NOT NULL,
    place VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Pivot table för relationen mellan events och neighbourgroups (many-to-many)
CREATE TABLE IF NOT EXISTS event_neighbourgroup (
    event_id INT NOT NULL,
    group_id INT NOT NULL,
    PRIMARY KEY (event_id, group_id),
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES neighbourgroups(id) ON DELETE CASCADE
);

-- Pivot table för relationen mellan users och events (many-to-many)
CREATE TABLE IF NOT EXISTS user_events (
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    PRIMARY KEY (user_id, event_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Incidenter (one-to-many relation till users)
CREATE TABLE IF NOT EXISTS incidents (
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(50) NOT NULL,
    descr TEXT NOT NULL,
    time DATETIME NOT NULL,
    place VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Pivot table för relationen mellan incidents och neighbourgroups (many-to-many)
CREATE TABLE IF NOT EXISTS incident_neighbourgroup (
    incident_id INT NOT NULL,
    group_id INT NOT NULL,
    PRIMARY KEY (incident_id, group_id),
    FOREIGN KEY (incident_id) REFERENCES incidents(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES neighbourgroups(id) ON DELETE CASCADE
);
