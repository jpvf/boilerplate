jQuery(function($){

	var navigation = {
		
		showForm : function(e) {
			e.preventDefault();
			$('#menu-new-item').slideToggle(500);
		},

		hideForm : function(e) {
			e.preventDefault();
			$('#menu-new-item').slideUp(500);
		}

	};

	$('#new-item').click(navigation.showForm);
	$('#cancel-new-item').click(navigation.hideForm);
	
	$('.navigation').sortable({
		placeholder: 'ui-state-highlight',
		containment: 'parent',
		tolerance: 'pointer',
		helper: 'clone',
		axis: 'y'
	});

});