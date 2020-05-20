CREATE TABLE IF NOT EXISTS `chat_rooms` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
)

CREATE TABLE IF NOT EXISTS `chat_users` (
  `id` tinyint(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
);


CREATE TABLE IF NOT EXISTS `join_room` (
  `user_name` varchar(100) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `last_time` timestamp not null CURRENT_TIME,
  PRIMARY KEY ('user_id','room_id')
);


CREATE TABLE IF NOT EXISTS `chat_record` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `text`,varchar(300) NOT NULL ,
  PRIMARY KEY ('id')
);

