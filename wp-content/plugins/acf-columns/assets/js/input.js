(function($){




	/*
	*  acf/setup_fields
	*
	*  This event is triggered when ACF adds any new elements to the DOM.
	*
	*  @type	function
	*  @since	1.1.0
	*  @date	08/29/14
	*
	*  @param	event		e: an event object. This can be ignored
	*  @param	Element		postbox: An element which contains the new HTML
	*
	*  @return	N/A
	*/
	// Disabled since 2.5.9 - Replaced by other conditional system
	// acf.add_action('show_field', function( $field, context ){
	// 	$field.removeClass('conditional-hidden');
	// });
	function wrapFields($el){


	 	var acf_settings_cols = acf.model.extend({

	 		actions: {
	 			'open_field':			'render',
	 			'change_field_type':	'render'
	 		},

	 		render: function( $el ){

	 			// bail early if not correct field type
	 			if( $el.attr('data-type') != 'column' ) {

	 				return;

	 			}

	 			// clear name
	 			$el.find('.acf-field[data-name="name"] input').val('').trigger('change');

	 		}

	 	});

		var count = 'first';

		// search $el for fields of type 'column'
		acf.get_fields({ type : 'column'}, $el).each(function(e, postbox) {

			var columns = $(postbox).find('.acf-column[class*="column-layout"]').data('column'),
				orig_key = $(postbox).find('.acf-column[class*="column-layout"]').data('id') || '',
				orig_class = $(postbox).attr('class');
				orig_class = orig_class.replace(/(\acf-field-\w+|\d+)|(acf-field)/gm, '');

				key = "acf-" + orig_key.replace("_", "-"),
				colClass = '',
				is_collapse_field = '';

			$(postbox).find('.acf-column').each(function() {
				var root = $(this).parents('.acf-field-column');
				var conditionalData = $(postbox).data('conditions') || '';
				if($(this).hasClass('end-column')){
					var wrapperObject = $(postbox);
					wrapperObject.remove();
					return;
				} else if ( columns == '1' ) {
					var wrapperObject = $('<div class="test1 acf-field acf-field-columngroup column-end-layout '+orig_class+'"></div>').attr({
						'data-field': 'column',
						'data-key': orig_key,
						'hidden': false
					});
					// if we add conditions tag, the field will be hidden despite it being empty
					if(conditionalData){
						wrapperObject.attr('data-conditions', JSON.stringify(conditionalData))
					}
					//$(postbox).replaceWith(wrapperObject);
					count = 'first';
				} else {
					var acf_fields = $(root).nextUntil('.acf-field-column');

					acf_fields.each(function() {
						if ( $(this).hasClass('-collapsed-target') ) {
							is_collapse_field = ' -collapsed-target';
							return is_collapse_field;
						}
					});

					if ( $(postbox).hasClass('hidden-by-tab') ) {
						colClass = 'acf-field acf-field-columngroup ' + key + ' column-layout-' + columns + ' ' + count + ' ' + orig_class + ' hidden-by-tab';
					} else {
						colClass = 'acf-field acf-field-columngroup ' + key + ' column-layout-' + columns + ' ' + count + ' ' + orig_class;
					}

					if ( $(postbox).hasClass('hidden-by-conditional-logic') ) {
						colClass = colClass + ' conditional-hidden hidden-by-conditional-logic';
					}

					// fix columns inside tabs not being shown
					$(postbox).children('.acf-field.acf-hidden').removeClass('acf-hidden').attr('hidden', false);

					// show all sub field of column too
					acf.addAction('show_field', function(field){
						if(field.data.field != 'column'){ // not a column, abort
							return;
						}
						field.$el.children('.acf-field.acf-hidden').removeClass('acf-hidden').attr('hidden', false);
					});
					//var wrapperObject = $('<div class="'+ colClass + is_collapse_field +'"></div>')
					var wrapperObject = $(postbox);
					wrapperObject.children().remove();
					wrapperObject.attr({
						'data-field': 'column',
						'data-key': orig_key,
						'hidden': false,
					}).removeClass('acf-hidden').attr('hidden', false);
					if(conditionalData){
						wrapperObject.attr('data-conditions', JSON.stringify(conditionalData))
					}
					wrapperObject.addClass(colClass + is_collapse_field);
					// stop at new col, submit (end) or new tab
					$(root)	.nextUntil('.acf-field-column, p.submit, .acf-field-tab')
							.removeClass('hidden-by-tab')
							.appendTo(wrapperObject);

							wrapperObject.children('.acf-field:not([data-conditions])').removeClass('acf-hidden').attr('hidden', false);//.removeClass('acf-hidden').attr('hidden', false)
					//$(postbox).remove();
					count = '';
				}
			});
		});

		// Fix for initiating TinyMCE when using in Flexible Content Field
		// Thanks to dsamson (https://github.com/dsamson/)

		if (typeof tinyMCE !== 'undefined') {
		  if ( tinyMCE ) {
				acf.get_fields({ type : 'wysiwyg'}, $el).each(function(e, postbox){
					$("textarea.wp-editor-area", postbox).each(function(){
						edit = tinyMCE.EditorManager.get(this.id);

						if ( edit !== null ) {
							settings = edit.settings;
							edit.remove();
						} else {
							settings = {};
						};
						tinyMCE.EditorManager.init(settings);
					});
				});
			}
		}

	}
	acf.add_action('ready append', function( $el ){
		wrapFields();

	});
	$('#menu-to-edit').on('menu-item-added change mouseover', function(){
		wrapFields();
		$('.acf-field-columngroup .acf-input').css('visibility', 'visible');
		$(document).trigger('popup-wrapping-ready');


	});
})(jQuery);


