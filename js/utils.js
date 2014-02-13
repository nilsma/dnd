/**
 * A function to update the character sheet asynchronously through
 * an xmlhttp object towards the update-character.php file
 * @param form HTMLElement - the character form that holds the new information
 */
function updateCharacter(form) {
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