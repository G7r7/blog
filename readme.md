# Blog

Simple php blog.

## Database model

docs/database.txt

```shell
docker exec -i some-mariadb sh -c 'exec mysql -uroot -p"$MARIADB_ROOT_PASSWORD"' < /some/path/on/your/host/all-databases.sql
```

## Set Database connection 

includes/function_connexion_bdd.php