/**
 * A function to add eventlisteners to the stated elements
 * @param els array - an array of elements of which to add listeners to
 * @param fnc function - the function name of which to trigger when the element is clicked
 */
function addListeners() {
    document.getElementById('name').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('class').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('level').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('experience_points').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('hitpoints').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('initiativeRoll').addEventListener('blur', function() { updateSheet() }, false);
    document.getElementById('modifier').addEventListener('blur', function() { updateSheet() }, false);

    document.getElementById('strength').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('strength_modifier').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('constitution').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('constitution_modifier').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('dexterity').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('dexterity_modifier').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('intelligence').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('intelligence_modifier').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('wisdom').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('wisdom_modifier').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('charisma').addEventListener('blur', function() { updateAttrs() }, false);
    document.getElementById('charisma_modifier').addEventListener('blur', function() { updateAttrs() }, false);

    document.getElementById('gold').addEventListener('blur', function() { updatePurse() }, false);
    document.getElementById('silver').addEventListener('blur', function() { updatePurse() }, false);
    document.getElementById('copper').addEventListener('blur', function() { updatePurse() }, false);
}

function updateSheet() {
    var name = document.getElementById('name').value;
    var cls = document.getElementById('class').value;
    var level = document.getElementById('level').value;
    var xp = document.getElementById('experience_points').value;
    var dmg = document.getElementById('damage').value;
    var hp = document.getElementById('hitpoints').value;
    var init_roll = document.getElementById('initiativeRoll').value;
    var init_mod = document.getElementById('modifier').value;
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

    var param1 = "name=".concat(name);
    var param2 = "&cls=".concat(cls);
    var param3 = "&level=".concat(level);
    var param4 = "&xp=".concat(xp);
    var param5 = "&dmg=".concat(dmg);
    var param6 = "&hp=".concat(hp);
    var param7 = "&init_roll=".concat(init_roll);
    var param8 = "&init_mod=".concat(init_mod);
    var params = param1.concat(param2).concat(param3).concat(param4).concat(param5).concat(param6).concat(param7).concat(param8);
    xmlhttp.open("POST", "../../../html/application/controllers/update-personalia.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function updateAttrs() {
    var str = document.getElementById('strength').value;
    var str_mod = document.getElementById('strength_modifier').value;
    var con = document.getElementById('constitution').value;
    var con_mod = document.getElementById('constitution_modifier').value;
    var dex = document.getElementById('dexterity').value;
    var dex_mod = document.getElementById('dexterity_modifier').value;
    var intel = document.getElementById('intelligence').value;
    var intel_mod = document.getElementById('intelligence_modifier').value;
    var wis = document.getElementById('wisdom').value;
    var wis_mod = document.getElementById('wisdom_modifier').value;
    var cha = document.getElementById('charisma').value;
    var cha_mod = document.getElementById('charisma_modifier').value;
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

    var p1 = "str=".concat(str);
    var p2 = "&str_mod=".concat(str_mod);
    var p3 = "&con=".concat(con);
    var p4 = "&con_mod=".concat(con_mod);
    var p5 = "&dex=".concat(dex);
    var p6 = "&dex_mod=".concat(dex_mod);
    var p7 = "&intel=".concat(intel);
    var p8 = "&intel_mod=".concat(intel_mod);
    var p9 = "&wis=".concat(wis);
    var p10 = "&wis_mod=".concat(wis_mod);
    var p11 = "&cha=".concat(cha);
    var p12 = "&cha_mod=".concat(cha_mod);
    var params = p1.concat(p2).concat(p3).concat(p4).concat(p5).concat(p6).concat(p7).concat(p8).concat(p9).concat(p10).concat(p11).concat(p12);
    xmlhttp.open("POST", "../../../html/application/controllers/update-attrs.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function updatePurse(x) {
    var gold = document.getElementById('gold').value;
    var silver = document.getElementById('silver').value;
    var copper = document.getElementById('copper').value;
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

    var p1 = "gold=".concat(gold);
    var p2 = "&silver=".concat(silver);
    var p3 = "&copper=".concat(copper);
    var params = p1.concat(p2).concat(p3);
    xmlhttp.open("POST", "../../../html/application/controllers/update-purse.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function getInitiativeRoll(callback) {
    var result;
    var initiative;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    initiative = JSON.parse(result);
	    callback(initiative);
	    
        }
    }

    xmlhttp.open("POST", "../../../html/application/controllers/get-initiative.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}

function setNewInitiative(i) {
    document.getElementById('initiativeRoll').value=i;
}


function updateInitiative() {
    getInitiativeRoll(function(result) {
	setNewInitiative(result);
    });
}

/**
 * A function to run the updateGm function periodically - every 3 seconds
 */
setInterval(
    function() {
	updateInitiative();
    }, 5000
);

/**
 * A function to initialize functions on load
 */
function init() {
    addListeners();
}

/**
 * Load init functions on window load
 */
window.onload = function() {
    init();
}