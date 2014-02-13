/**
 * A function to update the character sheets character section details
 * @param form HTMLElement - the character form that holds the new information
 */
function updateCharacter(form) {
    updateCharSQL(form);
}

/**
 * A function to update the character sheets purse section details
 * @param form HTMLElement - the character form that holds the new information
 */
function updateAttributes(form) {
    updateAttributesSQL(form);
}

/**
 * A function to update the character sheets purse section details
 * @param form HTMLElement - the character form that holds the new information
 */
function updatePurse(form) {
    updatePurseSQL(form);
}

/**
 * A function to update the characters sheet attributes section SQL data
 * @param form HTMLElement - the character form that holds the new information
 */
function updateAttributesSQL(form) {
    var str = form.str.value;
    var con = form.con.value;
    var dex = form.dex.value;
    var intel = form.intel.value;
    var wis = form.wis.value;
    var cha = form.cha.value;
    var result = null;
    var xmlhttp = null;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    updateCharHTML(form);
        }
    }

    var param1 = "str=".concat(str);
    var param2 = "&con=".concat(con);
    var param3 = "&dex=".concat(dex);
    var param4 = "&intel=".concat(intel);
    var param5 = "&wis=".concat(wis);
    var param6 = "&cha=".concat(cha);
    var params = param1.concat(param2).concat(param3).concat(param4).concat(param5).concat(param6);
    xmlhttp.open("POST", "update-attributes.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to update the characters sheet purse section SQL data
 * @param form HTMLElement - the character form that holds the new information
 */
function updatePurseSQL(form) {
    var gold = form.gold.value;
    var silver = form.silver.value;
    var copper = form.copper.value;
    var result = null;
    var xmlhttp = null;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    updateCharHTML(form);
        }
    }

    var param1 = "gold=".concat(gold);
    var param2 = "&silver=".concat(silver);
    var param3 = "&copper=".concat(copper);
    var params = param1.concat(param2).concat(param3);
    xmlhttp.open("POST", "update-purse.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to update the characters sheet SQL data
 * @param form HTMLElement - the character form that holds the new information
 */
function updateCharSQL(form) {
    var name = form.name.value;
    var level = form.level.value;
    var cls = form.cls.value;
    var injury = form.injury.value;
    var result = null;
    var xmlhttp = null;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
	    updateCharHTML(form);
        }
    }

    var param1 = "name=".concat(name);
    var param2 = "&level=".concat(level);
    var param3 = "&cls=".concat(cls);
    var param4 = "&injury=".concat(injury);
    var params = param1.concat(param2).concat(param3).concat(param4);
    xmlhttp.open("POST", "update-character.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}