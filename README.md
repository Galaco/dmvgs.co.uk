# dmvgs.co.uk
Archive of dmvgs.co.uk codebase circa. July 2015


#### Running
Run the following:
```bash
docker-compose up -d
docker-compose exec web composer install
docker-compose exec database ./tmp/init.sh
docker-compose exec web vendor/bin/phinx migrate
docker-compose exec database ./tmp/seed.sh
```