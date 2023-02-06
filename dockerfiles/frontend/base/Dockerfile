FROM node:14.10.1-alpine

# Change this line and commit to repo to trigger base container pipeline build

# create destination directory
RUN mkdir -p /usr/src/nuxt-app
WORKDIR /usr/src/nuxt-app

# update and install dependency
RUN apk update && apk upgrade
RUN apk add git
RUN apk add openssh-client

# copy in the red6 build chain sshkey so we can git pull the game-core and ui
# Add ssh private key into container
ARG SSH_PRIVATE_KEY
RUN mkdir ~/.ssh/
RUN (umask  077 ; echo $SSH_PRIVATE_KEY | base64 -d > ~/.ssh/id_rsa)
RUN chmod 600 ~/.ssh/id_rsa
RUN ssh-keyscan bitbucket.org >> ~/.ssh/known_hosts
RUN echo "$SSH_PRIVATE_KEY"

# copy the app, note .dockerignore
COPY src/client/ /usr/src/nuxt-app/

RUN npm install && \ 
    npm update red6six-game-ui && \
    npm audit fix