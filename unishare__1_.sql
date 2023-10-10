-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 10 oct. 2023 à 21:56
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `unishare`
--

-- --------------------------------------------------------

--
-- Structure de la table `articlecategories`
--

DROP TABLE IF EXISTS `articlecategories`;
CREATE TABLE IF NOT EXISTS `articlecategories` (
  `id` int NOT NULL,
  `Categorie1` int NOT NULL,
  `Categorie2` int NOT NULL,
  `Categorie3` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articlecategories`
--

INSERT INTO `articlecategories` (`id`, `Categorie1`, `Categorie2`, `Categorie3`) VALUES
(4, 3, 2, 4),
(3, 3, 4, 0),
(2, 0, 0, 0),
(1, 3, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int NOT NULL,
  `Titre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `IdListe` int NOT NULL,
  `Pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IdListe` (`IdListe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `Titre`, `Description`, `IdListe`, `Pseudo`) VALUES
(2, ' Les Mathématiques : Language Universel', ' L\'importance des mathématiques dépasse largement le simple cadre académique. Elles sont un pilier de notre civilisation, facilitant la compréhension, l\'innovation et la communication à travers le monde. Reconnaître et valoriser leur rôle est essentiel pour continuer à progresser en tant que société.', 2, 'Ibrahim'),
(3, 'Géopolitique et Racisme ', 'La géopolitique, cette étude des relations internationales à travers le prisme du territoire, de la population et des ressources, est intrinsèquement liée aux phénomènes sociaux, culturels et politiques qui façonnent notre monde. Parmi eux, le racisme se révèle être un élément perturbateur influençant profondément la dynamique entre nations.\r\n\r\nHistoriquement, le racisme a été utilisé comme outil de justification pour l\'expansion impérialiste et la colonisation. De nombreuses puissances coloniales ont propagé l\'idée de la supériorité raciale pour légitimer leur domination sur d\'autres peuples. Ces préjugés, une fois implantés, ont durablement altéré la perception des nations et des races entre elles.\r\n\r\nEn conclusion, la géopolitique et le racisme sont étroitement liés, et leur intersection crée des dynamiques complexes qui influencent la scène mondiale. Reconnaître et combattre les préjugés raciaux est non seulement une question de justice sociale, mais aussi une étape essentielle pou', 3, 'Tarak'),
(1, 'Premier Article ', 'L\'Article Inaugural de la Base de Données : Un Jalon Historique\r\n\r\nDans l\'évolution constante des bases de données, le tout premier article inséré possède une importance particulière. Il sert non seulement de point de départ, mais aussi de boussole pour les futurs ajouts, illustrant ainsi les ambitions et orientations initiales. Aujourd\'hui, nous célébrons le premier article de notre base de données, un témoignage du commencement d\'une aventure riche en informations.\r\n\r\nL\'insertion d\'un premier article est loin d\'être anodine. Il définit le ton, établit les normes et sert souvent de référence pour les utilisateurs et administrateurs. Sa valeur ne se trouve pas tant dans son contenu que dans ce qu\'il symbolise : une première étape vers la création d\'une source d\'information qui peut potentiellement bénéficier à des milliers, voire des millions de personnes.\r\n\r\nCe moment unique mérite une attention particulière, car il rappelle également les défis et les opportunités que chaque nouvelle ', 1, 'admin'),
(4, 'Informatique : le nouvel eldorado', 'L\'informatique, autrefois confinée aux laboratoires de recherche et aux grandes entreprises, s\'est solidement imposée au cœur de la géopolitique mondiale. Les avancées technologiques, notamment dans le domaine du numérique, ont redéfini les rapports de force entre les nations et introduit de nouvelles dimensions dans le jeu des puissances.', 4, 'Ibrahim');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `Id` int NOT NULL,
  `Name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`Id`, `Name`) VALUES
(3, 'Politique'),
(2, 'Informatique'),
(0, 'Undefined'),
(4, 'Geopolitique'),
(5, 'Geographie');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int NOT NULL,
  `IdArticle` int NOT NULL,
  `Description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Pseudo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `IdUser` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `IdArticle`, `Description`, `Pseudo`, `IdUser`) VALUES
(1, 1, 'Tres bon article, hate de voir le prochain', 'Tarak', 4),
(2, 3, 'Tres bon Article\r\n', 'Ibrahim', 3),
(3, 2, 'Tres bon article', 'Thomas', 2),
(4, 4, 'L\'article me parait bien trop court, desolé', 'Thomas', 2),
(5, 1, 'Mes Félicitations', 'Thomas', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `SessionId` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Email` (`Email`),
  UNIQUE KEY `SessionId` (`SessionId`),
  UNIQUE KEY `Pseudo` (`Pseudo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `Email`, `Password`, `Pseudo`, `Admin`, `SessionId`) VALUES
(4, 'tarak@gmail.com', 'Django', 'Tarak', 0, 'hm08dnjprq3nsltqev27jktnil'),
(3, 'baroum01@gmail.com', 'Emma', 'Ibrahim', 0, 'h0559129cpr8v3sk9el075kmlf'),
(2, 'babia@gmail.com', 'Oliveira', 'Thomas', 0, '1jck5c6o2v8gkel43gvj8ca028'),
(1, 'admin', 'azerty', 'admin', 1, 'sessionadmin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
