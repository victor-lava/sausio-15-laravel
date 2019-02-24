export default class API {

      constructor(table) {
         this.table = table;
         this.game_hash = table.dataset.hash;
         this.url = table.dataset.api;
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

}
