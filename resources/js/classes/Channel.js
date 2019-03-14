export default class Channel {

      constructor(channelName) {
         this.url = process.env.MIX_API_URL;
         this.pusher_key = process.env.MIX_PUSHER_APP_KEY;

         this.channelName = channelName;
         this.pusher = this.init();
         this.channel = this.subscribe();
      }

      init() {
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher(this.pusher_key, {
          cluster: 'eu',
          forceTLS: true
        });

        return pusher;
      }

      subscribe() {
        return this.pusher.subscribe(this.channelName);
      }

}
