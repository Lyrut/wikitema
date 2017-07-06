
CREATE DATABASE IF NOT EXISTS `wikitema`;


CREATE TABLE if not exists `wikitema`.`user` (
  `user_id` int(11) AUTO_INCREMENT NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_pseudo` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_token` binary(32),
  `user_date_created` date NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT 3,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE if not exists `wikitema`.`theme` (
  `theme_id` int(11) AUTO_INCREMENT NOT NULL,
  `theme_name` varchar(255) NOT NULL,
PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE if not exists `wikitema`.`article` (
  `article_id` int(11) AUTO_INCREMENT NOT NULL,
  `article_theme_id` varchar(255) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_text` longtext NOT NULL,
  `article_user_id` int(11) NOT NULL,
  `article_date_created` date NOT NULL,
PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `wikitema`.`commentaire` (
  `commentaire_id` int(11) AUTO_INCREMENT NOT NULL,
  `commentaire_article_id` int(11) NOT NULL,
  `commentaire_user_id` int(11) NOT NULL,
  `commentaire_text` longtext NOT NULL,
  `commentaire_date_created` date NOT NULL,
PRIMARY KEY (`commentaire_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE if not exists `wikitema`.`media` (
  `media_id` int(11) AUTO_INCREMENT NOT NULL,
  `media_name` varchar(255) NOT NULL,
  `media_description` varchar(255),
  `media_user_text` varchar(255),
  `media_lien` varchar(255),
  `media_article_id` int(11) NOT NULL,
PRIMARY KEY (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO wikitema.`user` (user_id, user_full_name, user_pseudo, user_password, user_email, user_token, user_date_created, user_role) VALUES 
(1, 'admin', 'admin', '$2y$10$2MHF6rakOluCwdj6N0lg8u2/pxh3w9EwbXm5TX6ejzzu3J5t21HK.', 'admin@hitema.com', NULL, '2017-07-05', 1),
(2, 'jdoe', 'jdoe', '$2y$10$9EIunEjtkDZweLw6RNO8I.1G3n0qwgDUATYN.fW.DZEkIAW7IELya', 'jondoe@hitema.com', NULL, '2017-07-06', 2),
(3, 'test', 'test', '$2y$10$O/jNWYavHxUOCFTM5Hf3J.1bNIAJEF7AcPVS1e1hepPEGJeSSTkcK', 'test@hitema.com', NULL, '2017-07-06', 3);

INSERT INTO wikitema.theme (theme_id, theme_name)
VALUES (1, 'haha');
INSERT INTO wikitema.theme (theme_id, theme_name)
VALUES (2, 'hehe');

INSERT INTO wikitema.article (article_id, article_theme_id, article_title, article_text, article_user_id, article_date_created)
VALUES (1, '1', 'test', 'test', 1, '2017-07-06');

INSERT INTO wikitema.commentaire (commentaire_id, commentaire_article_id, commentaire_user_id, commentaire_text, commentaire_date_created)
VALUES (1, '1', '1', 'test', '2017-07-07');
