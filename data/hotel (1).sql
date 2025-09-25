

CREATE TABLE `chambre` (
  `IDchambre` int(11) NOT NULL,
  `numerochambre` int(11) NOT NULL,
  `etage` int(11) NOT NULL,
  `IDtypedechambre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`IDchambre`, `numerochambre`, `etage`, `IDtypedechambre`) VALUES
(1, 23, 23, 2),
(2, 385, 0, 1),
(3, 423, 0, 3);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `IDclients` int(11) NOT NULL,
  `nomclient` varchar(100) NOT NULL,
  `emailclient` varchar(150) DEFAULT NULL,
  `numeroclient` varchar(20) DEFAULT NULL,
  `IDutilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`IDclients`, `nomclient`, `emailclient`, `numeroclient`, `IDutilisateur`) VALUES
(1, 'Reprehenderit place', 'vyzecaj@mailinator.com', '+1 (701) 348-8241', NULL),
(2, '375', 'your.email+fakedata51262@gmail.com', '161-259-0679', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clients_chambre`
--

CREATE TABLE `clients_chambre` (
  `IDchambre` int(11) NOT NULL,
  `IDclients` int(11) NOT NULL,
  `IDutilisateur` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `datedebut` date NOT NULL,
  `datefin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients_chambre`
--

INSERT INTO `clients_chambre` (`IDchambre`, `IDclients`, `IDutilisateur`, `date`, `datedebut`, `datefin`) VALUES
(1, 1, 1, NULL, '2025-09-16', '2025-09-18'),
(2, 1, 1, NULL, '2025-09-26', '2025-09-27'),
(3, 1, 3, NULL, '2026-02-21', '2026-03-08');

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `IDhistorique` int(11) NOT NULL,
  `date` date NOT NULL,
  `action` varchar(100) NOT NULL,
  `detaille` text DEFAULT NULL,
  `IDutilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `typedechambre`
--

CREATE TABLE `typedechambre` (
  `IDtypedechambre` int(11) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typedechambre`
--

INSERT INTO `typedechambre` (`IDtypedechambre`, `grade`, `prix`) VALUES
(1, 'nam amet odit', 58.00),
(2, 'Mongolia', 10054.00),
(3, 'Guinea-Bissau', 42832.00),
(4, 'Mexico', 70032.00),
(5, 'Kiribati', 234.00),
(6, 'Philippines', 94268.00);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `IDutilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `matricule` varchar(50) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `MDP` varchar(255) NOT NULL,
  `nature` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDutilisateur`, `nom`, `matricule`, `telephone`, `MDP`, `nature`) VALUES
(1, 'fofana', 'meke22', '0987654432', '$2y$10$aARCtxMqLpPr5KRbgBQTP.S8sUK0.FbpXFNC0obQvEut/4/ZADLzC', 'client'),
(2, 'Vitae dolore perfere', 'rt33', '0987654223', '$2y$10$vl02pVnOaubN5LYjj1gVG.QdRrlkyGtUfhU3wB8af.8ydJtRpmwL.', 'admin'),
(3, 'fofana meke daniel', 'fofana12', '098765432', '$2y$10$euh4so5a/DJEwXPqeSQyn.Rx7bskLP2VuyOwWeqsq9kGBqSfMJGtG', 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`IDchambre`),
  ADD UNIQUE KEY `numerochambre` (`numerochambre`),
  ADD KEY `IDtypedechambre` (`IDtypedechambre`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`IDclients`),
  ADD UNIQUE KEY `emailclient` (`emailclient`),
  ADD KEY `IDutilisateur` (`IDutilisateur`);

--
-- Index pour la table `clients_chambre`
--
ALTER TABLE `clients_chambre`
  ADD PRIMARY KEY (`IDchambre`,`IDclients`,`datedebut`),
  ADD KEY `IDclients` (`IDclients`),
  ADD KEY `IDutilisateur` (`IDutilisateur`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`IDhistorique`),
  ADD KEY `IDutilisateur` (`IDutilisateur`);

--
-- Index pour la table `typedechambre`
--
ALTER TABLE `typedechambre`
  ADD PRIMARY KEY (`IDtypedechambre`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`IDutilisateur`),
  ADD UNIQUE KEY `matricule` (`matricule`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `IDchambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `IDclients` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `historique`
--
ALTER TABLE `historique`
  MODIFY `IDhistorique` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `typedechambre`
--
ALTER TABLE `typedechambre`
  MODIFY `IDtypedechambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `IDutilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `chambre_ibfk_1` FOREIGN KEY (`IDtypedechambre`) REFERENCES `typedechambre` (`IDtypedechambre`);

--
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`IDutilisateur`) REFERENCES `utilisateur` (`IDutilisateur`);

--
-- Contraintes pour la table `clients_chambre`
--
ALTER TABLE `clients_chambre`
  ADD CONSTRAINT `clients_chambre_ibfk_1` FOREIGN KEY (`IDchambre`) REFERENCES `chambre` (`IDchambre`),
  ADD CONSTRAINT `clients_chambre_ibfk_2` FOREIGN KEY (`IDclients`) REFERENCES `clients` (`IDclients`),
  ADD CONSTRAINT `clients_chambre_ibfk_3` FOREIGN KEY (`IDutilisateur`) REFERENCES `utilisateur` (`IDutilisateur`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`IDutilisateur`) REFERENCES `utilisateur` (`IDutilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
