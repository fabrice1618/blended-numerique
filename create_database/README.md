# Scripts pour base de données

## suppression complète de la base de données

```
$ docker exec -it top_dbtop mysql -u root
mysql> source /root/dropdb.sql;
```

## Création de la base de données

```
$ docker exec -it top_dbtop mysql -u root
mysql> source /root/createdb.sql;
```