const app = require('express')
const http = require('http')

var server = http.createServer(app)
var io = require('socket.io')(server)

var mongo = require('mongodb').MongoClient
var client = require('socket.io').listen(8080).sockets

const CHATS_URL = 'mongodb://mongo:27017/chats'

// function createRoom (db, room) {
//   db.
// }

mongo.connect(CHATS_URL, function (err, db) {
  if (err) throw err

  client.on('connection', function (socket) {
    // var col = db.collection('messages')
    console.log('User connected')

    socket.on('join room', function ({ chatID, userID }) {
      socket.join(chatID)
      var chatRoom = db.collection(chatID)
      chatRoom.find().limit(100).toArray(function (err, history) {
        if (err) throw err

        socket.emit('message history', history)
        console.log('User ' + userID + ' joined chatroom ' + chatID)
      })
    })

    socket.on('send message', function ({ chatID, senderID, content }) {
      console.log('chat: ', chatID)
      var chatRoom = db.collection(chatID)
      chatRoom.insert({ chatID, senderID, content }, function(err, o) {
        if (err) { console.warn(err.content) }
        socket.broadcast.to(chatID).emit('receive message', { senderID, content })
        // socket.emit('receive message', { senderID, content })
        console.log('User ' + senderID + ' sent message: ' + content)
      })
    })

    socket.on('disconnect', function () {
      console.log('User disconnected')
    })
  })
})