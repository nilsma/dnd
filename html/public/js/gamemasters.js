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
 * A function to load a gamemaster when clicked in the gamemasters overview view
 */
function loadGamemaster() {
    getGamemasterAlias(this, function(result) {
        initLoadGamemaster(result);
    });
}

/**                                                                                                                                    
 * A function to get the name of the gamemaster clicked in the gamemasteres overview view
 * @param element HTMLElement - the clicked HTML element representing the gamemaster
 * @param callback callback - the callback to send to the calling function
 * @return alias callback - the alias of the gamemaster that has been clicked
 */
function getGamemasterAlias(element, callback) {
    var alias = element.getElementsByClassName('gamemaster-entry-alias')[0].innerHTML;
    callback(alias);
}

/**
 * A function to load a gamemaster for the user and set the view to that gamemaster
 * @param alias string - the alias of the gamemaster to load
 */
function initLoadGamemaster(alias) {
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

    var param = "alias=".concat(alias);
    xmlhttp.open("POST", "../../application/controllers/load-gamemaster.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

/**
 * A function to add a given eventlistener to the elements in the given array
 * @param els array - an array of elements of which to add the listener to
 * @param fnc function - the function name of which to trigger when the given element is clicked
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
    //add listeners to load the clicked gamemaster in the gamemasters overview
    var els = new Array();
    var els = document.getElementsByClassName('gamemaster-entry');
    addListeners(els, loadGamemaster);

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