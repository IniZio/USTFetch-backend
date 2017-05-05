# USTFetch Backend

### Fire up:
0. Copy .env.example to .env file
1. Install [docker](https://docs.docker.com/docker-for-mac/install/)
2. Install [docker-compose](https://docs.docker.com/compose/install/)
3. `cd` into project root directory, run `docker-compose up --build`, first time will take a long time, the rest will be a matter of a few seconds

### Understand the structure:
- app/Http/Controllers/*.php: the 'C' in MVC concept of Lumen framework. ExampleController.php is the template
- app/*.php: the 'M' in MVC concept. ExampleModel.php is the template
- routes/web.php: handle requests
- app/Events/*.php: Event broadcasting, will be used for the chatroom function. ExampleEvent.php is the template
- docker-images/nodejs/server.js: express server with socket.io module for realtime chat

### Docker
- PHP: for lumen
- nginx: host the lumen framework
- nodejs: host chatroom with socket.io
- mongodb: database for lumen and chatroom