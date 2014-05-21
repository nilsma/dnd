/**
 * A function to toggle the visibility of the sub-nav-wrapper element 
 */
function toggleSubnav() {
    var el = document.getElementById('sub-nav-wrapper');
    if(window.getComputedStyle(el, null).getPropertyValue('visibility') === 'hidden') {    
	el.style.visibility='initial';
    } else {
	el.style.visibility='hidden';
    }
    toggleMainnav();
}

function toggleMainnav() {
    var navs = document.getElementsByClassName('main-nav');
    for(var i = 0; i < navs.length; i++) {
	navs[i].style.opacity=0.1;
	if(window.getComputedStyle(el, null).getPropertyValue('opacity') === 1) {    
	    el.style.opacity=0.1;
	} else {
	    el.style.opacity=1;
	}
    }
}

/**
 * A function to load a character upon click
 */
function loadCharacter() {
    getCharacterName(this, function(result) {
	initLoadCharacter(result);
    });
}

/**
 * A function to load a character for the user and set the view to that character
 * @param name string - the name of the character to load
 */
function initLoadCharacter(name) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    location.reload();
        }
    }

    var param = "name=".concat(name);
    xmlhttp.open("POST", "../../application/controllers/load-character.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

/**
 * A function to get the name of the character clicked
 * @param element HTMLElement - the clicked HTML element representing the character
 * @return name callback - the name of the character that has been clicked
 */
function getCharacterName(element, callback) {
    var name = element.getElementsByClassName('char-name')[0].innerHTML;
    callback(name);
}

/**
 * A function to add eventlisteners to the stated elements
 * @param els array - an array of elements of which to add listeners to
 * @param fnc function - the function name of which to trigger when the element is clicked
 */
function addListeners(els, fnc) {
    for(var i = 0; i < els.length; i++) {
	els[i].addEventListener('click', fnc, false);
    }
}

/**
 * A function to initialize functions on load
 */
function init() {
    //add listeners to the remove invitation button
    var els = new Array();
    var els = document.getElementsByClassName('character');
    addListeners(els, loadCharacter);

    //add listener to the toggle sub-nav link
    var els = new Array()
    var el = document.getElementById('sub-nav-init');
    els.push(el);
    addListeners(els, toggleSubnav);
}

/**
 * Load init functions on window load
 */
window.onload = function() {
    init();
}