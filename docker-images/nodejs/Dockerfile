FROM node:boron

RUN mkdir -p /usr/src/nodejs
WORKDIR /usr/src/nodejs

COPY app/package.json /usr/src/nodejs
RUN npm i

COPY app /usr/src/nodejs

EXPOSE 8080
CMD [ "npm", "start" ]
