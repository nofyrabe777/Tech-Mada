# Commande pour php spark migration et php spark db:serve
Avoir une base de donné avec aucune table de préférence <br>
Éxecutez ces commandes dans le terminal dans la racine du projet
```bash
php spark make:migration CreateChose
#exemple: voici la création de la migration CreateTypesConge pour la table types_conges
php spark make:migration CreateTypesConge


#lister les migrations créer
php spark migrate:status

# rollback d'une migration créer : cela permet de modifier le dernier fichier dans app/Database/Migrations/ tu le modifie et puis php spark migrate et c'est bon 
php spark migrate:rollback
# toi:modifier les fichier que tu désire puis
php spark migrate:refresh
# rollback total  relance de toute les migrations
# la même chose que la commande précédente 
php spark migrate:refresh && php spark db:seed MainSeeder # il rafraichit tout après les modifs des tables et insert automatiquement les donnée que tu as introduite par 
php spark db:seed

#lancement pour transformer les fichier php en tables mysql après modifier les fichier dans App/Database/Migrations
php spark migrate


# creation des donnés de test 
php spark make:seeder MainSeeder #fichier apparu dans App/Database/Seeds
# pour inserer les donnés de test faites maintenant 
php spark db:seed MainSeeder

#changement de base: 
php spark migrate:refresh --seed
php spark migrate:rollback -b 0
```
avant le lancement tu dois voir et éditer les fichiers créer dans App\Database\Migrations il porterons le nom de chaque<br>
php spark make:migration CreateDepartemens par exemple<br>
ne modifie pas directement la base sinon TOUT FOUT LE CAMP IDIOT