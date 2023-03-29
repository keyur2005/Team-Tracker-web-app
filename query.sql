CREATE TABLE `crickets` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar (100) NOT NULL,
  `position` varchar (100) NOT NULL,
  `phone_num` varchar (100) NOT NULL,
  `email` varchar (100) NOT NULL,
  `team_name` varchar (100) NOT NULL,
  `profile_image` varchar(100) NOT NULL
  PRIMARY KEY (user_id)
);
