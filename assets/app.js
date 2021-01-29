/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './app.js';

// start the Stimulus application

// import './bootstrap';

// start the Stimulus application

const $ = require('jquery');  // il faut que jquery soit appelé avant bootstrap
require('bootstrap');

window.addEventListener("load", function(){
//PAGE D'ACCUEIL :

// MENU BURGER :

var burger = document.getElementById('burger');
var menu = document.getElementById('menu');

console.log(burger);
console.log(menu);

burger.addEventListener('click', apparitionMenu);
function apparitionMenu() {

if (menu.style.display == 'null') {

menu.style.display = 'none';

burger.src = 'img/burger.png';
 	} else {
 		menu.style.display = 'block';
		burger.src = 'img/close.png';
	}
}

//FAIRE DISPARAITRE LE SLOGAN QUAND LE MENU BURGER EST CLIQUÉ :

var slogan=document.getElementById('slogan');

burger.addEventListener('click',disparitionSlogan);
function disparitionSlogan(){
  console.log('la fonction se déclanche');

 if (menu.style.display === 'block'){

  slogan.style.display='none';
 } else{
  menu.style.display === 'none';
  slogan.style.display='block';
 }

}

// MODIFIER LE NOMBRE DE CONVIVES DYNAMIQUEMENT SUR PAGE RESERVATION :

  var nbConvive = document.getElementById('nbConvive');
  console.log(nbConvive);

  var paragraphe = document.getElementById('paragraphe');
  console.log(paragraphe);

  nbConvive.addEventListener('input', changeNbConvive);
  function changeNbConvive() {
    console.log('la fonction se déclenche');
    paragraphe.innerHTML=nbConvive.value;
  }











});
