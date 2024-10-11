
## Gestion des assurance  : GCAVNV
#### G.C.A.V.N.V. (Gestion de Contracts d'Assurance Vie et Non Vie)

## Demo
![demos_png](public/README/assurance.png)

## 🛠 Skills
Symfony, Bootstrap, Sass, JQuery, 


## Installation required

This project need to user

```bash
  Symfony 7.*
  composer 2.*
  nodejs 20.17.0
  yarn 1.22.22
```
    
## Run Locally

Clone the project

```bash
  git clone https://github.com/Najoro/gestion_assurance.git
```

Go to the project directory

```bash
  cd gestion_assurance
```

Install dependencies

```bash
  composer install
  yarn install
  yarn dev or yarn watch
```
Configure DataBase
```bash
  configure .env 
```
```bash
  symfony console doctrine:database:create OR
  php bin/console doctrine:database:create
```
```bash
  symfony console doctrine:schema:update --force OR
  php bin/console doctrine:schema:update --force
```
Start the server

```bash
  symfony server
```

