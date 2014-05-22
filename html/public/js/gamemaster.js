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
 * A function to reset the campaign members' initiatives to 1
 */
function resetInitiatives() {
    runInitQuery(function() {
	getMembers(function(result) {
	    elems = result;
	    getCharacters(function(chars) {
		updateCharacters(chars, elems);
	    });
	});	
    });
}

/**
 * A function that executes resetting the campaign members' initiatives
 * @param callback callback - sends a callback after function execution
 */
function runInitQuery(callback) {
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

    xmlhttp.open("POST", "../../application/controllers/reset-initiatives.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}

/**
 * A function to get the characters' details from the DB
 * @param callback callback - will callback the resulting JSON parsed object
 */
function getCharacters(callback) {
    var result = null;
    var obj = null;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    obj = JSON.parse(result);
	    callback(obj);
        }
    }

    xmlhttp.open("POST", "../../application/controllers/get-characters.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}

/**
 * A function to update the innerHTML of a given members' section elements with the given characters' details
 * @param ch array - the characters to details as a multidimensional array
 * @param el HTMLElement - the HTML member campaigns HTMLElement
 */
function updateCharacters(ch, el) {
    //TODO refactor function
    for(var i = 0; i < el.length; i++) {
	document.getElementsByClassName('char_name')[i].innerHTML=ch[i]['sheet']['name'];
	document.getElementsByClassName('init_roll')[i].innerHTML=ch[i]['sheet']['init_roll'];
	document.getElementsByClassName('dmg')[i].innerHTML=ch[i]['sheet']['dmg'];
	document.getElementsByClassName('hitpoints')[i].innerHTML=ch[i]['sheet']['hp'];
	document.getElementsByClassName('level')[i].innerHTML=ch[i]['sheet']['level'];
	document.getElementsByClassName('class')[i].innerHTML=ch[i]['sheet']['class'];
	document.getElementsByClassName('xp')[i].innerHTML=ch[i]['sheet']['xp'];
	document.getElementsByClassName('str')[i].innerHTML=ch[i]['attrs']['str'];
	document.getElementsByClassName('str_mod')[i].innerHTML=ch[i]['attrs']['str_mod'];
	document.getElementsByClassName('con')[i].innerHTML=ch[i]['attrs']['con'];
	document.getElementsByClassName('con_mod')[i].innerHTML=ch[i]['attrs']['con_mod'];
	document.getElementsByClassName('dex')[i].innerHTML=ch[i]['attrs']['dex'];
	document.getElementsByClassName('dex_mod')[i].innerHTML=ch[i]['attrs']['dex_mod'];
	document.getElementsByClassName('intel')[i].innerHTML=ch[i]['attrs']['intel'];
	document.getElementsByClassName('intel_mod')[i].innerHTML=ch[i]['attrs']['intel_mod'];
	document.getElementsByClassName('wis')[i].innerHTML=ch[i]['attrs']['wis'];
	document.getElementsByClassName('wis_mod')[i].innerHTML=ch[i]['attrs']['wis_mod'];
	document.getElementsByClassName('cha')[i].innerHTML=ch[i]['attrs']['cha'];
	document.getElementsByClassName('cha_mod')[i].innerHTML=ch[i]['attrs']['cha_mod'];
	document.getElementsByClassName('gold')[i].innerHTML=ch[i]['purse']['gold'];
	document.getElementsByClassName('silver')[i].innerHTML=ch[i]['purse']['silver'];
	document.getElementsByClassName('copper')[i].innerHTML=ch[i]['purse']['copper'];
    }
}

/**
 * A function to get the campaign members' section elements from the DOM
 */
function getMembers(callback) {
    var members = document.getElementsByClassName('campaign-member');
    callback(members);
}

/**
 * A function to update the gamemaster's view
 */
function updateGm() {
    var elems;
    var chars;
    getMembers(function(result) {
	elems = result;
	getCharacters(function(chars) {
	    updateCharacters(chars, elems);
	});
    });
}

/**
 * A function to run the updateGm function periodically
 */
setInterval(
    function() {
	updateGm();
    }, 5000
);

/**
 * A function to toggle the display of the clicked table by
 * changing the encompassing div's CSS style value from 'none' to '', or vice versa
 */
function toggleTable() {
    var nodes = this.parentNode.childNodes;
    for(var i = 0; i < nodes.length; i++) {
	if(nodes[i].className === 'char-table') {
	    if(window.getComputedStyle(nodes[i], null).getPropertyValue('display') === 'none') {
		nodes[i].style.display='';
	    } else {
		nodes[i].style.display='none';
	    }
	}
    }
}

/**
 * A function to hide the given element by setting CSS style value to 'none'
 * @param className HTMLElement - the HTMLElement to hide
 */
function hideElement(className) {
    var elements = document.getElementsByClassName(className);
    for(var i = 0; i < elements.length; i++) {
	elements[i].style.display='none';
    }
}

/**
 * A function to hide the stated elements on load by class name
 * @param classNames array - an array of elements to hide
 */
function hideElements(classNames) {
    for(var i = 0; i < classNames.length; i++) {
	hideElement(classNames[i]);
    }
}

/**
 * A function to get the nodes that needs to be toggled when clicking the character in the gamemaster view
 * @param el HTMLElement - the trigger element that is clicked for toggling the character overview
 * @return toggleNodes array - an array holding the nodes to be toggled
 */
function getCharacterToggleNodes(el) {
    var nodes = el.parentNode.childNodes;
    var toggleNodes = new Array();
    for(var i = 0; i < nodes.length; i++) {
	if((nodes[i].className === 'personalia') || (nodes[i].className === 'attributes') || (nodes[i].className === 'purse')) {
	    toggleNodes.push(nodes[i]);
	}	
    }
    
    return toggleNodes;
}

/**
 * A function to toggle the display of the clicked character's details, attributes and purse, by
 * changing the elements' CSS display value to 'block' if already 'none', or vice versa
 * @param togglenodes array - the elements of which to toggle
 */
function toggleCharacter(toggleNodes) {
    if(typeof toggleNodes.length === 'undefined' || toggleNodes.length < 1) {
	var toggleNodes = new Array();
	toggleNodes = getCharacterToggleNodes(this);
    }

    for(var i = 0; i < toggleNodes.length; i++) {
	if(window.getComputedStyle(toggleNodes[i], null).getPropertyValue('display') === 'none') {
	    toggleNodes[i].style.display='block';
	} else {
	    toggleNodes[i].style.display='none';
	}
    }
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
 * A function to close all open characters in the gamemaster view
 * by hiding all characters' details, attributes and purse contents from the view
 */
function closeAll() {
    var gmSections = ['personalia', 'attributes', 'purse', 'char-table'];
    hideElements(gmSections);
}

/**
 * A function to initialize functions on load
 */
function init() {
    //hide the characters' details, attributes and purse contents from view
    closeAll();

    //add listener to the campaign member name elements
    var els = document.getElementsByClassName('name');
    addListeners(els, toggleCharacter);

    //add listener to the h5 elements
    var els = document.getElementsByTagName('h5');
    addListeners(els, toggleTable);

    //add listener to the close all button in gamemaster view
    var el = document.getElementById('close-all');
    var els = new Array();
    els.push(el);
    addListeners(els, closeAll);

    //add listeners to the reset initiative button in gamemaster view
    var el = document.getElementById('reset-init');
    var els = new Array();
    els.push(el);
    addListeners(els, resetInitiatives);

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
