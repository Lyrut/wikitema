--
-- Base de données :  `wikitema`
--

CREATE DATABASE IF NOT EXISTS `wikitema`;

--
-- Structure de la table `user`
--

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

-- --------------------------------------------------------


CREATE TABLE if not exists `wikitema`.`theme` (
  `theme_id` int(11) AUTO_INCREMENT NOT NULL,
  `theme_name` varchar(255) NOT NULL,
PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Structure de la table `article`
--

CREATE TABLE if not exists `wikitema`.`article` (
  `article_id` int(11) AUTO_INCREMENT NOT NULL,
  `article_theme_id` varchar(255) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_text` longtext NOT NULL,
  `article_commentaire` longtext,
  `article_user` int(11) NOT NULL,
  `article_date_created` date NOT NULL,
PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE if not exists `wikitema`.`media` (
  `media_id` int(11) AUTO_INCREMENT NOT NULL,
  `media_name` varchar(255) NOT NULL,
  `media_description` varchar(255),
  `media_user_text` varchar(255),
  `media_lien` varchar(255),
  `media_article_id` int(11) NOT NULL,
PRIMARY KEY (`media_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

