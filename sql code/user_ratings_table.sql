CREATE TABLE  `movieCol`.`user_ratings` (
`userid` VARCHAR( 128 ) NOT NULL ,
`imdbid` VARCHAR( 128 ) NOT NULL ,
`rating` ENUM(  '-1',  '0',  '1' ) NOT NULL ,
`datetime` DATETIME NOT NULL ,
UNIQUE person_movie (`userid`,`imdbid`)
) ENGINE = MYISAM ;