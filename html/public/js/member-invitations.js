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
}

/**
 * A function to have a character leave a campaign
 */
function leaveCampaign() {
    var el = this.parentNode.parentNode;
    getParams(el, function(result) {
	initLeaveCampaign(result);
    });
}

function initLeaveCampaign(params) {
    var result;
    var char_name = params[1];
    var title = params[2];

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

    var p1 = "char_name=".concat(char_name);
    var p2 = "&title=".concat(title);
    var params = p1.concat(p2);
    xmlhttp.open("POST", "../../application/controllers/member-leave-campaign.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to accept a given characters related invitation in the database
 */
function acceptInvite() {
    var el = this.parentNode.parentNode;
    getParams(el, function(result) {
	initAcceptInv(result);
    });
}

/**
 * A function to initiate a query to accept a characters related invitation in the database
 * @param params array - an array holding the given invitations gamemaster alias, sheet name and campaign title
 */
function initAcceptInv(params) {
    var result;
    var alias = params[0];
    var char_name = params[1];
    var title = params[2];

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

    var p1 = "alias=".concat(alias);
    var p2 = "&char_name=".concat(char_name);
    var p3 = "&title=".concat(title);
    var params = p1.concat(p2).concat(p3);
    xmlhttp.open("POST", "../../application/controllers/member-accept-invitation.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to remove a characters related invitation from the database
 */
function removeInvite() {
    var el = this.parentNode.parentNode;
    getParams(el, function(result) {
	initRemoveInv(result);
    });
}

/**
 * A function to initiate a query to remove a characters related invitation from the database
 * @param params array - an array holding the given invitations gamemaster alias, sheet name and campaign title
 */
function initRemoveInv(params) {
    var result;
    var alias = params[0];
    var char_name = params[1];
    var title = params[2];

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

    var p1 = "alias=".concat(alias);
    var p2 = "&char_name=".concat(char_name);
    var p3 = "&title=".concat(title);
    var params = p1.concat(p2).concat(p3);
    xmlhttp.open("POST", "../../application/controllers/member-remove-invitation.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to get the parameters for removing a character related invitation from the database
 * @param el HTMLElement - the HTML element presenting the invitation
 * @param callback - a callback function
 * @return callback array - sends the resulting array back to the calling function
 */
function getParams(el, callback) {
    var params = new Array();
    params.push(el.getElementsByClassName('alias')[0].innerHTML);
    params.push(el.getElementsByClassName('char-name')[0].innerHTML);
    params.push(el.getElementsByClassName('title')[0].innerHTML);
    callback(params);
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

    var els = new Array();
    var els = document.getElementsByClassName('leave-campaign');
    addListeners(els, leaveCampaign);

    //add listeners to the accept invitation button
    var els = new Array();
    var els = document.getElementsByClassName('accept-inv');
    addListeners(els, acceptInvite);

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