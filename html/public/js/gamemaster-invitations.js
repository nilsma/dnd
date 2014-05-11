/**
 * A function to remove a member from a given campaign
 */
function removeMember() {
    var className = 'char-name';
    getRemoveName(className, this, function(name) {
	initRemoveMember(name);
    });
}

/**
 * A function to initiate the removal of a given character's sheet from the campaign
 * @param name string - the name of the character to remove
 */
function initRemoveMember(name) {
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
    xmlhttp.open("POST", "../../application/controllers/remove-member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

/**
 * A function to remove an invite from the database
 */
function removeInvite() {
    var className = 'char-name';
    getRemoveName(className, this, function(name) {
	initRemoveInvitation(name);
	location.reload();
    });
}

/**
 * A function to get the name of the member to remove
 * upon clicking the given members HTML-element button
 * @param element HTMLElement - the section current-member element holding the character's name
 * @param callback callback
 * @return callback name - return the charcter's name
 */
function getRemoveName(className, element, callback) {
    var name;
    var nodes = element.parentNode.getElementsByTagName('span');
    for(var i = 0; i < nodes.length; i++) {
	if(nodes[i].className === className) {
	    name = nodes[i].innerHTML
	}
    }
	
    callback(name);
}

/**
 * A function to initiate the removal of a given characters name from invitations
 * @param name string - the name of the character to remove
 */
function initRemoveInvitation(name) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
        }
    }

    var param = "name=".concat(name);
    xmlhttp.open("POST", "../../application/controllers/gamemaster-remove-invitation.php", true);
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
    var els = document.getElementsByClassName('remove-inv');
    addListeners(els, removeInvite);

    //add listeners to the remove invitation button
    var els = new Array();
    var els = document.getElementsByClassName('remove-member');
    addListeners(els, removeMember);

}

/**
 * Load init functions on window load
 */
window.onload = function() {
    init();
}