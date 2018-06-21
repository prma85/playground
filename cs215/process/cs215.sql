CREATE TABLE `users` (
  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `posts` (
  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `text` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(12) NOT NULL,

   FOREIGN KEY fk_user(user_id)
   REFERENCES users(id)
   ON UPDATE CASCADE
   ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `comments` (
  `id` int(12) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `text` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(12) NOT NULL,
  `post_id` int(12) NOT NULL,

   FOREIGN KEY fk_user(user_id)
   REFERENCES users(id)
   ON UPDATE CASCADE
   ON DELETE RESTRICT,

   FOREIGN KEY fk_post(post_id)
   REFERENCES posts(id)
   ON UPDATE CASCADE
   ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `favorites` (
  `user_id` int(12) NOT NULL,
  `post_id` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`post_id`),
  ADD KEY `fk_post_fav` (`post_id`),
  ADD KEY `fk_user_fav` (`user_id`);

ALTER TABLE `favorites`
  ADD CONSTRAINT `fk_post_fav` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_fav` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
