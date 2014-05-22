/**
 * A function to toggle the visibility of the sub-nav-wrapper element 
 */
function toggleSubnav() {
    hideMainnav();
    var el = document.getElementById('sub-nav-wrapper');
    if(window.getComputedStyle(el, null).getPropertyValue('display') === 'none') {    
	el.style.display='flex';
    } else {
	el.style.display='none';
    }
}

/**
 * A function to hide the main navigation li entries
 */
function hideMainnav() {
    var els = document.getElementsByClassName('main-nav-entry');
    for(var i = 0; i < els.length; i++) {
	if(parseInt(window.getComputedStyle(els[i], null).getPropertyValue('opacity')) === 0) {
	    els[i].style.opacity=1;
	} else {
	    els[i].style.opacity=0.2;
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