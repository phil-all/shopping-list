# Boiler plate: Symfony / React

**Decoupling front-end React JS with Symfony back-end API boiler plate.**

![Library logo](documentation/readme-assets/logo.png)

* * *

## :tada: Getting started

### Prerequisites

To be installed, and used, this project requires:

-   git
-   composer
-   npm
-   yarn
-   docker-compose

### Installation

First, clone project repository.

```bash
git clone git@gitlab.com:phil-all/boilerplate-symfonyreact.git <your_project_name>
```

#### Symfony API

From apps/back directory:

```bash
composer install
```

API is accessible from 127.0.0.1:8700

#### React fornt app

From apps/front directory:

```bash
npm install
yarn install
```

Fornt app is accessible from 127.0.0.1:3000

#### Database

Database port is 5432.

Pgadmin is accessible from 127.0.0.1:8732

| user | user mail       | password |
| ---- | --------------- | -------- |
| user | user@boiler.com | pass     |

### Global Arhitecture

![Library architecture](documentation/readme-assets/architecture.png)

### Folder stucture

```bash
└── boilerPlate-SymfonyReact/
    │
    ├── apps/
    │   ├── back/      # Symfony API
    │   ├── database/  # Postgres & Pgadmin
    │   ├── front/     # React front app
    │   └── nginx/     # Nginx
    │
    ├── documentation/ # your project documentation
    │   ├── readme-assets/  # your readme assets
    │   └── specifications/ # your project specifications
    │
    └── docker-compose.yaml
```
