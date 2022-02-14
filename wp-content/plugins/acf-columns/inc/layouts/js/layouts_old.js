(function($){


	function buildPopups(){
		//return false;
		console.log('yes');
		var overlayCheck = false;

		if(overlayCheck == false){
			$('body').append('<div class="bbh-popup-overlay">');
			var overlayCheck = true;
		}

		// add body class for styling
		$('body').addClass('bbh-layouts-enabled');



		$('.acf-field-flexible-content .acf-flexible-content > .acf-actions a.acf-button').each(function(){

			var key = $(this).closest('.acf-field-flexible-content').attr('data-name');

			var html = $(this).closest('.acf-actions').siblings('.tmpl-popup').html();

			/*=========================================
			=            Build popup boxes            =
			=========================================*/

			$('body').append('<div class="bbh-popup ' + key + '"></div>');
			var popup = $('.bbh-popup.' + key);
			$(popup).attr('data-key', key);
			$(popup).append(html);
			popup.wrapInner('<div class="popup-wrap">');
			var popup = popup.find('.popup-wrap');
			$(popup).find('.acf-fc-popup').removeClass('acf-fc-popup').addClass('bbh-layout-menu');
			$(popup).find('.bbh-layout-menu a.focus').remove();
			$('.bbh-popup a').off('click');



			popup.append(layout_material.markup);
			popup.find('.bbh-layout-menu').prepend('<div class="layout-menu-heading"><h3>Vælg en sektion</h3></div>');
			popup.find('.layout-info').prepend('<div class="window-controls"></div>');

			popup.find('.layout-info .window-controls').prepend('<span class="modal-info layout-picker-info"><span class="dashicons-info active" data-layout="welcome-message"></span></span>');


			popup.find('.layout-info .window-controls').append('<span class="media-modal-close layout-picker-close"><span class="media-modal-icon"></span></span>');

			var themepathImages = layout_material.themepath+'/include/flexible-content/images/';
			var themepathDescriptions = layout_material.themepath+'/include/flexible-content/descriptions/';
			var themepathWelcome = layout_material.welcomepath;
			var themepathWelcomeFile = layout_material.welcomefile;


			/*==============================================
			=            Build layouts in popup            =
			==============================================*/

			$(popup).find('.bbh-layout-menu li a').each(function(event){
				var currentPopup = $(this).closest('.bbh-popup'),
					dataLayout = $(this).attr('data-layout'),
					layoutTitle = $(this).text(),
					title = 'Tilføj sektionen:',
					layoutImage = themepathImages+dataLayout+'.png';


				//
				$.ajax({
				    url: layoutImage,
				    type:'HEAD',
				    error: function()
				    {
				        return false;
				    },
				    success: function()
				    {
				        popup.find('.'+dataLayout+' .layout-image').append('<img src="'+layoutImage+'">');
				    }
				});

				$.ajax({
				    url: themepathDescriptions+dataLayout+'.php',
				    type:'HEAD',
				    error: function()
				    {
				    	return false;
				    },
				    success: function()
				    {
				        var layoutdescription = $.get(themepathDescriptions+dataLayout+'.php', function(data){
				        	popup.find('.single-layout[data-layout="'+dataLayout+'"] .layout-description').append(data);
				        });
				    }
				});




				popup.find('.layout-inner').append('<div class="single-layout '+dataLayout+'" data-layout="'+dataLayout+'"><div class="layout-title"><h3 class="general-title">'+title+'</h3><h3 class="layout-name">' + layoutTitle + '</h3></div><div class="layout-description"></div><div class="layout-image"></div><div class="add-layout"><a class="add-layout-button button-primary" href="" data-layout="'+dataLayout+'">Tilføj sektion</a></div></div>');

			})
			if(popup.find('.single-layout.welcome-message').length < 1){

				popup.find('.layout-inner').prepend('<div class="single-layout welcome-message" data-layout="welcome-message"><div class="layout-description"></div><div class="layout-image"></div></div></div>');
				$.ajax({
				    url: themepathWelcomeFile,
				    type:'HEAD',
				    error: function()
				    {

				    	popup.find('.single-layout.welcome-message .layout-description').append('<p>Der skete en fejl, prøv venligst at genindlæse siden</p>')
				    	return false;
				    },
				    success: function()
				    {



				        // get welcome description file
				        var layoutdescription = $.get(themepathWelcomeFile, function(data){
				        	// replace all image url's with actualpath
				        	var dataUpdated = data.replace(/(\b([a-zA-Z0-9\-\_]+(.gif|.jpg|.png|.jpeg]$1)))/mig, themepathWelcome+'$1');

				       		// append description to tab
				        	popup.find('.single-layout.welcome-message .layout-description').append(dataUpdated);
				        });





				        popup.find('.single-layout.welcome-message .layout-description').find('img').each(function(){
				        	var src = themepathWelcome + $(this).attr('src');

				        	//$(this).attr('src', src);
				        })
				        var welcomeAdded = 1;
				    }
				});
			}

		})
	}

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
		var popup = $('.'+flexible_field);
		var overlay = $('.bbh-popup-overlay');

		// save referer of "add" button;
		if(target.closest('.layout').length > 0){
			var referer = target.closest('.layout');
		} else{
			var referer = false;
		}

		// save referer data on popup
		popup.data('referer', referer);
		// fadein popup
		popup.addClass('open').fadeIn();
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
		var target = $(event.target);
		var popup = target.closest('.bbh-popup');
		var dataLayout = target.attr('data-layout');
		var layout = target.attr('data-layout');
		// save acf flexible field object
		$this = acf.fields.flexible_content;

		// before referer fetched from popup
		$before = $(popup.data('referer')).length > 0 ? $(popup.data('referer')) : false;
		// add row

		// reference
		 var $field = $this.$field;

		// vars
		 var $clone = $this.$clones.children('.layout[data-layout="' + layout + '"]');

		if( $before) {
		// duplicate
		 $el = acf.duplicate( $clone );


		// enable
		acf.enable_form( $el, 'flexible_content' );


		// hide no values message
		$this.$el.children('.no-value-message').hide();

		// add element before target
		$before.before( $el );
		} else {

			acf.fields.flexible_content.add(dataLayout);

		}
		// do acf stuff
		$this.doFocus($field);
		$this.render();
		$this.sync();

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




	acf.add_action('load', function( $el ){
		buildPopups();
		// add section click - open popup
		$('.acf-field-flexible-content .acf-flexible-content > .acf-actions a.acf-button').on('click',openLayoutPopup);

		//  Close button click
		$('.layout-picker-close').on('click', closeLayoutPopup);

		//  Add layout
		$('.bbh-popup a.add-layout-button').on('click', addLayout);
		// view bio

		$('.bbh-popup .bbh-layout-menu a, .window-controls .layout-picker-info').on('click', viewLayoutBio);

		// add element before click - open popup
		$('.acf-fc-layout-controlls [data-name="add-layout"]').on('click', openLayoutPopup);

	});


})(jQuery);
