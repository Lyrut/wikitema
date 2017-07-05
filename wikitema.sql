--
-- Base de données :  `wikitema`
--



--
-- Structure de la table `user`
--

CREATE TABLE if not exists `user` (
  `user_id` int(11) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_pseudo` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_email` tinytext NOT NULL,
  `user_token` binary(32),
  `user_date_created` date NOT NULL,
  `user_role` int(1) NOT NULL DEFAULT 3
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


CREATE TABLE if not exists `theme` (
  `theme_id` int(11) NOT NULL,
  `theme_name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--
-- Structure de la table `article`
--

CREATE TABLE if not exists `article` (
  `article_id` int(11) NOT NULL,
  `article_theme_id` varchar(255) NOT NULL,
  `article_title` varchar(255) NOT NULL,
  `article_text` longtext NOT NULL,
  `article_commentaire` longtext,
  `article_user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE if not exists `media` (
  `media_id` int(11) NOT NULL,
  `media_name` varchar(255) NOT NULL,
  `media_description` varchar(255),
  `media_user_text` varchar(255),
  `media_lien` varchar(255),
  `media_article_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`article_id`);

--
-- Index pour la table `image`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`media_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

ALTER TABLE `theme`
  ADD PRIMARY KEY (`theme_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
