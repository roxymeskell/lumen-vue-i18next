# Lumen + Vue + i18next

```mermaid
erDiagram

  i18n {
    int id PK
    string key UK
  }
  locale {
    int id PK
    string key UK
  }
  translation {
    int i18n_id PK, FK
    int locale_id PK, FK
    int namespace_id PK, FK "nullable"
    string content
  }

  namespace {
    int id PK
    string key UK
  }

  i18n ||--o{ translation : has
  locale ||--o{ translation : has
  namespace |o--o{ translation : has
```

## Using devcontainer
```bash
composer create-project --prefer-dist laravel/lumen backend # Create new Lumen project
npm create vite@latest frontend -- --template vue-ts # Create new Vue project
```

