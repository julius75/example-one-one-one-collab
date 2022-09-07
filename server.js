//Server for nodejs listens to the different device integration parameters
const server = require('http').Server();

let io = require('socket.io')(server);

let Redis = require('ioredis');
let redis = new Redis();

redis.subscribe('integration-channel');

redis.on('message', (channel, message) => {
    message = JSON.parse(message);
    io.emit(`${channel}:${message.event}`, message.data);

    console.log(`${channel}:${message.event}`);
});

server.listen(3000);