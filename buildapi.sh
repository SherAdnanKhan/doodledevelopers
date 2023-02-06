#!/bin/bash
#
# TODO: ACCEPT API/CLIENT param
#
# TODO: ACCEPT TAG e.g. Version param
#
VER=1.0

echo "#"
echo "# Building the red6-api container"
echo "#"
docker build -t red6-api -f dockerfiles/api.prod .

echo "#"
echo "# re-tag it as a release locally as doodlelabsuk/red6-api:v$VER"
echo "#"
docker tag red6-api:latest doodlelabsuk/red6-api:v$VER

echo "#"
echo "# push the new tagged container to dockerhub"
echo "#"
docker push doodlelabsuk/red6-api:v$VER


echo "###############################################################"
#echo "# DONE - run 'docker-compose -f run-prod up -d on production'
echo "# DONE - run docker run --publish 8000:80 --name red6-api red6-api "
echo "###############################################################"
