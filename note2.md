# Organisation du projet

## Models

### Referentiel (catalogue)
- DEV
  - Competences
    - Frontend
        - HTML
        - CSS
        - JavaScript
  - Backend
    - Laravel
    - Java
    - Git/Github

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

### User (avec 2 models pour le basculement)
- Local (pgsql) [table -> users + role]
- Firebase

### Promotion
-P1 (statut = cloture)
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
            - Emergement (Organiser par date) Format :  date-jour present/absent
                - Present (2 cles arrive et depart)
                - Absent
            - Note
                - Competences
                    - Frontend
                        - HTML
                            - Notes
                                - Note 1
                                - Note 2
                                - Note n
                            - Appreciation     
                        - CSS
                        - JavaScript
                    - Backend
                        - Laravel
                        - Java
                        - Git/Github
    - Referent Digital
        - Apprenant
            - Emergement (Organiser par date) Format :  date-jour present/absent
            - Note 
                - Competences
                    - Stratégie et Gestion
            - Emergement (Organiser par date) Format :  date-jour present/absent
            - Note 
                - Competences
                    - Stratégie et Gestion
                        - Stratégie digitale
                            - Note
                                - Note 1
                                - Note 2
                                - Note n
                            - Appreciation
                        - Gestion de projet web
                    - Design et Communication
                        - UX/UI Design
                        - Réseaux sociaux
                        - Stratégie digitale
                            - Note
                                - Note 1
                                - Note 2
                                - Note n
                            - Appreciation
                        - Gestion de projet web
                    - Design et Communication
                        - UX/UI Design
                        - Réseaux sociaux

    - Dev Data
    - Hackeuse
    - AWS

### Apprenant
- Emergement (Organiser par date)
  - Present (2 clés: arrivée et départ)
  - Absent

## Règles et fonctionnalités

1. Une seule promotion peut être active à la fois.

2. Création d'une promotion :
   - D'un coup
   - D'un coup suivi de la création d'un referentiel en même temps

3. Création d'un apprenant :
   - Manuellement dans le formulaire
   - À partir d'un fichier Excel (tous les apprenants)

4. Processus d'importation du fichier Excel :
   - Vérifier l'email et l'identifiant s'ils existent déjà
   - Générer un fichier Excel avec les apprenants non enregistrés
   - Envoyer un email aux apprenants enregistrés et activer leur accès
   - Job de relance pour renvoyer des emails aux apprenants non authentifiés

5. Première connexion d'un apprenant :
   - Détecter la première connexion
   - Demander le changement de mot de passe
   - Rediriger vers l'endpoint de changement de mot de passe
   - Activer le compte après le changement de mot de passe











--------------------------------------------------------------------------------------------


promotions (collection)
|
|-- P1 (document)
|   |-- name: "P1"
|   |-- status: "cloture"
|   |-- referentials: ["Dev Web/Mobile"]
|
|-- P2 (document)
|   |-- name: "P2"
|   |-- status: "cloture"
|   |-- referentials: ["Referentiel Digital", "Dev Web/Mobile"]
|
|-- P6 (document)
    |-- name: "P6"
    |-- status: "active"
    |-- referentials: ["Dev Web/Mobile", "Referentiel Digital"]
    |-- apprenants (subcollection)
        |
        |-- apprenant1 (document)
        |   |-- name: "Nom de l'apprenant"
        |   |-- emergements (subcollection)
        |   |   |-- 2023-06-01 (document)
        |   |   |   |-- status: "present"
        |   |   |   |-- arrive: "09:00"
        |   |   |   |-- depart: "17:00"
        |   |
        |   |-- notes (subcollection)
        |       |-- frontend (document)
        |       |   |-- html (map)
        |       |   |   |-- notes: [8, 9, 7]
        |       |   |   |-- appreciation: "Bon travail"
        |       |   |
        |       |   |-- css (map)
        |       |   |-- javascript (map)
        |       |
        |       |-- backend (document)
        |           |-- laravel (map)
        |           |-- java (map)
        |           |-- git (map)







- Model (FireStoreModel) create find update
- Repositories (FireStoreRepository)
- Service (FireStoreService) on utilise facade 
- Controller



Ajouter des documents,
Récupérer des documents,
Ajouter des sous-collections,
Mettre à jour et supprimer des documents.








2 Model ( UserEloquent et UserFirebase)
    - UserEloquen extends Model
    - UserFirebase (doit etre facade) extends FirebaseModel
1 UserService
2 Repositories (UserFirebaseRepo et UserEloquentRepo) avec chacun son interface.

