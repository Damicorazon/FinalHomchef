/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './app.js';

// start the Stimulus application
import './bootstrap';

window.addEventListener("load", function(){
//PAGE D'ACCUEIL :

// MENU BURGER :

var burger = document.getElementById('burger');
var menu = document.getElementById('menu');

console.log(burger);
console.log(menu);

burger.addEventListener('click', apparitionMenu);
function apparitionMenu() {
	console.log('La fonction se declenche !');
	console.log(menu.style.display);

if (menu.style.display === 'block') {

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



//PAGES DES CHEFS :

// SLIDER 1:


var sliderImg = document.querySelector('.slider-img');
console.log(sliderImg);

//var slidetest = document.getElementsByClassName('slider-img')[0];
//console.log(slidetest);

var images = ['menu1.jpg', 'menu2.jpg', 'menu3.jpg'];
var i = 0;

function gauche() {
  if(i <= 0 ) i = images.length;
  i--;
  return imgDefaut();
}
function droite(){
  if( i >= images.length-1) i = -1;
  i++;
  return imgDefaut();
}
function imgDefaut() {
  return sliderImg.setAttribute('src', 'img/' + images[i]);
}


// SLIDER 2:

var sliderImg2 = document.querySelector('.slider-img2');
console.log(sliderImg2);

//var slidetest = document.getElementsByClassName('slider-img')[0];
//console.log(slidetest);

var images2 = ['menu1.jpg', 'menu2.jpg', 'menu3.jpg'];
var i = 0;

function gauche2() {
  if(i <= 0 ) i = images2.length;
  i--;
  return imgDefaut2();
}
function droite2(){
  if( i >= images2.length-1) i = -1;
  i++;
  return imgDefaut2();
}
function imgDefaut2() {
  return sliderImg2.setAttribute('src', 'img/' + images2[i]);
}

// SLIDER 3:

var sliderImg3 = document.querySelector('.slider-img3');
console.log(sliderImg3);

//var slidetest = document.getElementsByClassName('slider-img')[0];
//console.log(slidetest);

var images3 = ['menu1.jpg', 'menu2.jpg', 'menu3.jpg'];
var i = 0;

function gauche3() {
  if(i <= 0 ) i = images3.length;
  i--;
  return imgDefaut3();
}
function droite3(){
  if( i >= images3.length-1) i = -1;
  i++;
  return imgDefaut3();
}
function imgDefaut3() {
  return sliderImg3.setAttribute('src', 'img/' + images3[i]);
}


// POP UP CONNEXION/INSCRIPTION :


var btnConnection = document.getElementById('connection');
console.log(btnConnection);

var btnConnection2 = document.getElementById('connection2') //RAJOUT
console.log(btnConnection2) //RAJOUT

var connection = document.getElementById('contenantConnection');
console.log(connection);

var introduction = document.getElementById('contenantIntro');
console.log(introduction);

var btnfermeConn = document.getElementsByClassName('close')[0];
console.log(btnfermeConn);

var btnfermeIntro =document.getElementsByClassName('close1')[0];
console.log(btnfermeIntro)

/***************************Pour ouvrir la page Connection en cliquant sur connection*********************************** */

btnConnection.addEventListener('click', openConn);

function openConn(){
  connection.style.display = 'flex';
}

btnConnection2.addEventListener('click', openConn2);

function openConn2(){
  connection.style.display = 'flex';
}
console.log(btnConnection2)

/***************************Pour fermer avec la croix quand la page Connection est visible*********************************** */

btnfermeConn.addEventListener('click', ferme);

function ferme(){
  connection.style.display = 'none';
}
console.log(btnfermeConn)

/***************************Pour fermer avec la croix quand la page introduction est visible*********************************** */

btnfermeIntro.addEventListener('click', ferme1);

function ferme1(){
  introduction.style.display = 'none';
}

/**********************Quand la popup s'ouvre pouvoir choisir entre inscription ou connection**************************************** */

function inscrip(){
  introduction.style.display = 'flex';
  connection.style.display = 'none';
}

function connec(){
  connection.style.display = 'flex';
  introduction.style.display = 'none';
}

// FORMULAIRE DE CONTACT :

    function validateForm()
{
    var name = document.forms["myForm"]["name"];
    var firstName = document.forms["myForm"]["firstName"];
    var email = document.forms["myForm"]["email"];
    var phoneNumber = document.forms["myForm"]["phoneNumber"];
    var message = document.forms["myForm"]["message"];

    if (name.value == "")
    {
        document.getElementById('errorname').innerHTML="Veuillez entrez un nom valide";
        name.focus();
        return false;
    }else{
        document.getElementById('errorname').innerHTML="";
    }

     if (firstName.value == "")
    {
        document.getElementById('errorfirstName').innerHTML="Veuillez entrez un prénom valide";
        firstName.focus();
        return false;
    }else{
        document.getElementById('errorfirstName').innerHTML="";
    }

    if (email.value == "")
    {
        document.getElementById('erroremail').innerHTML="Veuillez entrez une adresse mail valide";
        email.focus();
        return false;
    }else{
        document.getElementById('erroremail').innerHTML="";
    }

     if (phoneNumber.value == "")
    {
        document.getElementById('errorphoneNumber').innerHTML="Veuillez entrez un numéro de téléphone valide";
        phoneNumber.focus();
        return false;
    }else{
        document.getElementById('errorphoneNumber').innerHTML="";
    }

    if (email.value.indexOf("@", 0) < 0)
    {
        document.getElementById('erroremail').innerHTML="Veuillez entrez une adresse mail valide";
        email.focus();
        return false;
    }

    if (email.value.indexOf(".", 0) < 0)
    {
        document.getElementById('erroremail').innerHTML="Veuillez entrez une adresse mail valide";
        email.focus();
        return false;
    }

    if (message.value == "")
    {
        document.getElementById('errormsg').innerHTML="Veuillez entrez un message valide";
        message.focus();
        return false;
    }else{
        document.getElementById('errormsg').innerHTML="";
    }

    return true;
}

/**************************** COOKIES ******************************/

});