(function($){

	/*==============================================
	=            Function - Close popup            =
	==============================================*/
	function closeLayoutPopup(event){
		event.preventDefault();
		var popup = $(event.target).closest('.bbh-popup');
		var overlay = $('.bbh-popup-overlay');
		var layouts = popup.find('.single-layout');
		var layoutMenu = popup.find('.bbh-layout-menu a');


		popup.fadeOut(function(){
			// Clear nav and layout bio
			layouts.hide();
			layoutMenu.removeClass('active');

			// show welcome message again
			popup.find('.welcome-message').show();
		});
		overlay.fadeOut();
		$('body').css('overflow', 'unset');

	}

	/*=============================================
	=            Function - Open popup            =
	=============================================*/
	var openLayoutPopup = function(event, referer = ''){
		event.preventDefault();
		var target = $(event.target);
		var flexible_field = target.closest('.acf-field-flexible-content').attr('data-name');
		var popup = $(".bbh-popup[data-key='" + flexible_field + "']");
		var overlay = $('.bbh-popup-overlay');

		// save referer of "add" button;
		if(target.closest('.layout').length > 0){
			referer = target.closest('.layout');
		} else{
			referer = false;
		}

		// save referer data on popup
		popup.data('referer', referer);
		// fadein popup
		popup.addClass('open')
		popup.fadeIn();
		// fadein overlay
		overlay.fadeIn();
		// add no-scroll to body
		$('body').css('overflow', 'hidden');
	}

	/*=============================================
	=            Function - Add Layout            =
	=============================================*/
	var addLayout = function(event){
		event.preventDefault();
		//console.log('trying to add layout')
		var target = $(event.target);
		var popup = $('.bbh-popup.open');
		//console.log(popup)
		var dataLayout = target.attr('data-layout');
		var fieldName = popup.attr('data-key');

		var fieldKey = $('.acf-field[data-name="'+fieldName+'"]').attr('data-key');
		// save acf flexible field object

		// var flexibleField = acf.getField(fieldKey);
		var flexibleField = popup.data('field');
		//console.log(flexibleField)

		// before referer fetched from popup
		var before = $(popup.data('referer')).length > 0 ? $(popup.data('referer')) : false;

		// add the layout
		flexibleField.add({
			layout: dataLayout,
			before: before,
		});

		function Layoutcalc(number, increment, section) {
				var counter = 0;
				$(section).find('.acf-field-columngroup.column-layout-1_4').each(function() {
					if (increment == 1) {
						if (counter == number) {
							$(this).css({
							'width' : 'calc((100% / 3) * 2)'
							})
						} else {
							$(this).css({
							'width' : 'calc(100% / 3)'
							})
						}
					} else if (increment == 2) {
						if (counter == number) {
							$(this).css({
							'width' : 'calc((100% / 4) * 3)'
							})
						} else {
							$(this).css({
							'width' : 'calc(100% / 4)'
							})
						}
					}
					else if (increment == 3) {
						if (counter == number) {
							$(this).css({
							'width' : '50%'
							})
						} else {
							$(this).css({
							'width' : '25%'
							})
						}
					}
					counter++;
				});
		}

		//Variable content column counter
		function UpdateCount() {
			$('.layout[data-layout="variable_content"]:not(.acf-clone)').each(function(){
				var LayoutValue = $(this).find('.acf-field-5f6db0a1bab45 label.selected input').val();
				var section = $(this);
				if (LayoutValue > 4) {
					if (LayoutValue == 5) { Layoutcalc(0, 1, section) }
					if (LayoutValue == 6) { Layoutcalc(1, 1, section) }
					if (LayoutValue == 7) { Layoutcalc(0, 2, section) }
					if (LayoutValue == 8) { Layoutcalc(1, 2, section) }
					if (LayoutValue == 9) { Layoutcalc(0, 3, section) }
					if (LayoutValue == 10) { Layoutcalc(2, 3, section) }
					if (LayoutValue == 11) { Layoutcalc(1, 3, section) }
				} else {
					var counter = 0;

					$(this).find('.variablecolumn:not(.acf-hidden)').each(function(){
						counter++;
					});

					$(this).find('.acf-field-columngroup.column-layout-1_4').css({
						'width' : 'calc(100% / '+counter+')'
					});
				}
			})
		}
		UpdateCount()


		$('.acf-field-5f6db0a1bab45 input').on('click', function() {
			var inputvalue = $(this).val();
			$(this).parents('.layout[data-layout="variable_content"]:not(.acf-clone)').on('change', function(){
				UpdateCount();
			})
		});


		flexibleField.render();

		closeLayoutPopup(event);
	}

	/*==================================================
	=            Function - View layout bio            =
	==================================================*/

	var viewLayoutBio = function(event){
		event.preventDefault();
		var target = $(event.target);
		if(target.hasClass('active')){
			return;
		}
		var popup = target.closest('.bbh-popup');
		var dataLayout = target.attr('data-layout');
		var singleLayout = popup.find('.single-layout[data-layout="'+dataLayout+'"]');

		popup.find('.bbh-layout-menu a, .window-controls span.dashicons-info').removeClass('active');
		target.addClass('active');
		popup.find('.single-layout').hide();
		singleLayout.show();
	}

	/*===============================================
	=          Prepare events           =
	===============================================*/

	acf.add_action('load', function( $el ){
		// add body class for styling
		$('body').addClass('bbh-layouts-enabled');

		// set reference to field obj
		$('.bbh-popup').each(function(){
			var fieldObj = acf.getField($(this).attr('data-field-key'));
			$(this).data('field', fieldObj)
		})

		// add section click - open popup
		$('.acf-field-flexible-content .acf-flexible-content > .acf-actions a.acf-button').on('click',openLayoutPopup);

		//  Close button click
		$('.layout-picker-close').on('click', closeLayoutPopup);

		//  Add layout
		$('.bbh-popup a.add-layout-button').on('click', addLayout);
		// view bio

		$('.bbh-popup .bbh-layout-menu a, .window-controls .layout-picker-info').on('click', viewLayoutBio);

	});

})(jQuery);
