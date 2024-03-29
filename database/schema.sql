CREATE TABLE `billets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_billet` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `commentaire` text NOT NULL,
  `date_commentaire` datetime NOT NULL,
  `date_modification_commentaire` datetime DEFAULT NULL,
  `id_auteur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `membres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
);