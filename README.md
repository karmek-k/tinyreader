# TinyReader

## Installation

### Docker Compose

Build and launch docker-compose:

```
docker-compose up
```

You are not able right now to use the database, as there are no tables.
Migrate the database using the `init_db.sh` script **while `docker-compose` is running**:

```
chmod +x init_db.sh
./init_db.sh
```

Create a user:

```bash
chmod +x create_user.sh

# normal user
./create_user.sh

# admin user
./create_user.sh -a
```

Now you should be able to see the login page at `http://localhost:8000`.

<!-- ### Docker without Compose (PHP-FPM)

Create a container:

```
docker create --name tr -v "tr_data:/app/var" -p "9000:9000" karmekk/tinyreader
```

This command has created a TinyReader server with PHP-FPM running at port 9000.
Now launch the container:

```
docker start tr
```

And now you have to apply migrations
and let the container user use the database.

```
docker exec tr bash -c "php bin/console doctrine:database:create \
                     && php bin/console doctrine:migrations:migrate -n \
                     && chmod -R 777 /app/var"
```

Create a new user:

```bash
# normal user
docker exec -it tr bash -c "php bin/console tr:user:create"

# admin user
docker exec -it tr bash -c "php bin/console tr:user:create -a"
```

After that, you have to use a FastCGI proxy like [nginx](https://www.nginx.com/).
There is an example configuration file in `server/tinyreader.conf`. -->
