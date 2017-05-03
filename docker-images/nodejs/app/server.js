const app = require('express')
const http = require('http')

var server = http.createServer(app)
var io = require('socket.io')(server)

var mongo = require('mongodb').MongoClient
var { ObjectID } = require('mongodb')
var client = require('socket.io').listen(8080).sockets

const CHATS_URL = 'mongodb://mongo:27017/chats'

mongo.connect(CHATS_URL, function (err, db) {
  if (err) throw err

  client.on('connection', function (socket) {

    socket.on('join room', function ({ chatID, userID }) {
      socket.join(chatID)
      var chatRoom = db.collection(chatID)
      chatRoom.find().sort([['_id', -1]]).limit(100).toArray(function (err, history) {
        if (err) throw err

        socket.emit('message history', { chatID, history })
        // console.log('User ' + userID + ' joined chatroom ' + chatID, ', history: ' + JSON.stringify(history, null, 2))
      })
    })

    socket.on('send message', function ({ chatID, dialog }) {
      var chatRoom = db.collection(chatID)
      chatRoom.insert(dialog, function (err, o) {
        if (err) { console.warn(err.content) }
        socket.broadcast.to(chatID).emit('receive message', { chatID, dialog })
      })
    })

    socket.on('make decision', function ({ chatID, dialogID, dialog }) {
      var chatRoom = db.collection(chatID)
      console.log('make decision: ', dialogID, dialog)
      var o_id = new ObjectID(dialogID);
      console.log('o_id', o_id)
      chatRoom.findOneAndUpdate({_id: o_id}, {$set: dialog}, { returnOriginal: false }, function (err, r) {
        console.log('written: ', r)
        socket.broadcast.to(chatID).emit('made decision', { chatID, dialogID, o_id, dialog})
      })
    })

    socket.on('disconnect', function () {
      console.log('User disconnected')
    })
  })
})