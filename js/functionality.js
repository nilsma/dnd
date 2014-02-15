function expandAttributes() {
    $(document).ready(function() {
	$('div.party_member').click(function() {
	    $(this).children().toggle(500);
	});
    });
}

function hideAttributes() {
    $(document).ready(function() {
	$('div.char_attributes').css('display', 'none');
    });
}

function hidePurse() {
    $(document).ready(function() {
	$('div.char_purse').css('display', 'none');
    });
}

window.onload = function initiate() {
    hideAttributes();
    hidePurse();
    expandAttributes();
}

