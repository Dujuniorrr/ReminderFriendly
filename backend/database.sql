CREATE TABLE IF NOT EXISTS characters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    humor VARCHAR(50) NOT NULL,
    role VARCHAR(50) NOT NULL,
    ageVitality VARCHAR(50) NOT NULL,
    origin VARCHAR(50) NOT NULL,
    color VARCHAR(255) NOT NULL,
    speechMannerisms VARCHAR(100) NOT NULL,
    accent VARCHAR(50) NOT NULL,
    archetype VARCHAR(50) NOT NULL,
    imagePath VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    originalMessage TEXT NOT NULL,
    processedMessage TEXT NOT NULL,
    date DATETIME NOT NULL,
    characterId INT NOT NULL,
    `send` BOOLEAN DEFAULT 0,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (characterId) REFERENCES characters(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;;

INSERT INTO characters (name, humor, role, ageVitality, origin, speechMannerisms, accent, archetype, imagePath, color)
VALUES
    ( 
        'Spider-Main',
        'Intelligent',
        'Hero',
        'Young',
        'Marvel',
        'Articulate',
        'New York',
        'Funny Hero',
        'http://localhost:9000/storage/spiderman.png',
        'blue'
    ),
    (
        'Darth Vader',
        'Powerful',
        'Dark Lord of the Sith',
        'Former Jedi Knight turned Sith Lord', 
        'Galactic Empire', 
        'Intimidating',
        'Human', 
        'Dark Lord of the Sith', 
        'http://localhost:9000/storage/darthvader.jpeg',
        'black'
    ),
    (
        'Yoda',
        'Wise',
        'Jedi Master',
        'Ancient',
        'Dagobah',
        'Inverted syntax',
        'Galactic Standard',
        'Wise Mentor',
        'http://localhost:9000/storage/yoda.jpeg',
        'green'
    ),
    (
        'The Flash',
        'Fast',
        'Speedster Hero',
        'Young',
        'Central City',
        'Quick talker',
        'American',
        'Speedster',
        'http://localhost:9000/storage/flash.jpeg',
        'red'
    ),
    (
        'C-3PO',
        'Polite',
        'Protocol Droid',
        'Built in 112 BBY',
        'Tatooine',
        'Fluent in over six million forms of communication',
        'British',
        'Loyal Companion',
        'http://localhost:9000/storage/c3po.jpeg',
        'yellow'
    );
