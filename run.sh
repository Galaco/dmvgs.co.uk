
# docker stop dmvgs_mysql
# docker stop dmvgs_web

# docker rm dmvgs_mysql
# docker rm dmvgs_web

# build
# docker-compose -f docker/development.yml build
# run
# docker-compose -f docker/development.yml up -d

# install dependencies
docker-compose exec dmvgs_web composer install
docker-compose exec dmvgs_mysql ./tmp/init.sh
docker-compose exec dmvgs_web vendor/bin/phinx migrate
docker-compose exec dmvgs_mysql ./tmp/seed.sh

