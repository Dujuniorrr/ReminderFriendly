
CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    humor VARCHAR(50) NOT NULL,
    role VARCHAR(50) NOT NULL,
    ageVitality VARCHAR(50) NOT NULL,
    origin VARCHAR(50) NOT NULL,
    speechMannerisms VARCHAR(100) NOT NULL,
    accent VARCHAR(50) NOT NULL,
    archetype VARCHAR(50) NOT NULL,
    imagePath VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    originalMessage TEXT NOT NULL,
    processedMessage TEXT NOT NULL,
    date DATE NOT NULL,
    characterId INT NOT NULL,
    `send` BOOLEAN DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (characterId) REFERENCES characters(id)
);


INSERT INTO characters (name, humor, role, ageVitality, origin, speechMannerisms, accent, archetype, imagePath)
VALUES
    ('Sherlock Holmes', 'Witty', 'Detective', 'Energetic', 'London', 'Analytical', 'British', 'Investigator', 'sherlock.jpg'),
    ('Hermione Granger', 'Intelligent', 'Student', 'Curious', 'Hogwarts', 'Articulate', 'British', 'Bookworm', 'hermione.jpg'),
    ('James Bond', 'Suave', 'Secret Agent', 'Adventurous', 'MI6', 'Confident', 'British', 'Spy', 'jamesbond.jpg');
