# Diagramme UML du Projet BiblioTech

```mermaid
classDiagram
    class Categorie {
        +id: integer
        +nom: string
        +description: text
        +slug: string
        +couleur: string
        +icone: string
        +active: boolean
        +created_at: timestamp
        +updated_at: timestamp
        +livres(): hasMany
        +scopeRecherche(terme): query
        +scopeActives(): query
    }

    class Livre {
        +id: integer
        +titre: string
        +auteur: string
        +annee: integer
        +nb_pages: integer
        +isbn: string
        +resume: text
        +couverture: string
        +disponible: boolean
        +categorie_id: integer
        +created_at: timestamp
        +updated_at: timestamp
        +categorie(): belongsTo
        +scopeDisponible(): query
        +scopeRecherche(terme): query
        +scopeParCategorieSlug(slug): query
        +getUrlAttribute(): string
    }

    class Utilisateur {
        +id: integer
        +nom: string
        +courriel: string
        +mot_de_passe: hashed
        +role: enum
        +photo: string
        +created_at: timestamp
        +updated_at: timestamp
        +getAuthPassword(): string
        +scopeAdministrateurs(): query
    }

    class AccueilController {
        +index(): view
    }

    class CategorieController {
        // Méthodes à définir
    }

    class LivreController {
        // Méthodes à définir
    }

    class AuthController {
        // Méthodes d'authentification
    }

    Categorie ||--o{ Livre : "1..*"
    Livre }o--|| Categorie : "1"

    AccueilController --> Categorie : utilise
    AccueilController --> Livre : utilise
    AccueilController --> Utilisateur : utilise

    CategorieController --> Categorie : gère
    LivreController --> Livre : gère
    AuthController --> Utilisateur : gère
```</content>
<parameter name="filePath">/workspaces/bts-sio-slam-seance/diagramme_uml.md