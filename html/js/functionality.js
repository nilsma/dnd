function initialHide() {
    $(document).ready(function() {
	var attributes = $('div.char_attributes').children('table');
	var purse = $('div.char_purse').children('table');
	attributes.hide();
	purse.hide();
    });
}

function toggleCharacter() {
    $(document).ready(function() {
	    $('h2.char_name').click(function() {
		var attributes = $(this).parent().parent().children('div.char_attributes').children('table').css('display');
		var purse = $(this).parent().parent().children('div.char_purse').children('table').css('display');

		if(attributes == 'block' || purse == 'block') {
		    $(this).parent().parent().children('div.char_attributes').children('table').hide(300);
		    $(this).parent().parent().children('div.char_purse').children('table').hide(300);
		} else {
		    $(this).parent().parent().children('div.char_attributes').children('table').show(300);
		    $(this).parent().parent().children('div.char_purse').children('table').show(300);
		}
	    });
    });
}

function toggleAttributes() {
    $(document).ready(function() {
	$('h3.attr_heading').click(function() {
	    $(this).parent().children('table').toggle(500);
	});
    });
}

function togglePurse() {
    $(document).ready(function() {
	$('h3.purse_heading').click(function() {
	    $(this).parent().children('table').toggle(500);
	});
    });
}

window.onload = function initiate() {
    toggleCharacter();
    toggleAttributes();
    togglePurse();
//    initialHide();
}
