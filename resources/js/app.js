
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// import Point from "./classes/Point.js";
import API from "./classes/Api.js";
import Checker from "./classes/Checker.js";
import Game from "./classes/Game.js";
import Channel from "./classes/Channel.js";
import GameList from "./classes/GameList.js";

window.table = document.querySelector('#checkers');
window.api = new API(window.table);
window.checker = new Checker(window.table, window.api);
window.game = new Game(window.api);
// window.point = new Point();
