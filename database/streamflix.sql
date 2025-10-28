-- Database schema voor StreamFlix

-- Tabel voor gebruikers
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('member','admin') DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel voor categorieën
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Tabel voor films
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    video_url VARCHAR(255),        -- url naar mp4 of embed link
    category_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Tabel voor waarderingen
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT,
    rating DECIMAL(2,1),           -- Gemiddelde rating bijv. 8.5
    votes INT DEFAULT 0,
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);

-- Dummy data

-- Test users (password is 'password' for testuser, 'admin123' for admin)
INSERT INTO users (username, email, password, role) VALUES 
('testuser', 'test@streamflix.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member'),
('admin', 'admin@streamflix.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('demo_user', 'demo@streamflix.nl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member');

INSERT INTO categories (name) VALUES 
('Action'), 
('Comedy'), 
('Drama'), 
('Horror'), 
('Sci-Fi'), 
('Romance'), 
('Thriller'), 
('Documentary'), 
('Animation'), 
('Crime');

INSERT INTO movies (title, description, image, video_url, category_id) VALUES
-- Existing movies with online images
('Inception', 'A thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.', 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg', 'assets/videos/inception.mp4', 1),
('The Hangover', 'Three buddies wake up from a bachelor party in Las Vegas, with no memory of the previous night and the bachelor missing.', 'https://image.tmdb.org/t/p/w500/cs36xSvuVKBW8qz1qjbVe9yRNxf.jpg', 'assets/videos/hangover.mp4', 2),
('The Shawshank Redemption', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg', 'assets/videos/shawshank.mp4', 3),

-- Action Movies
('John Wick', 'An ex-hit-man comes out of retirement to track down the gangsters that took everything from him.', 'https://image.tmdb.org/t/p/w500/fZPSd91yGE9fCcCe6OoQr6E3Bev.jpg', 'assets/videos/placeholder.mp4', 1),
('Mad Max: Fury Road', 'In a post-apocalyptic wasteland, a woman rebels against a tyrannical ruler in search for her homeland.', 'https://image.tmdb.org/t/p/w500/hA2ple9q4qnwxp3hKVNhroipsir.jpg', 'assets/videos/placeholder.mp4', 1),
('The Dark Knight', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests.', 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg', 'assets/videos/placeholder.mp4', 1),
('Avengers: Endgame', 'After the devastating events of Infinity War, the Avengers assemble once more to reverse Thanos'' actions and restore balance to the universe.', 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg', 'assets/videos/placeholder.mp4', 1),
('Gladiator', 'A former Roman General sets out to exact vengeance against the corrupt emperor who murdered his family and sent him into slavery.', 'https://image.tmdb.org/t/p/w500/ty8TGRuvJLPUmAR1H1nRIsgwvim.jpg', 'assets/videos/placeholder.mp4', 1),

-- Comedy Movies
('Superbad', 'Two co-dependent high school seniors are forced to deal with separation anxiety after their plan to stage a booze-soaked party goes awry.', 'https://image.tmdb.org/t/p/w500/ek8e8txUyUwd2BNqj6lFEerJfbq.jpg', 'assets/videos/placeholder.mp4', 2),
('Anchorman', 'Ron Burgundy is San Diego''s top-rated newsman in the male-dominated broadcasting of the 1970s, but that''s all about to change when a new female employee arrives.', 'https://image.tmdb.org/t/p/w500/7LAk3Kd0nHJdH8VrhECIlfut1eb.jpg', 'assets/videos/placeholder.mp4', 2),
('Step Brothers', 'Two aimless middle-aged losers still living at home are forced against their will to become roommates when their parents marry.', 'https://image.tmdb.org/t/p/w500/wRR62XfbHbDvKOq4YydMr28HLpJ.jpg', 'assets/videos/placeholder.mp4', 2),
('Tropic Thunder', 'A group of self-absorbed actors set out to make the most expensive war film ever, only to find themselves in a real jungle fighting actual bad guys.', 'https://image.tmdb.org/t/p/w500/zAurB9mNxfYRoVrVjAJJwGV3ePG.jpg', 'assets/videos/placeholder.mp4', 2),
('Zoolander', 'At the end of his career, a clueless fashion model is brainwashed to kill the Prime Minister of Malaysia.', 'https://image.tmdb.org/t/p/w500/qdrbSneHZjJG2Dj0hhBxzzAo4HB.jpg', 'assets/videos/placeholder.mp4', 2),

-- Drama Movies
('The Godfather', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg', 'assets/videos/placeholder.mp4', 3),
('Forrest Gump', 'The presidencies of Kennedy and Johnson, Vietnam, Watergate, and other history unfold through the perspective of an Alabama man.', 'https://image.tmdb.org/t/p/w500/arw2vcBveWOVZr6pxd9XTd1TdQa.jpg', 'assets/videos/placeholder.mp4', 3),
('Pulp Fiction', 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.', 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg', 'assets/videos/placeholder.mp4', 3),
('Schindler''s List', 'In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce.', 'https://image.tmdb.org/t/p/w500/sF1U4EUQS8YHUYjNl3pMGNIQyr0.jpg', 'assets/videos/placeholder.mp4', 3),
('12 Years a Slave', 'In the antebellum United States, Solomon Northup, a free black man from upstate New York, is abducted and sold into slavery.', 'https://image.tmdb.org/t/p/w500/xdANQijuNrJaw1HA61rDccME4Tm.jpg', 'assets/videos/placeholder.mp4', 3),

-- Horror Movies
('Get Out', 'A young African-American visits his white girlfriend''s parents for the weekend, where his simmering uneasiness becomes a nightmare.', 'https://image.tmdb.org/t/p/w500/tFXcEccSQMf3lfhfXKSU9iRBma3.jpg', 'assets/videos/placeholder.mp4', 4),
('A Quiet Place', 'A family is forced to live in silence while hiding from creatures that hunt by sound.', 'https://image.tmdb.org/t/p/w500/nAU74GmpUk7t5iklEp3bufwDq4n.jpg', 'assets/videos/placeholder.mp4', 4),
('Hereditary', 'A grieving family is haunted by tragedy and disturbing secrets in this psychological horror film.', 'https://image.tmdb.org/t/p/w500/p81a0FyNE0Se4dTxi5CwXYcPGKh.jpg', 'assets/videos/placeholder.mp4', 4),
('The Conjuring', 'Paranormal investigators Ed and Lorraine Warren work to help a family terrorized by a dark presence in their farmhouse.', 'https://image.tmdb.org/t/p/w500/wVYREutTvI2tmxr6ujrHT704wGF.jpg', 'assets/videos/placeholder.mp4', 4),

-- Sci-Fi Movies
('Blade Runner 2049', 'Young Blade Runner K''s discovery of a long-buried secret leads him to track down former Blade Runner Rick Deckard.', 'https://image.tmdb.org/t/p/w500/gajva2L0rPYkEWjzgFlBXCAVBE5.jpg', 'assets/videos/placeholder.mp4', 5),
('The Matrix', 'A computer programmer is led to fight an underground war against powerful computers who have constructed his entire reality with a system called the Matrix.', 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg', 'assets/videos/placeholder.mp4', 5),
('Interstellar', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity''s survival.', 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg', 'assets/videos/placeholder.mp4', 5),
('Dune', 'A noble family becomes embroiled in a war for control over the galaxy''s most valuable asset while its heir becomes troubled by visions of a dark future.', 'https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg', 'assets/videos/placeholder.mp4', 5),

-- Romance Movies
('The Notebook', 'A poor yet passionate young man falls in love with a rich young woman, giving her a sense of freedom, but they are soon separated.', 'https://image.tmdb.org/t/p/w500/qom1SZSENdmHFNZBXbtJAU0WTlC.jpg', 'assets/videos/placeholder.mp4', 6),
('Titanic', 'A seventeen-year-old aristocrat falls in love with a kind but poor artist aboard the luxurious, ill-fated R.M.S. Titanic.', 'https://image.tmdb.org/t/p/w500/9xjZS2rlVxm8SFx8kPC3aIGCOYQ.jpg', 'assets/videos/placeholder.mp4', 6),
('La La Land', 'While navigating their careers in Los Angeles, a pianist and an actress fall in love while attempting to reconcile their aspirations for the future.', 'https://image.tmdb.org/t/p/w500/uDO8zWDhfWwoFdKS4fzkUJt0Rf0.jpg', 'assets/videos/placeholder.mp4', 6),

-- Thriller Movies
('Gone Girl', 'With his wife''s disappearance having become the focus of an intense media circus, a man sees the spotlight turned on him.', 'https://image.tmdb.org/t/p/w500/gdiLTof3rbPDAmPaCf4g6op46bj.jpg', 'assets/videos/placeholder.mp4', 7),
('Se7en', 'Two detectives, a rookie and a veteran, hunt a serial killer who uses the seven deadly sins as his motives.', 'https://image.tmdb.org/t/p/w500/69Sns8WoET6CfaYlIkHbla4l7nC.jpg', 'assets/videos/placeholder.mp4', 7),
('Shutter Island', 'In 1954, a U.S. Marshal investigates the disappearance of a murderer who escaped from a hospital for the criminally insane.', 'https://image.tmdb.org/t/p/w500/4GDy0PHYX3VRXUtwK5ysFbg3kEx.jpg', 'assets/videos/placeholder.mp4', 7),

-- Animation Movies
('Toy Story', 'A cowboy doll is profoundly threatened and jealous when a new spaceman figure supplants him as top toy in a boy''s room.', 'https://image.tmdb.org/t/p/w500/uXDfjJbdP4ijW5hWSBrPrlKpxab.jpg', 'assets/videos/placeholder.mp4', 9),
('Finding Nemo', 'After his son is captured in the Great Barrier Reef and taken to Sydney, a timid clownfish sets out on a journey to bring him home.', 'https://image.tmdb.org/t/p/w500/eHuGQ10FUzK1mdOY69wF5pGgEf5.jpg', 'assets/videos/placeholder.mp4', 9),
('The Lion King', 'A Lion prince is cast out of his pride by his cruel uncle, who claims he killed his father so that he can become the new king.', 'https://image.tmdb.org/t/p/w500/sKCr78MXSLixwmZ8DyJLrpMsd15.jpg', 'assets/videos/placeholder.mp4', 9),
('Spider-Man: Into the Spider-Verse', 'Teen Miles Morales becomes the Spider-Man of his universe, and must join with five spider-powered individuals from other dimensions.', 'https://image.tmdb.org/t/p/w500/iiZZdoQBEYBv6id8su7ImL0oCbD.jpg', 'assets/videos/placeholder.mp4', 9),

-- Crime Movies
('Goodfellas', 'The story of Henry Hill and his life in the mob, covering his relationship with his wife Karen Hill and his mob partners.', 'https://image.tmdb.org/t/p/w500/aKuFiU82s5ISJpGZp7YkIr3kCUd.jpg', 'assets/videos/placeholder.mp4', 10),
('The Departed', 'An undercover cop and a police informant play a cat and mouse game with each other as they attempt to find out the other''s identity.', 'https://image.tmdb.org/t/p/w500/nT97ifVT2J1yMQmeq20Qblg61T.jpg', 'assets/videos/placeholder.mp4', 10),
('Casino', 'A tale of greed, deception, money, power, and murder occur between two best friends and a trophy wife over a gambling empire.', 'https://image.tmdb.org/t/p/w500/4TS5O1vmaZVltvh4t8ZoWPAZfO8.jpg', 'assets/videos/placeholder.mp4', 10);

INSERT INTO ratings (movie_id, rating, votes) VALUES
-- Original movies
(1, 8.8, 2000),
(2, 7.7, 1500),
(3, 9.3, 3000),

-- Action ratings
(4, 7.4, 1800),
(5, 8.1, 2200),
(6, 9.0, 2800),
(7, 8.4, 3200),
(8, 8.5, 2100),

-- Comedy ratings
(9, 7.6, 1400),
(10, 7.2, 1300),
(11, 6.9, 1100),
(12, 7.0, 1200),
(13, 6.5, 900),

-- Drama ratings
(14, 9.2, 3500),
(15, 8.8, 3100),
(16, 8.9, 2900),
(17, 8.9, 2700),
(18, 8.1, 1900),

-- Horror ratings
(19, 7.7, 1600),
(20, 7.5, 1500),
(21, 7.3, 1200),
(22, 7.5, 1700),

-- Sci-Fi ratings
(23, 8.0, 2300),
(24, 8.7, 2800),
(25, 8.6, 2600),
(26, 8.0, 2100),

-- Romance ratings
(27, 7.8, 2000),
(28, 7.8, 2400),
(29, 8.0, 1800),

-- Thriller ratings
(30, 8.1, 2200),
(31, 8.6, 2500),
(32, 8.2, 1900),

-- Animation ratings
(33, 8.3, 2300),
(34, 8.2, 2100),
(35, 8.5, 2800),
(36, 8.4, 2000),

-- Crime ratings
(37, 8.7, 2600),
(38, 8.5, 2400),
(39, 8.2, 1800);
