# TinyReader

## Installation

### Local environment for development

You'll need:
- PHP 8.1 or newer
- Docker and Docker Compose (Docker Desktop is fine too, it installs both)

Create a `db.env` file from template and edit it:

```
cp db.example.env db.env
```

Launch Docker Compose in the background:

```
docker compose up -d
```

You are not able to use the database right now, as it has not been migrated.
Migrate the database **while `docker compose` is running in the background**:

```
php bin/console doctrine:migrations:migrate -n
```

Create a user:

```bash
# normal user
php bin/console tr:user:create

# admin user
php bin/console tr:user:create -a
```

Start the development server:

```
php bin/console serve
```

It may ask you to add some self-signed certificates.
It's necessary in order to use HTTPS locally.

Now you should be able to see the login page at `http://localhost:8000`

#### Worker process

Execute the following script:

```
php bin/console messenger:consume async --memory-limit=128M
```

This script has to be running all the time when the server is active,
otherwise asynchronous feed reloading will not work.
The script terminates when its memory usage exceeds 128M of memory,
so it is highly recommended to use a process manager
like [PM2](https://pm2.keymetrics.io/) or [Supervisor](http://supervisord.org/) to keep the worker alive.

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
