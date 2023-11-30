# le formulaire de contact V2

Formulaire avec des contraintes en back et en front,
Après soumission et validation du formulaire,
Déclenchement d'un évenement avec dispatcher pour envoyer un mail à l'admin,
log à la soumission/validaton de l'envoie du formulaire et un log à l'envoie du mail,

Petit Formulaire V2 sur la mise en place d'un évenement.

## Environnement de développement

### Pré-requis

* Symfony 6.3
* PHP 8.2
* Composer
* Symfony CLI
* nodejs et npm

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirement
```
### Lancer l'environnement de développement

bien vérifier si le fichier .env est bien dans votre environnement
Ne pas hésiter à la modifier

```bash
composer install
npm install
npm run build
symfony server:start -d
```

### Mise en place de l'envoie MAIL

Fait avec MAILtrap bien mettre son DSN dans l'.env