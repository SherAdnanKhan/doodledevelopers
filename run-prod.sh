#!/bin/bash
echo "# Clearing old shit"
docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)
docker system prune -a
# do a check here to see if the volume exists
# docker volume ls | grep app-storage
echo "# Starting v1 container from docker hub"
docker-compose -f run-prod.yaml up -d

