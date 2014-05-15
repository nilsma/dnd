/**
 * A function to remove a member from a given campaign
 */
function removeMember() {
    var className = 'char-name';
    getRemoveName(className, this, function(name) {
	initRemoveMember(name, function() {
	    location.reload();
	});
    });
}

/**
 * A function to remove a given character's membership to the gamemaster's campaign
 * @param name string - the name of the character to remove
 * @param callback callback - the callback to send to the calling function 
 * @return callback name - sends an empty callback to the calling function
 */
function initRemoveMember(name, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    callback();
        }
    }

    var param = "name=".concat(name);
    xmlhttp.open("POST", "../../application/controllers/remove-member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

/**
 * A function to remove an invitation from the database
 */
function removeInvite() {
    var className = 'char-name';
    getRemoveName(className, this, function(name) {
	initRemoveInvitation(name, function() {
	    location.reload();
	});
    });
}

/**
 * A function to get the name of the member to remove upon clicking the given member's remove button
 * @param className string - the class name of the elements holding the character's name
 * @param element HTMLElement - the character's HTMLButtonElement that is clicked
 * @param callback callback - the callback to send to the calling function 
 * @return callback name - sends a callback with the character's name
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
 * A function to remove a given character's invitation to the gamemaster's campaign
 * @param name string - the name of the character of which to remove invitation
 * @param callback callback - the callback to send to the calling function 
 * @return callback name - sends an empty callback to the calling function
 */
function initRemoveInvitation(name, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    callback();
        }
    }

    var param = "name=".concat(name);
    xmlhttp.open("POST", "../../application/controllers/gamemaster-remove-invitation.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

/**
 * A function to add eventlistener to the given elements
 * @param els array - an array of elements of which to add listener to
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
    //add listener to the remove invitation buttons
    var els = new Array();
    var els = document.getElementsByClassName('remove-inv');
    addListeners(els, removeInvite);

    //add listener to the remove member button
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