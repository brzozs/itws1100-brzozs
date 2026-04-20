CREATE TABLE `movies` (
   `movieid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(100) NOT NULL,
   `year` char(4) DEFAULT NULL,
   PRIMARY KEY (`movieid`)
);

CREATE TABLE `actors` (
   `actorid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `last_name` varchar(40) NOT NULL,
   `first_names` varchar(80) NOT NULL,
   `dob` date NOT NULL,
   PRIMARY KEY (`actorid`)
);

CREATE TABLE `movie_actors` (
   `movieid` int(10) unsigned NOT NULL,
   `actorid` int(10) unsigned NOT NULL,
   PRIMARY KEY (`movieid`, `actorid`)
);

INSERT INTO movies
VALUES (1, "Elizabeth", "1998"),
   (2, "Black Widow", "2021"),
   (3, "Oh Brother Where Art Thou?", "2000"),
   (
      4,
      "The Lord of the Rings: The Fellowship of the Ring",
      "2001"
   ),
   (5, "Up in the Air", "2009");

INSERT INTO actors (`actorid`, `last_name`, `first_names`, `dob`)
VALUES (1, "Blanchett", "Cate", "1969-05-14"),
   (2, "Johansson", "Scarlett", "1984-11-22"),
   (3, "Clooney", "George", "1968-05-06"),
   (4, "Wood", "Elijah", "1981-01-28"),
   (5, "Nelson", "Tim Blake", "1970-05-11"),
   (6, "Turturro", "John", "1957-02-28"),
   (7, "Hunter", "Holly", "1958-03-20"),
   (8, "McDormand", "Frances", "1957-06-23"),
   (9, "Downey Jr", "Robert", "1965-04-04");

INSERT INTO movie_actors (`movieid`, `actorid`)
VALUES (1, 1),
   (2, 2),
   (2, 9),
   (3, 3),
   (3, 5),
   (3, 6),
   (3, 7),
   (4, 4),
   (5, 3),
   (5, 8);