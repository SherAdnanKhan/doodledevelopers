FROM red6sixacr.azurecr.io/frontend-base:BUILD_NO_FRONTEND_BASE

COPY src/client/env.prod /usr/src/nuxt-app/.env

# build necessary, even if no static files are needed,
# since it builds the server as well
RUN npm run build

# expose 5000 on container
EXPOSE 3000

# set app serving to permissive / assigned
ENV NUXT_HOST=0.0.0.0
# set app port
ENV NUXT_PORT=3000

# start the app
CMD [ "npm", "start" ]
