/**
 * A function to load a gamemaster upon click 
 */
function loadGamemaster() {
    getGamemasterAlias(this, function(result) {
        initLoadGamemaster(result);
    });
}

/**                                                                                                                                    
 * A function to get the name of the gamemaster clicked
 * @param element HTMLElement - the clicked HTML element representing the gamemaster
 * @return name callback - the name of the gamemaster that has been clicked
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
    var els = document.getElementsByClassName('gamemaster-entry');
    addListeners(els, loadGamemaster);
}

/**
 * Load init functions on window load
 */
window.onload = function() {
    init();
}