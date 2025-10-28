set -e

cd app

mkdir -p public/uploads

sudo chown -R 33:33 public/uploads
sudo chmod -R 775 public/uploads

docker compose down
docker compose up $1 $2

cd ..
