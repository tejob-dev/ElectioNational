<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Créer',
        'edit' => 'Modifier',
        'update' => 'Mettre à jour',
        'new' => 'Nouveau',
        'cancel' => 'Annuler',
        'attach' => 'Joindre',
        'detach' => 'Détacher',
        'save' => 'Enregistrer',
        'delete' => 'Supprimer',
        'delete_selected' => 'Supprimer la sélection',
        'search' => 'Rechercher...',
        'back' => 'Retour à la liste',
        'are_you_sure' => 'Êtes-vous sûr ?',
        'no_items_found' => 'Aucun élément trouvé',
        'created' => 'Créé avec succès',
        'saved' => 'Enregistré avec succès',
        'removed' => 'Supprimé avec succès',
    ],
    
    'sous_sections' => [
        'name' => 'Sous Sections',
        'index_title' => 'Liste des Sous sections',
        'new_title' => 'Nouveau Sous section',
        'create_title' => 'Créer un sous section',
        'edit_title' => 'Modification du Sous section',
        'show_title' => 'Affichage Sous section',
        'inputs' => [
            'libel' => 'Libellé',
            'objectif' => 'Objectif',
        ],
    ],
    
    'soussections' => [
        'name' => 'Sous Sections',
        'index_title' => 'Liste des Sous sections',
        'new_title' => 'Nouveau Sous section',
        'create_title' => 'Créer un sous section',
        'edit_title' => 'Modification du Sous section',
        'show_title' => 'Affichage Sous section',
        'inputs' => [
            'libel' => 'Libellé',
            'objectif' => 'Objectif',
        ],
    ],

    'agent_de_sections' => [
        'name' => 'Responsable de Sections',
        'index_title' => 'Liste des Responsables de Sections',
        'new_title' => 'Nouveau Responsable de Section',
        'create_title' => 'Ajouter un Responsable de section',
        'edit_title' => 'Modifier',
        'show_title' => 'Details',
        'inputs' => [
        'nom' => 'Nom',
        'prenom' => 'Prénom',
        'telephone' => 'Téléphone',
        'section_id' => 'Section',
        ],
    ],

    'agent_de_bureau_votes' => [
        'name' => 'Agent du Bureau de Votes',
        'index_title' => 'Liste des Agents du Bureau de Votes',
        'new_title' => 'Nouvel agent du bureau de vote',
        'create_title' => 'Ajouter un agent du Bureau de Vote',
        'edit_title' => 'Modifier un agent du Bureau de Vote',
        'show_title' => 'Détails de l\'agent du Bureau de Vote',
            'inputs' => [
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'telephone' => 'Téléphone',
            'bureau_vote_id' => 'Bureau de Vote',
        ],
    ],

    'agent_terrains' => [
        'name' => 'Les Parrains',
        'index_title' => 'Liste des parrains',
        'new_title' => 'Nouveau parrain',
        'create_title' => 'Ajouter un parrain',
        'edit_title' => 'Modifier le parrain',
        'show_title' => 'Détails',
        'inputs' => [
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'code' => 'Code',
            'telephone' => 'Téléphone',
            'lieu_vote_id' => 'Lieu de Vote',
        ],
    ],
    
    'bureau_votes' => [
        'name' => 'Bureaux de Vote',
        'index_title' => 'Liste des Bureaux de Vote',
        'new_title' => 'Nouveau bureau de vote',
        'create_title' => 'Ajouter un bureau de vote',
        'edit_title' => 'Modifier un bureau de vote',
        'show_title' => 'Détails du bureau de vote',
        'inputs' => [
            'libel' => 'Libellé',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
            'lieu_vote_id' => 'Lieu de Vote',
        ],
    ],
    

    'candidats' => [
        'name' => 'Candidats',
        'index_title' => 'Liste des Candidats',
        'new_title' => 'Nouveau Candidat',
        'create_title' => 'Ajouter un Candidat',
        'edit_title' => 'Modifier un Candidat',
        'show_title' => 'Afficher un Candidat',
        'inputs' => [
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'code' => 'Code',
            'photo' => 'Photo',
            'couleur' => 'Couleur',
            'parti' => 'Parti',
        ],
    ],

    'communes' => [
        'name' => 'Regions',
        'index_title' => 'Liste des regions',
        'new_title' => 'Nouvelle region',
        'create_title' => 'Ajouter une region',
        'edit_title' => 'Modifier une region',
        'show_title' => 'Afficher une region',
        'inputs' => [
        'libel' => 'Libellé',
        'nbrinscrit' => 'Nombre d\'inscrits',
        'objectif' => 'Objectif',
        'seuil' => 'Seuil',
        ],
    ],

    'lieu_votes' => [
        'name' => 'Lieux de vote',
        'index_title' => 'Liste des lieux de vote',
        'new_title' => 'Nouveau lieu de vote',
        'create_title' => 'Ajouter un lieu de vote',
        'edit_title' => 'Modifier un lieu de vote',
        'show_title' => 'Afficher un lieu de vote',
        'inputs' => [
            'code' => 'Code',
            'libel' => 'Libellé',
            'nbrinscrit' => 'Nombre d\'inscrits',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
            'quartier_id' => 'Section',
        ],
    ],
    
    'parrains' => [
        'name' => 'Parrains',
        'index_title' => 'Liste des parrains',
        'new_title' => 'Nouveau parrain',
        'create_title' => 'Ajouter un parrain',
        'edit_title' => 'Modifier un parrain',
        'show_title' => 'Afficher un parrain',
        'inputs' => [
            'nom_pren_par' => 'Nom et prénom du parrain',
            'telephone_par' => 'Téléphone du parrain',
            'nom' => 'Nom',
            'prenom' => 'Prénom',
            'lieu_projet' => 'Idée du projet',
            'list_elect' => 'Liste électorale',
            'cart_elect' => 'Carte électorale',
            'telephone' => 'Téléphone',
            'date_naiss' => 'Date de naissance',
            'code_lv' => 'Code du lieu de vote',
            'residence' => 'Résidence',
            'profession' => 'Profession',
            'idee_projet' => 'Idée du projet',
        ],
    ],
    

    'proces_verbals' => [
        'name' => 'Procès-Verbaux',
        'index_title' => 'Liste des Procès-Verbaux',
        'new_title' => 'Nouveau Procès-Verbal',
        'create_title' => 'Ajouter un Procès-Verbal',
        'edit_title' => 'Modifier le Procès-Verbal',
        'show_title' => 'Détails du Procès-Verbal',
        'inputs' => [
        'libel' => 'Libellé',
        'photo' => 'Photo',
        'bureau_vote_id' => 'Bureau de Vote',
        ],
    ],

    'rcommunes' => [
        'name' => 'Communes',
        'index_title' => 'Liste des Communes',
        'new_title' => 'Nouveau Commune',
        'create_title' => 'Ajouter un Commune',
        'edit_title' => 'Modifier le Commune',
        'show_title' => 'Détails du Commune',
        'inputs' => [
            'libel' => 'Libellé',
            'nbrinscrit' => 'Nombre d\'inscrits',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
            'section_id' => 'Departement',
        ],
    ],
    
    'quartiers' => [
        'name' => 'Sections',
        'index_title' => 'Liste des Sections',
        'new_title' => 'Nouveau Section',
        'create_title' => 'Ajouter un Section',
        'edit_title' => 'Modifier le Section',
        'show_title' => 'Détails du Section',
        'inputs' => [
            'libel' => 'Libellé',
            'nbrinscrit' => 'Nombre d\'inscrits',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
            'rcommune_id' => 'Commune',
        ],
    ],
    
    'sections' => [
        'name' => 'Sections',
        'index_title' => 'Liste des Sections',
        'new_title' => 'Nouvelle Section',
        'create_title' => 'Ajouter une Section',
        'edit_title' => 'Modifier la Section',
        'show_title' => 'Détails de la Section',
        'inputs' => [
            'libel' => 'Libellé',
            'nbrinscrit' => 'Nombre d\'inscrits',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
            'commune_id' => 'Régions',
        ],
    ],    

    'sup_lieu_de_votes' => [
        'name' => 'Sup Lieu De Votes',
        'index_title' => 'Liste des Superviseurs de lieux de votes',
        'new_title' => 'Nouveau Superviseur lieu de vote',
        'create_title' => 'Ajouter un Superviseur De Lieu De Vote',
        'edit_title' => 'Modifier un Superviseur De Lieu De Vote',
        'show_title' => 'Afficher un Superviseur De Lieu De Vote',
        'inputs' => [
        'nom' => 'Nom',
        'prenom' => 'Prénom',
        'telephone' => 'Téléphone',
        'lieu_vote_id' => 'Lieu de vote',
        ],
    ],

    'agent_du_bureau_votes' => [
        'name' => 'Agent Du Bureau de Votes',
        'index_title' => 'Liste des Agents du Bureau de Votes',
        'new_title' => 'Nouveau agent du bureau de vote',
        'create_title' => 'Ajouter un agent du bureau de vote',
        'edit_title' => 'Modifier un agent du bureau de vote',
        'show_title' => 'Afficher un agent du bureau de vote',
        'inputs' => [
        'nom' => 'Nom',
        'prenom' => 'Prénom',
        'telphone' => 'Téléphone',
        'bureau_vote_id' => 'Bureau de vote',
        ],
    ],

    'users' => [
        'name' => 'Utilisateurs',
        'index_title' => 'Liste des utilisateurs',
        'new_title' => 'Nouvel utilisateur',
        'create_title' => 'Ajouter un utilisateur',
        'edit_title' => 'Modifier un utilisateur',
        'show_title' => 'Afficher un utilisateur',
        'inputs' => [
            'name' => 'Nom',
            'prenom' => 'Prénom',
            'email' => 'Email',
            'date_naiss' => 'Date de naissance',
            'password' => 'Mot de passe',
            'commune_id' => 'Commune',
            'departement_id' => 'Département',
            'photo' => 'Photo',
        ],
    ],
    
    'departements' => [
        'name' => 'Départements',
        'index_title' => 'Liste des départements',
        'new_title' => 'Nouveau département',
        'create_title' => 'Ajouter un département',
        'edit_title' => 'Modifier un département',
        'show_title' => 'Afficher un département',
        'inputs' => [
            'libel' => 'Libellé',
            'nbrinscrit' => 'Nombre d\'inscrits',
            'objectif' => 'Objectif',
            'seuil' => 'Seuil',
        ],
    ],
    

    'roles' => [
        'name' => 'Rôles',
        'index_title' => 'Liste des Rôles',
        'create_title' => 'Ajouter un Rôle',
        'edit_title' => 'Modifier un Rôle',
        'show_title' => 'Afficher un Rôle',
        'inputs' => [
        'name' => 'Nom',
        ],
    ],         

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Liste des Permissions',
        'create_title' => 'Ajouter une Permission',
        'edit_title' => 'Modifier une Permission',
        'show_title' => 'Afficher une Permission',
        'inputs' => [
            'name' => 'Nom',
        ],
    ],

    'cor_parrains' => [
        'name' => 'Recensé',
        'index_title' => 'Liste des recensés',
        'new_title' => 'Ajouter',
        'create_title' => 'Créer',
        'edit_title' => 'Modifier',
        'show_title' => 'Afficher',
        'inputs' => [
            'nom_prenoms' => 'Nom/Prénoms',
            'phone' => 'Téléphone',
            'carte_elect' => 'Carte Electeur',
            'nom_lv' => 'Lieu de Votes',
            'agent_res_nompren' => 'Agent Responsable',
            'agent_res_phone' => 'Agent Téléphone',
            'a_vote' => 'A Vote',
        ],
    ],

    'operateur_suivis' => [
        'name' => 'Operateurs de Suivi',
        'index_title' => 'Liste Opérateurs de Suivi',
        'new_title' => 'Ajouter Opérateurs de Suivi',
        'create_title' => 'Créer Opérateurs de Suivi',
        'edit_title' => 'Editer Opérateurs de Suivi',
        'show_title' => 'Afficher Opérateurs de Suivi',
        'inputs' => [
            'nom' => 'Nom',
            'prenoms' => 'Prenoms',
            'telephone' => 'Telephone',
        ],
    ],

    'rabatteurs' => [
        'name' => 'Rabatteurs',
        'index_title' => 'Liste de Rabatteurs',
        'new_title' => 'Ajouter Rabatteur',
        'create_title' => 'Créer Rabatteur',
        'edit_title' => 'Editer Rabatteur',
        'show_title' => 'Afficher Rabatteur',
        'inputs' => [
            'nom' => 'Nom',
            'prenoms' => 'Prénoms',
            'telephone' => 'Téléphone',
        ],
    ],

    'operateur_suivi_lieu_votes' => [
        'name' => 'Operateurs de Suivi des Lieu Votes',
        'index_title' => 'La liste',
        'new_title' => 'Ajouter Lieu vote et operateur de suivi',
        'create_title' => 'Créer Lieu vote et operateur de suivi',
        'edit_title' => 'Editer Lieu vote et operateur de suivi',
        'show_title' => 'Afficher Lieu vote et operateur de suivi',
        'inputs' => [
            'lieu_vote_id' => 'Lieux Votes',
        ],
    ],

    'rabatteur_lieu_votes' => [
        'name' => 'Rabatteur Lieu Votes',
        'index_title' => ' List',
        'new_title' => 'Ajouter rabatteur et Lieu vote',
        'create_title' => 'Créer rabatteur et Lieu vote',
        'edit_title' => 'Editer rabatteur et Lieu vote',
        'show_title' => 'Afficher rabatteur et Lieu vote',
        'inputs' => [
            'lieu_vote_id' => 'Lieux Votes',
        ],
    ],
    
];
