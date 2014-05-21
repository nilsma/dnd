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