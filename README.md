# myPortfolio
A personal portfolio website designed to showcase my skills, experience, and projects.
lien: 
https://mohamedfettis.github.io/myPortfolio/


Portfolio Web - Gestion des Compétences

Ce projet est une extension de mon portfolio personnel. Il inclut une fonctionnalité permettant de gérer vos compétences professionnelles. Ce fichier README décrit en détail les fonctionnalités du projet, la structure des fichiers et la manière de le configurer et l'utiliser.

Objectifs
L'objectif de ce projet est de créer une section interactive de gestion des compétences qui s'intègre à votre portfolio. Vous utiliserez HTML, CSS, et JavaScript pour :
- Ajouter des compétences via un formulaire.
- Afficher les compétences sur votre page principale.
- Modifier ou supprimer des compétences existantes.
- Sauvegarder les compétences localement avec le localStorage.

Fonctionnalités
1. Ajout de compétences :
   - Formulaire d'ajout comprenant :
     - Un champ pour l'icône (avec Boxicons).
     - Un champ pour le nom de la compétence.
     - Une description optionnelle.
     - Un menu déroulant pour le niveau (Débutant, Intermédiaire, Avancé).
   - Les compétences ajoutées sont automatiquement affichées sur la page et enregistrées dans le localStorage.

2. Affichage des compétences :
   - Les compétences sont listées dynamiquement avec :
     - Nom, description, et niveau.
     - Icône associée.
   - Mise à jour automatique lors de l'ajout ou de la suppression.

3. Modification des compétences :
   - Un bouton permet de modifier une compétence existante directement depuis la liste.
   - Les modifications sont mises à jour dans le localStorage et sur la page.

4. Suppression de compétences :
   - Chaque compétence dispose d'un bouton "Supprimer" pour la retirer de la liste.
   - La suppression met à jour le localStorage.

5. Persistance des données :
   - Toutes les compétences sont stockées localement (évitant la perte de données en cas de rafraîchissement de la page).

Structure des fichiers
Voici la structure des fichiers utilisés dans ce projet :

portfolio/
├── index.html           # Page principale du portfolio
├── formulaire.html      # Page pour ajouter des compétences
├── styles.css           # Fichier CSS global
├── skills.js            # Gestion des compétences (affichage, modification, suppression)
├── formulaire.js        # Gestion du formulaire (ajout des compétences)
└── README.txt           # Documentation du projet

Installation et configuration
1. Clonez ou téléchargez ce projet dans votre environnement local.
2. Assurez-vous que tous les fichiers (HTML, CSS, JS) sont dans le même répertoire.
3. Ouvrez le fichier index.html dans un navigateur web pour voir la page principale.
4. Ouvrez formulaire.html pour ajouter de nouvelles compétences.

Utilisation
1. Ajouter une compétence :
   - Ouvrez formulaire.html.
   - Remplissez les champs du formulaire et cliquez sur "Ajouter".
   - La compétence est automatiquement enregistrée et apparaît dans la liste sur index.html.

2. Modifier une compétence :
   - Cliquez sur le bouton "Modifier" associé à une compétence dans la section des compétences sur index.html.
   - Mettez à jour les informations et validez.

3. Supprimer une compétence :
   - Cliquez sur "Supprimer" pour retirer une compétence de la liste.

Technologies utilisées
- HTML5 : Structure du contenu.
- CSS3 : Mise en forme et design (couleur principale : #d4af37).
- JavaScript : Manipulation du DOM et gestion des compétences.
- localStorage : Sauvegarde des données localement.

Améliorations futures
- Ajouter une fonctionnalité de recherche pour filtrer les compétences par nom ou niveau.
- Intégrer une base de données pour un stockage plus robuste.
- Ajouter des animations pour rendre l’interface plus dynamique.

Auteur : Mohamed Amokrane Fettis
