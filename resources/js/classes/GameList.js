const listSelector = '#games';

export default class GameList {

      static getList() {
        return document.querySelector(listSelector);
      }

      static getTbody() {
        return this.getList().querySelector('tbody');
      }

      static getGames() {
        return this.getTbody().querySelectorAll('tr.game');
      }

      static add(html) {
        this.getTbody().insertAdjacentHTML('afterbegin', html);
      }

      static joined(response) {
        console.log(response);
      }



}
window.GameList = GameList;
