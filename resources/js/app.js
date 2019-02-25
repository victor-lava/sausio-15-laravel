
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import API from "./classes/Api.js";
import Checker from "./classes/Checker.js";

window.table = document.querySelector('.table');
window.api = new API(window.table);
window.checker = new Checker(window.table, window.api);
