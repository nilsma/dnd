/**
 * A function to toggle the display of the correspodning clicked h5 elements table
 */
function toggleTable() {
    var nodes = this.parentNode.childNodes;
    for(var i = 0; i < nodes.length; i++) {
	if(nodes[i].className === 'char-table') {
	    if(window.getComputedStyle(nodes[i], null).getPropertyValue('display') === 'none') {
		nodes[i].style.display='block';
	    } else {
		nodes[i].style.display='none';
	    }
	}
    }
}

/**
 * A function to hide the given element by setting CSS style to none
 * @param $className HTMLElement - the HTMLElement to hide
 */
function hideElement(className) {
    var elements = document.getElementsByClassName(className);
    for(var i = 0; i < elements.length; i++) {
	elements[i].style.display='none';
    }
}

/**
 * A function to hide the stated elements on load by class name
 * @param classNames array - and array of elements to hide
 */
function hideElements(classNames) {
    for(var i = 0; i < classNames.length; i++) {
	hideElement(classNames[i]);
    }
}

/**
 * A function to get the nodes that needs to be toggle when toggling the character overview
 * @param el HTMLHeadingElement - the h4 element that is clicked for toggling the character overview
 * @return toggleNodes array - the relevant nodes to toggle
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
 * A function to toggle the display of the outer character container, the overview
 */
function toggleCharacter() {
    var toggleNodes = new Array();
    toggleNodes = getCharacterToggleNodes(this);
    for(var i = 0; i < toggleNodes.length; i++) {
	if(window.getComputedStyle(toggleNodes[i], null).getPropertyValue('display') === 'none') {
	    toggleNodes[i].style.display='block';
	} else {
	    toggleNodes[i].style.display='none';
	}
    }
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
    //set classnames in array and perform hide element
    var gmSections = ['personalia', 'attributes', 'purse', 'char-table'];
    hideElements(gmSections);

    //set elements in array and add listeners
//    var els = document.getElementsByClassName('trigger');
    var els = document.getElementsByTagName('h4');
    addListeners(els, toggleCharacter);

    //set elements in array and add listeners
    var els = document.getElementsByTagName('h5');
    addListeners(els, toggleTable);
}

/**
 * Load init functions on window load
 */
window.onload = function() {
//    init();
}