docker compose down

sudo rm -rf mariadb/mariadb-data/
sudo rm -rf app/public/uploads/

./docker-compose-start.sh -d
