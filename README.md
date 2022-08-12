![Library logo](documentation/readme-assets/logo.png)

**Decoupling front-end React JS and Symfony back-end API.**

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/20133568815940b4b8fb23ea31f04f6e)](https://www.codacy.com/gl/phil-all/shopping-list/dashboard?utm_source=gitlab.com&utm_medium=referral&utm_content=phil-all/shopping-list&utm_campaign=Badge_Grade)

* * *

## :tada: Getting started

### Prerequisites

To be installed, and used, this project requires:

-   git
-   composer
-   npm
-   yarn
-   docker-compose

### Global Arhitecture

![Library architecture](documentation/readme-assets/architecture.png)

### Installation

First, clone project repository.

```bash
git clone git@gitlab.com:phil-all/boilerplate-symfonyreact.git <your_project_name>
```

#### Docker environment

Launch docker root project:

```bash
docker-compose build && docker-compose up -d
```

#### Symfony API

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

#### React fornt app

##### Initialisation

All front bash commands will be made from front directory.

yarn is executed when node container is launch.

Front app is accessible from 127.0.0.1:3000

#### Database

Database port is 5432.

Pgadmin is accessible from 127.0.0.1:8732

| user | user mail       | password |
| ---- | --------------- | -------- |
| user | user@boiler.com | pass     |

* * *

## :wrench: Configuration

### Environments

#### API Symfony

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

**Demo users**

| username          | password |
| ----------------- | -------- |
| user1@example.com | pass1234 |
| user2@example.com | pass1234 |

* * *

## Gitlab-CI

For now, only APi is in gitlab-ci pipeline.

![gitlab-ci](documentation/readme-assets/gitlab-ci.png)

* * *

## :white_check_mark: Tests

### API tests

**Unit tests**

Made with phpunit.
More details soon...

**Functionnal tests**

Made with newman/postman.
More details soon...

* * *

## Makefile commands

### API makefile

Make commands will be alvailable soon...