/*====================================================
=            Brand by hand - Page builder            =
====================================================*/

(function($){
	function addPopups(t, $el){


		// wrap wysiwyg fields in popup wrapper and add edit button

		acf.get_fields($el).each(function(e, postbox) {
			//var frameBox =$(postbox).find('iframe[id*="acf-editor"]').contents().find("[tokenid=" + token + "]").html();
			var frameBox = $(postbox).find('iframe');

			if($('body').hasClass('post-type-acf-field-group') == true){
				return true;
			}


			if($(postbox).hasClass('acf-field-message') == true){
				$(postbox).next().addClass('first-after-message');
			}

			var fieldType = $(postbox).data('type');

			var forbiddenArray = ['flexible_content', 'select', 'radio', 'checkbox', 'true_false', 'message', 'column','accordion', 'button_group', 'range', 'text', 'tab', 'email', 'url', 'password', 'number', 'post_object', 'page_link', 'file', 'link', 'user', 'date_picker', 'date_time_picker', 'time_picker', 'color_picker' ];

			//var forbiddenArray = ['text', 'textarea', 'image', 'wysiwyg']
			if(($.inArray(fieldType, forbiddenArray) !== -1)){
				return true;
			}
			if(fieldType == 'column'){
				return true;
			}


			if (!$(this).parent().hasClass('acf-field-columngroup')){
			    return true;
			} else if($(postbox).parent().hasClass('acf-row')){

			};

			if($(postbox).data('popup-finished') == true){
				return true;
			}


			// add custom builder-field class
			$(postbox).addClass('builder-field');
			// wrap in popup wrapper
			$(postbox).find('> .acf-input').wrap('<div class="popup-content-outer ' + fieldType + '"><div class="popup-content-inner"></div></div>');
			// add edit button
			$(postbox).append('<span class="edit-trigger has-content"><a class="acf-icon -pencil dark" href="#" title="Rediget"></a></span>');
			// append popup overlay
			$(postbox).append('<div class="popup-overlay"></div>');
			// clone field label for popup box
			var fieldLabel = $(postbox).find('.acf-label').clone().html();
			var closeBtnHtml = '<button class="close-btn button-link media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text">Luk mediepanel</span></span></button>';
			var fullscreenBtnHtml = '<button class="fullscreen-btn button-link media-modal-close"><span class="dashicons dashicons-editor-expand"><span class="screen-reader-text">Fuld skærm</span></span></button>';
			// generate popup box
			$(postbox).find('.popup-content-outer').prepend( fieldLabel + fullscreenBtnHtml + closeBtnHtml );


			function checkTinyMCE(){
				if(fieldType != 'wysiwyg'){
					return true;
				}
				var editorContent = tinyMCE.activeEditor.getContent();
				if(editorContent.length > 1){
					$(postbox).find('.edit-trigger').addClass('has-content');
				} else{
					$(postbox).find('.edit-trigger').removeClass('has-content');
				}

			}

			function dynamicEditBtn(){
				var contentArray = [];

				$(postbox).find('.popup-content-inner').find('input, textarea, .acf-repeater input, textarea.wp-editor-area').each(function(){


					var text = $(this).text();
					var value = $(this).val();



					if( value.length >= 1 || text.length >= 1){
						contentArray.push('true');

						//$(postbox).find('.edit-trigger').addClass('has-content');
					} else{
						contentArray.push('false');
						//$(postbox).find('.edit-trigger').removeClass('no-content')

					}
				})




				if($.inArray('true', contentArray) !== -1){
					$(postbox).find('.edit-trigger').addClass('has-content');
					var contentArray = [];
				} else{
					$(postbox).find('.edit-trigger').removeClass('has-content');
					var contentArray = [];
				}

			}

			function fullscreenBtnTrigger(e){
				// strip button of WordPress js
				e.preventDefault();
				// save btn element in var
				var btn = $(postbox).find('.fullscreen-btn');
				// toggle active class
				btn.toggleClass('fullscreen-active');
				// if fullscreen active / else
				if(btn.hasClass('fullscreen-active') == true){
					// remove draggable
					$(postbox).find('.popup-content-outer').addClass('fullscreen-mode').removeClass('ui-draggable');
				} else if(btn.hasClass('fullscreen-active') == false){
					// add draggable again after animation is complete
					$(postbox).find('.popup-content-outer').removeClass('fullscreen-mode').delay(1000).queue(function(next){
					    $(this).addClass('ui-draggable');
					    next();
					});
				}
			}

			window.scrollBarWidth = function() {
				document.body.style.overflow = 'hidden';
				var width = document.body.clientWidth;
				document.body.style.overflow = 'scroll';
				width -= document.body.clientWidth;
				if(!width) width = document.body.offsetWidth - document.body.clientWidth;
				document.body.style.overflow = '';
				return width;
			}
			// trigger edit button type
			//dynamicEditBtn();

			// trigger fullscreen on button click
			$(postbox).find('.fullscreen-btn').on('click', fullscreenBtnTrigger);

			// trigger popup content show on edit btn click
			$(postbox).find('.edit-trigger').on('click', function(){

				// first fadeout previous popup if it's open
				$('.popup-content-outer').fadeOut();


				// fadein popup and overlay
				$(postbox).find('.popup-content-outer').fadeIn();

				$(postbox).find('.popup-overlay').fadeIn();
				// remove any previous edit button active and set new for triggered element
				$('.edit-trigger').removeClass('active');
				$(postbox).find('.edit-trigger').addClass('active');



				// lock body scroll
				$('body').addClass('noscroll');
				$('body').css('margin-right', window.scrollBarWidth());


				// TinyMCE fix for wysiwyg fields
				if(fieldType == 'wysiwyg'){

					$(postbox).find("textarea.wp-editor-area").each(function(){
						// get wp settings for TinyMCE
						edit = tinyMCE.EditorManager.get(this.id);

						tinyMCE.activeEditor.destroy(0);
						$('button#'+this.id+'-tmce').click();
						//tinyMCE.activeEditor.execCommand('mceToggleEditor',true,'content');


						// if settings exists
						if ( edit !== null ) {
							settings = edit.settings;
							edit.remove();
						} else {
							settings = {};
						};

						// reInit tinyMCE with settings
						tinyMCE.EditorManager.init(settings);

						// set focus on the current editor
						tinyMCE.get(edit.id).focus();
						// set focus to end of content
						tinyMCE.activeEditor.selection.select(tinyMCE.activeEditor.getBody(), true);
						tinyMCE.activeEditor.selection.collapse(false);
					});
				} else if(fieldType == 'textarea'){
					$(postbox).find('textarea').focus();
				} else if($(postbox).find('.acf-input-wrap > input')){
					$(postbox).find('.acf-input-wrap > input').focus();
				}



				// trigger edit button function - detect if has content
				//dynamicEditBtn();
				// trigger checkTinyMCE
				//checkTinyMCE();
				// sæt max height til popup-content-inner, så repeaters ikke flyder ud over popup
				$(postbox).find('.popup-content-inner').css({
					'max-height' : $(postbox).find('.popup-content-inner').parent().height() - $(postbox).find('.popup-content-inner').siblings('.description').outerHeight( true ),
				})

			})
			// lock in position and remove transform translate on first open. Position is saved upon drag end, for future opening
			$(postbox).find('.edit-trigger').one('click', function(){
				var contentOuter = $(postbox).find('.popup-content-outer');
				var contentOffset = contentOuter.offset();
				var scrollTop = $(window).scrollTop();

				contentOuter.css({
					'left'		: 	contentOffset.left,
					'top'		: 	contentOffset.top - scrollTop,
					'transform'	: 	'none',
				})
			})
			// set wysiwyg fields trigger as no content on new row layout
			/*$(postbox).find('textarea').each(function(){

				if($(this).length <= 1){
					$(postbox).find('.edit-trigger').removeClass('has-content');
				}
			})*/
			// trigger popup content hide on overlay or close btn click
			$(postbox).find('.popup-overlay, .close-btn').on('click', function(e){

				// remove active class from edit trigger
				$('.edit-trigger').removeClass('active');
				// prevent link follow, or other event handlers
				e.preventDefault();
				// fadeout overlay
				//$(postbox).find('.popup-overlay').fadeOut();
				// fadeout popupwindow and remove fullscren
				$(postbox).find('.popup-content-outer').fadeOut().delay(400).queue(function(next){
					$(this).removeClass('fullscreen-mode');
					$(postbox).find('.popup-content-outer').removeClass('fullscreen-mode').addClass('ui-draggable');
					$(postbox).find('.fullscreen-btn').removeClass('fullscreen-active');
					next();
				});

				// remove noscroll class form body
				$('body').removeClass('noscroll');
				$('body').css('margin-right', '0px');



				// trigger edit button function - detect if has content
				//dynamicEditBtn();
				//checkTinyMCE();

			})


			// initiate draggable on popup-content-outer
			$(postbox).find('.popup-content-outer').draggable({
					cancel: '.fullscreen-mode',
					// disabled dragability on iframe
					iframeFix: true,
					// move symbol on cursor while dragging
					cursor: "move",
					// only drag on label
					handle: '> label',
					opacity: 0.7,
					// stay within edit page container (won't move over sidebar)
					drag: function(e,ui){
						var windowWidth = $(window).width();
						var windowHeight = $(window).height();
						var popupOuterWidth = $(postbox).find('.popup-content-outer').outerWidth();
						var popupOuterHeight = $(postbox).find('.popup-content-outer').outerHeight();
				        //Do not permit to be more close than 10 px of window minus sidebar
				        if(ui.position.left < 170){
				            ui.position.left = 170;
				        }
				        if(ui.position.top < 40){
				        	ui.position.top = 40;
				        }
				        if(ui.position.top > windowHeight - popupOuterHeight){
				        	ui.position.top = windowHeight - popupOuterHeight - 10;
				        }
				        if(ui.position.left > windowWidth - popupOuterWidth){
				        	ui.position.left = windowWidth - popupOuterWidth - 10;
				        }
				    },
					scroll: false,
					// on start, remove transform css, since this will cause placement to be wrong
					start: function() {
			        	$(this).css({
					          transform: 'none',
					    });
					},
					// on stop drag, save current screen position relative to window
					stop: function() {
						var endOffset = $(this).offset();
						$(this).css({
							'left' 	: endOffset.left,
							'top'	: endOffset.top - $(window).scrollTop(),
						})
					},


				})
			$(postbox).data('popup-finished', true);

		})

	}
	acf.add_action('ready append', function( $el ){
		addPopups();

	})
	acf.addAction('show_field', function(field){

		if(field.data.type == 'wysiwyg'){

			var edit = tinyMCE.EditorManager.get(field.data.id);
			// if settings exists
			if ( edit !== null ) {
				settings = edit.settings;
				edit.remove();
			} else {
				settings = {};
			};

			// reInit tinyMCE with settings
			tinyMCE.EditorManager.init(settings);
		}
	})
	$(document).on('popup-wrapping-ready', addPopups);
	$(document).ready(function(event){
		//$('.acf-field-flexible-content').prepend('<div class="flexible-loader"></div>');
	});

	acf.add_action('load', function(){
		// show fields when function is done and markup is inserted.
		$('.flexible-loader').fadeOut('slow').addClass('closing');
	})


	// 1 section visible at a time
	$('.layout').each(function(){
		var layoutAttribute = $(this).attr('data-id');
		if (layoutAttribute.includes("row")) {
			$(this).addClass('-collapsed');
		}
	});

	$('.layout .acf-icon.-collapse').on('click', function(){
		$(this).closest('.layout').siblings().addClass('-collapsed');
	});

	//Custom buttons
	setTimeout(() => {
		tinymce.PluginManager.add('brandbyhand_container', function( editor, url ) {
		editor.addButton( 'brandbyhand_container', {
			title: 'Add a button',
			icon: 'link',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Buttons',
					body: [{
						type: 'listbox',
						name: 'button',
						label: 'Button',
						values: [
							{text: 'Primary', value: 'btn primary-button'},
							{text: 'Secondary', value: 'btn secondary-button'},
						]
					}, {
						type: 'textbox',
						name: 'name',
						label: 'Name',
					}, {
						type: 'textbox',
						name: 'link',
						label: 'Link',
					}, {
						type: 'listbox',
						name: 'target',
						label: 'Target',
						values: [
							{text: 'Default', value: '_self'},
							{text: 'Open in new tab', value: '_blank'},
						]
					}
					],
					onsubmit: function( e ) {
						editor.insertContent( '<a target="' + e.data.target + '" href="' + e.data.link + '" class="' + e.data.button + '">' + e.data.name + '</a>');
					}
				});
				}
			});
		});
	}, 1000);

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


})(jQuery);
