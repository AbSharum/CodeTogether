# CodeTogether
A website for CS students!

Make sure docker is installed!

After cloning create a .env file in CodeTogether/CodeTogether directory. Reach out to one of the original developers for the correct .env file

If on linux you can simply run ./docker-compose-start.sh -d --build you will need sudo privliges 

./freshDb.sh will restart the containers with a fresh database

./dbMod.sh will exec into the database container

If not on linux, all docker commands will have to be executed manually, to start up the containers run docker compose up -d --build

Additonally if not on linux make sure that the CodeTogether/CodeTogether/app/public/uploads directory exsits


The webapp follows an MVC architecture, Request -> Router -> Controller -> View 