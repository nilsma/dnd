/**
 * A function to reset all party members' database initiative_roll to 1, through
 * an async call to reset-initiative.php
 * @param party_id int - the int of the party where the characters are member
 */
function resetInitiative(campaign_id) {
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
	    if(result) {
		updateInitiativeHTML();
	    } else {
		alert('Something went wrong while updating initiative ...');
	    }
        }
    }

    var params = "campaign_id=".concat(campaign_id);
    xmlhttp.open("POST", "reset-initiative.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function updateInitiativeHTML() {
    var elements = document.getElementsByClassName('init_roll');
    for(var i = 0; i < elements.length; i++) {
	elements[i].innerHTML=1;
    }
}

/**
 * A function to update the HTML of the gamemaster GM screen through
 * an async call to update-gm-screen.php
 */
function updateCampaignMembersInfo() {
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
	    updateCampaignMembersHTML(result);
        }
    }

//    var params = "campaign_id=".concat(campaign_id);
    xmlhttp.open("POST", "update-campaign-members-info.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
//    xmlhttp.send(params);
}

function updateCampaignMembersHTML(html) {
    var element = document.getElementById('campaign_members');
    element.innerHTML=html;
}

/**
* A function to run the updateTable() function periodically (every 10 seconds)
*/
setInterval(
    function runGMUpdates() {
	updateCampaignMembersInfo();
    }, 2000
);

