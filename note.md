

## Step 1

1. Models

- Referentiel (catalogue)
    - DEV
        - competences
            - Analyse competences
            - Frontend
                - HTML
                - CSS
                - JavaScript

            - Backend
                - Laravel
                - Java
                - Git/Guthub

   
    - Referent Digital
        - Competences
             - Stratégie et Gestion
                - Stratégie digitale
                - Gestion de projet web

             - Design et Communication
                - UX/UI Design
                - Réseaux sociaux
    - Dev Web/Mobile
    - Dev Data
    - Hackeuse
    - AWS
     
        


- User (avec 2 models pour le basculement)
    - local (pgsql) [ table -> users + role]
    - Firebase 


- Promotion
    - P1 (statut = cloture)
        - Referentiel
            - Dev Web/Mobile

    - P2 (statut = cloture)
        - Referentiel
            - Referentiel Digital
            - Dev Web/Mobile
    - P3 (statut = cloture)
    - P4 (statut = cloture)
    - P5 (statut = cloture)
    - P6 (statut = active)
        - Referentiels
            - Dev Web/Mobile
                - Apprenant
                    - Emergement (Organiser par date) // date-jour present/absent
                        - Present (2 cles arrive et depart)
                        - Absent

            - Referentiel Digital
            - Dev Data
            - Hackeuse
            - AWS




NB : il ne peut y avoir que une seule promotion active.


Pour la creation de la promotion il y'a deux manieres (on doit indiquer la promo de combien de referentiel il doit avoir).
 1. D'un coup
 2. D'un coup suit la creation d'un referentiel en meme temps.


 - creation d'un apprenant : 
    - creation d'un compte Manuellement dans le formulaire
    - A partir d'un fichier excel (all apprenants) on va les ajouter dans la base de donnee avec (validation).
     - Le fichier excel comment ca marche : 
        - Il faut verifier l'email et l'identifiant s'il existe deja.
        - apres creation on doit generer un autre fichier excel ayant les apprenant qui n'on pas ete enregistre.
        - Pour ceux qui ont ete enregistre, on doit les envoyer mail et activer pour qu'il accede dans le systeme.
        - pour ceux qui ont recu de mail et il n'ont pas s'authentifier, on doit faire un job relance qui les envoie de nouveau mail.



    NB : Apres creation d'un apprenant, on lui envoie son login et mot de passe (par defaut) pour pouvoir se connecter.
        - S'il s'authentifie on doit detecter c'est ca premiere connexion , sinon on doit faire un changement de mot de passe par ce message "Vous devez changer votre mot de passe".Apres on lui redirige dans l'endpoint qui change son mot de passe. S'il change ce mot on considere son compte est "active" et on peut passer au niveau suivant.



Design Pattern utiliser + Couplage faible : /Controller, /Service et /Repository

- FirebaseModel (classe abstraite) 
on creer (3) Models qui s'heritent de FirebaseModel avec chacun sa facade :
    - UserFirebase 
    - PromotionFirebase
    - ReferentielFirebase



- Model (Eloquent) pour stockage local si on se bascule.
    - User
    - Promotion
    - Referentiel
