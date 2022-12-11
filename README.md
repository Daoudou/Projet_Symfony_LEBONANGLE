## Start
J'utilise Docker et adminer pour la Base de donnee.

1 - Creer la Base de donnee a l'aide de l'invite de commande avec les commande :
    - symfony console doctrine:database:create
    -  symfony console doctrine:schema:create


## Admin :
1 Creer un utiliseur dans la bdd, pour crypter le mot de passe utiliser la commande sercurity:hash-password


## Test
l faut faire les commandes suivantes :
```shell
symfony console doctrine:database:create --env=test
symfony console doctrine:schema:create --env=test
