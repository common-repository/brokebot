(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 * 
	 *  
	 */
	$(function() {
		
		 
		//preload content
		var runOnce = false;
		var wasClosed = false;
		$.ajax({
				type: "post",
				dataType: "json",
				url: brokebot_ajax.ajax_url,
				data: {
					action: 'get_brokebot_content'
				},
				success: function(data){
					console.log(data);
					//create iframe
					brokebot_initialize(data);
					

				}
			});

		
			function brokebot_initialize(data) {

					if (data.brokebot_cookie_hide === 1) {
						if (document.cookie.indexOf("brokebot_cookie_hide=") >= 0) {
							// brokebot cookie exists.
							var brokebot_cookie_hide = true;
							var cookie_engagement = false;
						}
						else {
							var cookie_engagement = true;							
							var brokebot_cookie_hide = false;
						}
					} else {
						//no cookie, remove if exists
						var expireexpiry = new Date();
						expireexpiry.setDate(expireexpiry.getDate() - 1);
						expireexpiry.setTime(expireexpiry.getTime());				
						document.cookie = "brokebot_cookie_hide=yes; expires=" + expireexpiry.toGMTString();
						var cookie_engagement = false;
					}
				
				if ( (data.brokebot_cookie_hide === 1 && !brokebot_cookie_hide) || data.brokebot_cookie_hide === 0 || wasClosed) {

					

					var iframe = document.createElement('iframe');
					iframe.setAttribute('id', 'brokebot-frontend-widget-loader-wrapper');
					iframe.setAttribute('frameBorder',0);
                    iframe.setAttribute('class', 'brokebot-frontend-widget-loader-wrapper');
                    iframe.setAttribute('src', 'about:blank');
					document.body.appendChild(iframe);
					iframe.contentWindow.document.write(data.brokebot_markup);
					
					if (!runOnce) {
						var initialTimeout = 1500;
						var postTimeout = 1;
					} else {
						var initialTimeout = 1;
						var postTimeout = 0;
					}
					
					//animate in welcome
					setTimeout(function(){ 
						//TODO calculate height and width changes dynamically

						var buffer = 40;
						var icon_size_width = iframe.contentWindow.document.getElementById('brokebot_widget_icon').offsetWidth;
						var icon_size_height = iframe.contentWindow.document.getElementById('brokebot_widget_icon').offsetHeight;
						


						iframe = document.getElementById('brokebot-frontend-widget-loader-wrapper');
						

						iframe.contentWindow.document.getElementById('brokebot-frontend-widget-loader').classList.add('active');
						iframe.contentWindow.document.getElementById('brokebot-frontend-widget-loader').classList.remove('closed');
						
						if (!runOnce) {
							var commentbox = iframe.contentWindow.document.createElement('div');
							commentbox.setAttribute('class','commentbox-wrapper zoomInLeft');
							commentbox.id = 'brokebot-commentbox-wrapper';
							commentbox.innerHTML = '<span class="commentbox-arrow"></span>'+data.brokebot_welcome;


							iframe.contentWindow.document.body.appendChild(commentbox);

							iframe.style.width = '450px';
							iframe.style.height = '300px';

							var chat_size_width = iframe.contentWindow.document.getElementById('brokebot-commentbox-wrapper').offsetWidth;
							var chat_size_height = iframe.contentWindow.document.getElementById('brokebot-commentbox-wrapper').offsetHeight;

							console.log('w: '+(icon_size_width+chat_size_width+buffer) +'px');
							console.log('h: '+(icon_size_height+chat_size_height+buffer) + 'px');

							

							setTimeout(function(){ 
								iframe.style.width = (icon_size_width+chat_size_width+buffer) +'px';
								iframe.style.height = (icon_size_height+chat_size_height+buffer) + 'px';
							 }, 600);
						
						}

						//animate in broke counter
						setTimeout(function(){

							if (!runOnce) {
								var broke_counter = iframe.contentWindow.document.createElement('div');
								broke_counter.setAttribute('class','broke-counter');
								broke_counter.innerHTML = '<span>1</span>';
								iframe.contentWindow.document.body.appendChild(broke_counter);
							}
							var chatWindowClass = runOnce ? 'chatwindow post' : 'chatwindow';

							var _this = this;
							if (!runOnce) {runOnce = !runOnce;}

							//event binds
							$('#brokebot-frontend-widget-loader-wrapper').contents().find('#brokebot-frontend-widget-loader').click(function(){
								console.log('engage');

								if (cookie_engagement) {
									// set a new cookie
									var expiry = new Date();
									expiry.setTime(expiry.getTime()+(data.brokebot_cookie_days*24*60*60*1000));				
									document.cookie = "brokebot_cookie_hide=yes; expires=" + expiry.toGMTString();
								}
								

									if (!$('#brokebot-frontend-widget-loader-wrapper').hasClass('chat-active')) {
										$('#brokebot-frontend-widget-loader-wrapper').addClass('chat-active');
										var iframe = $('#brokebot-frontend-widget-loader-wrapper');
										var brokebot = $('#brokebot-frontend-widget-loader-wrapper').contents().find('#brokebot-frontend-widget-loader');
										iframe.contents().find('.broke-counter').hide();
										iframe.contents().find('.commentbox-wrapper').hide();

										iframe.css({'width':'300px','height':'400px' });

										brokebot.addClass('engaged');
										brokebot.append('<div class="chattitle">BrokeBot</div>');
										brokebot.append('<div class="chatclose"><div class="closeicon"></div></div>');
										if (data.brokebot_poweredby_optin == 1) {
											brokebot.append('<div class="chatfooter"><span>Built by BrokeBot</span><a class="footer-link footer-link-privacy" href="https://getbrokebot.com/privacy-policy">Privacy Policy</a></div>');
										} else {
											brokebot.append('<div class="chatfooter"></div>');
										}
										

										$('#brokebot-frontend-widget-loader-wrapper').contents().find('.chatclose').click(function(e){
											e.stopPropagation();
											console.log('close');
											$('#brokebot-frontend-widget-loader-wrapper').remove();
											$('#brokebot-frontend-widget-loader-wrapper').removeClass('chat-active');
											wasClosed = true;
											brokebot_initialize(data);
										})

										var chatEngaged = false;
										brokebot.one("transitionend",function(e) {


											console.log('load brokebot chat');
											// code to execute after transition ends

											brokebot.append('<div class="'+chatWindowClass+'"></div>').promise().done(function() {
												var chatwindow = $(this).find('.chatwindow');

													chatwindow.append('<div class="chat-item brokebot"><div class="chatauthor">BrokeBot</div><div class="chaticon"></div><div class="chattext">'+data.brokebot_welcome+'</div></div>');

													setTimeout(function(){
														chatwindow.append('<div class="chat-item-loader loader"><div class="loading"></div></div>');
													}, 200*postTimeout);

													setTimeout(function(){
														$('#brokebot-frontend-widget-loader-wrapper').contents().find('.chat-item-loader.loader').remove();
														chatwindow.append('<div class="chat-item brokebot"><div class="chatauthor">BrokeBot</div><div class="chaticon"></div><div class="chattext">'+data.brokebot_follow_up+'</div></div>');
													}, 2200*postTimeout);

													setTimeout(function(){
														chatwindow.append('<div class="chat-item-loader loader"><div class="loading"></div></div>');
													}, 2600*postTimeout);

													setTimeout(function(){

															if (data.brokebot_redirect_auto) {														
																
																$('#brokebot-frontend-widget-loader-wrapper').contents().find('.chat-item-loader.loader').remove();
																chatwindow.append('<div class="chat-item brokebot"><div class="chatauthor">BrokeBot</div><div class="chaticon"></div><div class="chattext">'+data.brokebot_cta_text+'</div></div>');
															
																setTimeout(function(){
																	window.location.replace(data.brokebot_redirect);
																}, 600*postTimeout);
															} else {
																$('#brokebot-frontend-widget-loader-wrapper').contents().find('.chat-item-loader.loader').remove();
																chatwindow.append('<div class="chat-button brokebot"><a href="'+data.brokebot_redirect+'" target="_parent">'+data.brokebot_cta_text+'</a></div>');
															}
													}, 5400*postTimeout);

											});
										});
											
									} //end if		
									

								


							});

							//redirect event (automatic or button)


						}, 150);

					}, initialTimeout);

				}//end brokebot cookie check

			}//end brokebot initialize




	});
})( jQuery );
