# myPortfolio
A personal portfolio website designed to showcase my skills, experience, and projects.

Lien d'accès local :
Acueil: http://127.0.0.1:5501/index.html
Add competance : http://127.0.0.1:5501/competance/comp.html

Lien d'accès au portfolio sur InfinityFree

Portfolio : https://fettis.ct.ws/

CV : https://fettis.ct.ws/cv/

Formulaire pour ajouter des compétences : https://fettis.ct.ws/competance/

Configuration spéciale sur InfinityFree

J'ai utilisé un fichier .htaccess pour organiser les URLs et rendre l'accès plus intuitif. Cela permet de simplifier les liens comme /competance au lieu de /competance/comp.html.

Lien d'accès au portfolio sur GitHub Pages

Portfolio : https://mohamedfettis.github.io/myPortfolio/

Formulaire pour ajouter des compétences : https://mohamedfettis.github.io/myPortfolio/competance/comp.html

CV : https://mohamedfettis.github.io/myPortfolio/cv/cv.html

Particularités de GitHub Pages

Sur GitHub Pages, .htaccess n'est pas supporté, ce qui m'a conduit à organiser les fichiers de manière explicite pour permettre l'accès direct aux pages avec leurs noms complets (par exemple : /competance/comp.html).


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


### Description des principaux dossiers et fichiers :

.
├── competance/
│   └── comp.html        # Page pour ajouter des compétences
├── css/
│   └── style.css        # Styles principaux
├── cv/
│   ├── cv.html          # Page CV
│   └── cv.css           # Styles pour le CV
├── imgs/                # Images utilisées dans le projet
├── .htaccess            # Configuration pour les URL
├── index.html           # Page principale
├── LICENSE              # Licence du projet
├── README.md            # Documentation du projet
├── script.js            # Script principal
└── skills.js            # Gestion des compétences




#### Utilisation
1. Ajouter une compétence :
   - Ouvrez le https://fettis.ct.ws/competance/ .
   - Remplissez les champs du formulaire et cliquez sur "Ajouter".
   - La compétence est automatiquement enregistrée et apparaît dans la liste sur https://fettis.ct.ws/.

2. Modifier une compétence :
   - Cliquez sur le bouton "Modifier" associé à une compétence dans la section des compétences sur https://fettis.ct.ws/.
   - Mettez à jour les informations et validez.

3. Supprimer une compétence :
   - Cliquez sur "Supprimer" pour retirer une compétence de la liste.

Technologies utilisées
- HTML5 : Structure du contenu.
- CSS3 : Mise en forme et design (couleur principale : #d4af37).
- JavaScript : Manipulation du DOM et gestion des compétences.
- localStorage : Sauvegarde des données localement.


Auteur : Mohamed Amokrane Fettis
