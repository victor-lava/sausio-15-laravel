export default class API {

      constructor(table) {
         this.table = table;
         this.game_hash = table.dataset.hash;
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

      getMoves(x, y, callback) {
        axios.get(`${this.url}/checker/moves`, {
          params: {
            x, y,
            game_hash: this.game_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

      moveChecker(data, callback) {
        axios.get(`${this.url}/checker/move`, {
          params: {
            x1: data.x1,
            y1: data.y1,
            x2: data.x2,
            y2: data.y2,
            fight: data.fight,
            game_hash: this.game_hash
          }
        }).then(function(response) {
          callback(response.data);
        }).catch(function(error) {

        });
      }

}
