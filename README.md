![Library logo](documentation/readme-assets/logo.png)

**Decoupling front-end React JS and Symfony back-end API.**

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/20133568815940b4b8fb23ea31f04f6e)](https://www.codacy.com/gl/phil-all/shopping-list/dashboard?utm_source=gitlab.com&utm_medium=referral&utm_content=phil-all/shopping-list&utm_campaign=Badge_Grade)

* * *

## <a name='Tableofcontent'></a>Table of content

1.  [:tada: Getting started](#tada:Gettingstarted)
    -   1.1. [Prerequisites](#Prerequisites)
    -   1.2. [Global Arhitecture](#GlobalArhitecture)
    -   1.3. [Installation](#Installation)

2.  [:wrench: Configuration](#wrench:Configuration)
    -   2.1. [Environments](#Environments)

3.  [:construction_worker: Gitlab-CI](#construction_worker:Gitlab-CI)

4.  [:white_check_mark: Tests](#white_check_mark:Tests)
    -   4.1. [API tests](#APItests)
    -   4.2. [Front tests](#Fronttests)

5.  [:hammer: Makefile commands](#Makefilecommands)
    -   5.1. [Project makefile](#ProjectMAkefile)
    -   5.2. [API makefile](#APImakefile)

6.  [:sparkles: Features](#sparkles:Features)

* * *

## <a name='tada:Gettingstarted'></a>1. :tada: Getting started

### <a name='Prerequisites'></a>1.1. Prerequisites

To be installed, and used, this project requires:

-   git
-   composer
-   npm
-   yarn
-   docker-compose

### <a name='GlobalArhitecture'></a>1.2. Global Arhitecture

![Library architecture](documentation/readme-assets/architecture.png)

### <a name='Installation'></a>1.3. Installation

First, clone project repository.

```bash
git clone git@gitlab.com:phil-all/boilerplate-symfonyreact.git <your_project_name>
```

#### <a name='Dockerenvironment'></a>1.3.1. Docker environment

Launch docker root project:

```bash
docker-compose build && docker-compose up -d
```

#### <a name='SymfonyAPI'></a>1.3.2. Symfony API

##### initialisation

All API bash commands will be made from api directory.

Install composer packages:

```bash
# from ./apps/api
composer install
```

Generate SSL keys for JWT authentication:

```bash
# from ./apps/api
php bin/console lexik:jwt:generate-keypair
```

Create a .env.local file, and move in **JWT_PASSPHRASE** from .env file:

##### API endpoints

| url                    | description               |
| ---------------------- | ------------------------- |
| 127.0.0.1:8700/docs    | API swagger documentation |
| 127.0.0.1:8700/api/... | API endpoints             |

#### <a name='Reactforntapp'></a>1.3.3. React fornt app

Lauch node server :

```bash
# from root directory
make front
```

#### <a name='Database'></a>1.3.4. Database

Database port is 5432.

Pgadmin is accessible from 127.0.0.1:8732

| user | user mail       | password |
| ---- | --------------- | -------- |
| user | user@boiler.com | pass     |

* * *

## <a name='wrench:Configuration'></a>2. :wrench: Configuration

### <a name='Environments'></a>2.1. Environments

#### <a name='APISymfony'></a>2.1.1. API Symfony

**Developpement**
Set your own variables in a .env.local file, it would override .env file if needed.

A makefile is provide

**Test**
As for env.local, copy your JWT_PASSPHRASE in env.test.local

**Datas transaction and rollback in phpunit tests**
To ensure each test to be isolated regarding database actions, and be performed as many times as necessary, without other test side effect, be sure dama/doctrine-test-bundle is well configured.

```yaml
# ./config/packages/test/dama_doctrine_test
dama_doctrine_test:
    enable_static_connection: true
    enable_static_meta_data_cache: true
    enable_static_query_cache: true
```

```xml
<!-- ./phpunit.xml.dist -->

...
    <extensions>
        <extension class="DAMA\DoctrineTestBundle\PHPUnit\PHPUnitExtension" />
    </extensions>
</phpunit>
```

#### <a name='Demousers'></a>2.1.2. Demo users

| username          | password |
| ----------------- | -------- |
| user1@example.com | pass1234 |
| user2@example.com | pass1234 |

* * *

## <a name='construction_worker:Gitlab-CI'></a>3. :construction_worker: Gitlab-CI

Two pipelines are available:

-   one for API

![gitlab-ci](documentation/readme-assets/gitlab-ci.png)

-   one for Front app

* * *

## <a name='white_check_mark:Tests'></a>4. :white_check_mark: Tests

### <a name='APItests'></a>4.1. API tests

**Unit tests**

Unit tests are made with phpunit. Use make file:

```bash
# from ./apps/api/
make unit
```

**Endpoint tests**

Endpoint tests are made with newman/postman. Use make file:

```bash
# from ./apps/api/
make endpoint
```

### <a name='Fronttests'></a>4.2. Front tests

```bash
# from ./ apps/front/
yarn run test
```

* * *

## <a name='hammer:Makefilecommands'></a>5. :hammer: Makefile commands

### <a name='Projectmakefile'></a>5.1 Project makefile

From root, run make follwed by:

```code
 —— Commands list 🛠️️ ————————————————————————————————————————————————————————— 
help                           Outputs this help screen
 —— Docker 🐳 ———————————————————————————————————————————————————————————————— 
down                           Stop the docker hub
rm                             Remove the docker hub
start                          Build and start the containers (no logs)
restart                        Restart the docker hub
logs                           Show live logs
status                         Docker hub status
 —— Git 🔀 ——————————————————————————————————————————————————————————————————— 
reset                          Reset last commit on local
 —— Front app 💻 ————————————————————————————————————————————————————————————— 
front                          start front app node server
api                            Connect to the api bash
pgsql                          Connect to postgres bash
```

### <a name='APImakefile'></a>5.2. API makefile

From api directory (./apps/api/), run make followed by:

```code
 —— Commands list 🛠️️ ————————————————————————————————————————————————————————— 
help                           Outputs this help screen
 —— Composer 🧙 —————————————————————————————————————————————————————————————— 
dump-opt                       Optimize autoloading
install-vendor                 Remove and reinstall vendor
vendor-up                      Remove, reinstall and update vendor
 —— Symfony 🎵 ——————————————————————————————————————————————————————————————— 
sf                             List all Symfony commands or pass the parameter "c=" to run a given command, example: make sf c=about
cc                             Clear the cache
user                           Create Symfony user
entity                         Create Symfony entity
migration                      Create Symfony migrations
router                         Display routing
entity                         Create Symfony entity
test                           Create Symfony test
fixtures                       Create Symfony fixtures
 —— Grumphp 😡 ——————————————————————————————————————————————————————————————— 
grum                           Run grumphp tests
 —— Database 🛢️ —————————————————————————————————————————————————————————————— 
drop                           Drop database
create                         Create database
migrate                        Migrations migrate
drop-test                      Drop test database
create-test                    Create test database
migrate-test                   Migrations migrate for test
 —— Fixtures 🤡 —————————————————————————————————————————————————————————————— 
db                             Reset databases (dev and test) and load fixtures
 —— Tests ✅ ————————————————————————————————————————————————————————————————— 
unit                           Run unit tests only
endpoint                       Run end points tests only
 —— permissions 🛂 ——————————————————————————————————————————————————————————— 
perm                           change api owner and group
```

* * *

## <a name='sparkles:Features'></a>6. :sparkles: Features

| user feature   | is done            |
| -------------- | ------------------ |
| registration   |                    |
| authentication | :heavy_check_mark: |
| management     |                    |

| shopping-list feature | is done            |
| --------------------- | ------------------ |
| login                 | :heavy_check_mark: |
| products              | :heavy_check_mark: |
| departments           | :heavy_check_mark: |
| shopping list         |                    |
| search                |                    |
