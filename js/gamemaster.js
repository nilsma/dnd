/**
 * A function to reset all party members' database initiative_roll to 1, through
 * an async call to reset-initiative.php
 * @param party_id int - the int of the party where the characters are member
 */
function resetInitiative(party_id) {
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
	    updateGMScreen();
        }
    }

    var params = "party_id=".concat(party_id);
    xmlhttp.open("POST", "reset-initiative.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

/**
 * A function to update the HTML of the gamemaster GM screen through
 * an async call to update-gm-screen.php
 */
function updateGMScreen() {
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
	    updateGMScreenHTML(result);
        }
    }

    var params = "";
    xmlhttp.open("POST", "update-gm-screen.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("charset", "ISO8859-1");
    xmlhttp.send(params);
}

function updateGMScreenHTML(html) {
    var element = document.getElementById('party_members');
    element.innerHTML=html;
}

/**
* A function to run the updateTable() function periodically (every 10 seconds)
*/
/*
setInterval(
    function runGMUpdates() {
	updateGMScreen();
    }, 10000
);
*/

