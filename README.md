![Library logo](documentation/readme-assets/logo.png)

**Decoupling front-end React JS and Symfony back-end API.**

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/20133568815940b4b8fb23ea31f04f6e)](https://www.codacy.com/gl/phil-all/shopping-list/dashboard?utm_source=gitlab.com&utm_medium=referral&utm_content=phil-all/shopping-list&utm_campaign=Badge_Grade)

* * *

## Table of content

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
    -   5.1. [API makefile](#APImakefile)

6.  [:sparkles: Features](#sparkles:Features)

* * *

## 1. :tada: Getting started

### 1.1. Prerequisites

To be installed, and used, this project requires:

-   git
-   composer
-   npm
-   yarn
-   docker-compose

### 1.2. Global Arhitecture

![Library architecture](documentation/readme-assets/architecture.png)

### 1.3. Installation

First, clone project repository.

```bash
git clone git@gitlab.com:phil-all/boilerplate-symfonyreact.git <your_project_name>
```

#### 1.3.1. Docker environment

Launch docker root project:

```bash
docker-compose build && docker-compose up -d
```

#### 1.3.2. Symfony API

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

#### 1.3.3. React fornt app

##### Initialisation

All front bash commands will be made from front directory.

yarn is executed when node container is launch.

Front app is accessible from 127.0.0.1:3000

#### 1.3.4. Database

Database port is 5432.

Pgadmin is accessible from 127.0.0.1:8732

| user | user mail       | password |
| ---- | --------------- | -------- |
| user | user@boiler.com | pass     |

* * *

## 2. :wrench: Configuration

### 2.1. Environments

#### 2.1.1. API Symfony

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

#### 2.1.2. Demo users

| username          | password |
| ----------------- | -------- |
| user1@example.com | pass1234 |
| user2@example.com | pass1234 |

* * *

## 3. :construction_worker: Gitlab-CI

Two pipelines are available:

-   one for API

![gitlab-ci](documentation/readme-assets/gitlab-ci.png)

-   one for Front app

* * *

## 4. :white_check_mark: Tests

### 4.1. API tests

**Unit tests**

Made with phpunit.

```bash
# from ./apps/api/
bin/phpunit tests/Unit --testdox
```

**Functionnal tests**

Made with newman/postman.

```bash
newman run --verbose ./postman/test-API-collection.json -e ./postman/env-gitlab.json
```

### 4.2. Front tests

```bash
# from ./ apps/front/
yarn run test
```

* * *

## 5. :hammer: Makefile commands

### 5.1. API makefile

API make commands will be alvailable soon...

* * *

## 6. :sparkles: Features

| user feature   | is done            |
| -------------- | ------------------ |
| registration   |                    |
| authentication | :heavy_check_mark: |
| management     |                    |

| shopping-list feature | is done            |
| --------------------- | ------------------ |
| login                 | :heavy_check_mark: |
| products              | :heavy_check_mark: |
| departments           |                    |
| shopping list         |                    |
| search                |                    |
