export default class API {

      constructor(table) {
         this.table = table;
         this.game_hash = table.dataset.hash;
         this.auth_hash = table.dataset.auth;
         this.url = table.dataset.api;
         this.pusher_key = 'a4784a4451c0de4372ac';
         this.pusher = this.initPusher();

         this.channel = this.createChannel('my-event', function(data) {
           // alert(data);
         });
         // console.log(this.pusher);
      }

      initPusher() {
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher(this.pusher_key, {
          cluster: 'eu',
          forceTLS: true
        });

        return pusher;
      }

      createChannel(name, callback) {
        let channel = this.pusher.subscribe(this.game_hash);
        channel.bind(name, callback());
        return channel;
      }



      joinGame(color, callback) {
        axios.get(`${this.url}/game/join`, {
          params: {
            color: color,
            auth_hash: this.auth_hash,
            game_hash: this.game_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

      leaveGame(color, callback) {
        axios.get(`${this.url}/game/leave`, {
          params: {
            color: color,
            auth_hash: this.auth_hash,
            game_hash: this.game_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

      getMoves(location, callback) {
        axios.get(`${this.url}/checker/moves`, {
          params: {
            x: location.x,
            y: location.y,
            game_hash: this.game_hash,
            auth_hash: this.auth_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

      moveChecker(data, callback) {
        axios.get(`${this.url}/checker/move`, {
          params: {
            x1: data.from.x,
            y1: data.from.y,
            x2: data.to.x,
            y2: data.to.y,
            fight: data.fight,
            game_hash: this.game_hash,
            auth_hash: this.auth_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

}
