#!/bin/bash
docker stop $(docker ps -a -q) && docker rm $(docker ps -a -q)
docker system prune -a

docker-compose -f docker-compose.yaml up -d
