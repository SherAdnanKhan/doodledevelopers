#!/bin/bash
VER=1.0

rm -rf src/client/node_modules
rm src/client/package-lock.json

echo "###############################"
echo "Building new RED6-FE container"
echo "###############################"
docker build --build-arg SSH_PRIVATE_KEY="$(cat ~/.ssh/id_rsa)" -t red6-fe -f dockerfiles/client.prod .

echo "#"
echo "# re-tag it as a release locally as doodlelabsuk/red6-fe:v$VER"
echo "#"
docker tag red6-fe:latest doodlelabsuk/red6-fe:v$VER

echo "#"
echo "# push the new tagged container to dockerhub"
echo "#"
docker push doodlelabsuk/red6-fe:v$VER


