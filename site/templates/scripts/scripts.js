var loadingwheel = "<div class='la-ball-spin la-light la-3x'><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>";
var togglearray = {Y: 'on', N: 'off'};

var listener = new window.keypress.Listener();

$(document).ready(function() {
	// LISTENER
	$('input[type=text]').bind("focus", function() { listener.stop_listening(); }).bind("blur", function() { listener.listen(); });

	new Clipboard('.btn');

	/*==============================================================
	   INITIALIZE BOOTSTRAP FUNCTIONS
	=============================================================*/
		$('body').popover({selector: '[data-toggle="popover"]', placement: 'top'});


		initializedatepicker();



		$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});


		$('body').on('click', function (e) {
			$('[data-toggle="popover"]').each(function () {
				//the 'is' for buttons that trigger popups
				//the 'has' for icons within a button that triggers a popup
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
					$(this).popover('hide');
				}
			});
		});

		$(config.modals.lightbox).on('show.bs.modal', function (event) {
			var image = $(event.relatedTarget).find('img');
			var source = image.attr('src');
			var desc = image.data('desc');
			var modal = $(this);
			modal.find('.lightbox-image').attr('src', source);
			modal.find('.description').text(desc);
		});

		$(config.modals.ajax).on('shown.bs.modal', function (event) {
			initializedatepicker();
		});

		$(config.modals.pricing).on('shown.bs.modal', function (event) {
			initializedatepicker();
			$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});
		});

		$(config.modals.lightbox).on('shown.bs.modal', function (event) {
			makeshadow();
		});
		$(config.modals.lightbox).on('hide.bs.modal', function (event) {
			removeshadow();
		});



	/*==============================================================
	   PAGE SCROLLING FUNCTIONS
	=============================================================*/
		$(window).scroll(function() {
			if ($(this).scrollTop() > 50) { $('#back-to-top').fadeIn(); } else { $('#back-to-top').fadeOut(); }
		});

		// scroll body to 0px on click
	   $('#back-to-top').click(function () {
		   $('#back-to-top').tooltip('hide');
		   $('body,html').animate({ scrollTop: 0 }, 800);
		   return false;
	   });

	/*==============================================================
	   YOUTUBE NAVIGATION
	=============================================================*/
		$('.yt-menu-open').on('click', function(e) { //Youtube-esque navigation
			e.preventDefault();
			$('#yt-menu').toggle();
			$(this).toggleClass('menu-open');
			if ($(this).data('function') === 'show') {
				$(this).data('function', "hide").css({"background-color":"#242F40", "color": "#f8f8f8"});
			} else {
				$(this).data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$('.slide-menu-open').on('click', function(e) { //Youtube-esque navigation
			e.preventDefault();

			$('#slide-menu').toggle().animatecss('fadeInLeft');
			$(this).toggleClass('menu-open');
			if ($(this).data('function') === 'show') {
				//$("<div class='modal-backdrop fade in'></div>").appendTo('body');
				$(this).data('function', "hide").css({"background-color":"#242F40", "color": "#f8f8f8"});
			} else {
				//$('body').find('.modal-backdrop.fade.in').remove();
				$(this).data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$(document).mouseup(function (e) {
			var container = $("#yt-menu");
			if (!container.is(e.target) && container.has(e.target).length === 0) {
				 $('#yt-menu').hide();
				 $('.yt-menu-open').data('function', "show").removeClass('menu-open').css({"background-color":"", "color": ""});
			}
		});

		$(config.toolbar.button).click(function() {
			if ($(config.toolbar.toolbar).is(":hidden")) {
				showtoolbar();
			} else {
				hidetoolbar();
			}
		});

	/*==============================================================
	  FORM FUNCTIONS
	=============================================================*/
		$("body").on("click", ".dropdown-menu .searchfilter", function(e) {
			e.preventDefault();
			var inputgroup = $(this).closest('.input-group');
			var param = $(this).attr("href").replace("#","");
			var concept = $(this).text();
			inputgroup.find('span.showfilter').text(concept);
			inputgroup.find('.search_param').val(param);
		});

		$("body").on("click", ".select-button-choice", function(e) {
			e.preventDefault();
			var tasktype = $(this).data('value');
			$(".select-button-choice").removeClass("btn-primary");
			$(this).parent().find('.select-button-value').val(tasktype);
			$(this).addClass("btn-primary");
		});

		$(".page").on("change", ".results-per-page-form .results-per-page", function() {
			var form = $(this).closest("form");
			var ajax = form.hasClass('ajax-load');
			var href = getpaginationurl(form);
			console.log(href);
			if (ajax) {
				var loadinto = form.data('loadinto');
				var focuson = form.data('focus');
				href = addtoquerystring(getpaginationurl(form), ["ajax"], ["true"]);
				loadin(href, loadinto, function() { if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000);} });
			} else {
				window.location.href = href;
			}

		});

	/*==============================================================
	  AJAX LOAD FUNCTIONS
	=============================================================*/
		$("body").on("click", ".load-link", function(e) {
			e.preventDefault();
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var url = addtoquerystring($(this).attr('href'), ["ajax"], ["true"]);
			console.log(loadinto);
			loadin(url, loadinto, function() {
				if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});
			});
		});

		$(".page").on("click", ".load-into-modal", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			var url = addtoquerystring(ajaxloader.url, ["ajax"], ["true"]);
			loadin(url, ajaxloader.loadinto, function() {
				$(ajaxloader.modal).modal();
			});
		});

		$("body").on("click", ".generate-load-link", function(e) { //MADE TO REPLACE $(.load-detail).click()
			e.preventDefault();
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var geturl = $(this).attr('href');
			console.log(geturl);
			$.get(geturl, function() {
				generateurl(function(url) {
					console.log('url = ' + addtoquerystring(url, [],[]));
					loadin(addtoquerystring(url, [], []), loadinto, function() {
						if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
					});
				});
			});
		});



	/*==============================================================
	  ORDER LIST FUNCTIONS
	=============================================================*/
		$(".page").on("click", ".edit-order", function(e) {
			e.preventDefault();
			var href = $(this).attr('href');
			console.log(href);
			$.get(href, function() {
				generateurl(function(url) {
					console.log(url);
					window.location.href = url;
				});
			});
		});

		$(".page").on("click", ".load-cust-orders", function(event) { //Changed from #load-cust-orders
			event.preventDefault();
			var loadinto = $(this).data('loadinto');
			var geturl = $(this).attr('href');
			var focuson = $(this).data('focus');
			console.log(geturl);
			$.get(geturl, function() {
				generateurl(function(url) {
				console.log(url);
					loadin(addtoquerystring(url, ["ajax"], ["true"]), loadinto, function() {
						if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
					});
				});
			});
		});

		$("body").on("click", ".search-orders", function(e) {
			e.preventDefault();
			console.log('clicked');
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			loadin(ajaxloader.url, ajaxloader.loadinto, function() { $(ajaxloader.modal).modal(); });
		});

		$("body").on("submit", "#order-search-form", function(e)  {
			e.preventDefault();
			var form = "#"+$(this).attr('id');
			var loadinto = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var modal = $(this).data('modal');
			postform(form, false, false, function() { //form, overwriteformdata, returnjson, callback
				wait(500, function() {
					generateurl(function(url) {
						loadin(addtoquerystring(url, ["ajax"], ["true"]), loadinto, function() {
							$(modal).modal('hide');  if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
						});
					 });
				});

			});

		});

		$("body").on("submit", ".item-reorder", function(e) {
			e.preventDefault();
			var form = new itemform($(this));
			var msg = "You added " + form.qty + " of " + form.desc + " to the cart";
			postformsync(form.formid, function() {
				$.notify({
					icon: "glyphicon glyphicon-shopping-cart",
					message: msg +"<br> (Click this Message to go to the cart.)" ,
					url: config.urls.cart,
					target: '_self'
				},{
					type: "success",
					url_target: '_self'
				});
			});
		});

	/*==============================================================
	  ADD ITEM MODAL FUNCTIONS
	=============================================================*/
		$("body").on("submit", ".add-and-edit-form", function(e) { //FIX MAKE IT JUST AJAX ADD ALSO FIX REGULAR ADD ITEM
			//WAS .add-to-order-form | MODIFIED TO SUIT BOTH QUOTES AND ORDERS
			e.preventDefault();
			var form = $(this);
			var addto = form.data('addto');
			var itemid = form.find('input[name="itemid"]').val();
			var custid = form.find('input[name="custID"]').val();
			var loadinto = config.modals.pricing+" .modal-body";
			var parentmodal = $(this).closest('.modal');
			var editurl = '';
			var jsonurl = '';
			$(parentmodal).modal('hide');
			showajaxloading();

			if (addto == 'order') {
				var ordn = form.find('input[name="ordn"]').val();
				jsonurl = config.urls.json.getorderdetails+"?ordn="+ordn;
			} else if (addto == 'quote') {
				var qnbr = form.find('input[name="qnbr"]').val();
				jsonurl = config.urls.json.getquotedetails+"?qnbr="+qnbr;
			}
			var uri = new URI();
			uri.addQuery('show', 'details');

			$('#'+form.attr('id')).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				$.getJSON(jsonurl, function(json) {
					if (addto == 'order') {
						linenumber = json.response.orderdetails.length+1;
						editurl = config.urls.load.editdetail+"order/?ordn="+ordn+"&line="+linenumber;
					} else if (addto == 'quote') {
						linenumber = json.response.quotedetails.length+1;
						editurl = config.urls.load.editdetail+"quote/?qnbr="+ordn+"&line="+linenumber;
					}
					loadin(uri.toString()+"#edit-page", '.page', function() {
						edititempricing(itemid, custid,  function() {
							loadin(editurl, loadinto, function() {
								hideajaxloading();
								$(config.modals.pricing).modal();
								setchildheightequaltoparent('.row.row-bordered', '.grid-item');
							});
						});
					});

				});
			});
		});

		$('#add-item-modal').on('show.bs.modal', function(event) {
			var button = $(event.relatedTarget);
			var addtype = button.data('addtype'); // order|cart|quote
			var linenumber = 1;
			if (button.attr('data-linenumber')) {
				linenumber = button.data('linenumber');
			}
			var modal = $(this);
			var title = ''; var addonurl = '';
			var custid = button.data('custid');
			switch (addtype) {
				case 'cart':
					$('#'+modal.attr('id')+ " .custid").val(custid);
					title = "Add item to Cart";
					addonurl = "cart/?custID="+urlencode(custid);

					break;
				case 'order':
					var ordn = button.data('ordn');
					$('#'+modal.attr('id')+ " .custid").val(custid);
					title = "Add item to Order #" + ordn;
					addonurl = "order/?ordn="+ordn+"&custID="+urlencode(custid);

					break;
				case 'quote':
					var qnbr = button.data('qnbr');
					$('#'+modal.attr('id')+ " .custid").val(custid);
					title = "Add item to Quote #" + qnbr;
					addonurl = "quote/?qnbr="+qnbr+"&custID="+urlencode(custid);
					break;
			}
			$('#add-item-modal-label').text(title);
			addonurl += "&linenumber="+linenumber;
			$('#'+modal.attr('id')+ " .addonurl").val(addonurl);
			$('#'+modal.attr('id')+ " .linenumber").val(linenumber);

		});

		$('#add-item-modal').on('shown.bs.modal', function() {
			$('#add-item-modal .searchfield').focus();
		});

		$("body").on("submit", "#add-item-search-form", function(e) {
			e.preventDefault();
			var formid = "#add-item-search-form";
			var url = config.urls.load.productresults;
			var addonurl = $(formid+ " .addonurl").val();
			console.log(url+addonurl);
			$(formid).postform({formdata: false, jsoncallback: false}, function() { //{formdata: data/false, jsoncallback: true/false}
				wait(500, function() {
					loadin(addtoquerystring(url+addonurl, ["ajax"], ["true"]), '#add-item-modal .results', function() {
					});
				});
			});
		});

		$("body").on("keyup", ".ii-item-search", function() {
			//if ($(this).val().length > 3) {
				var thisform = $(this).closest('form');
				var href = thisform.attr('action')+"?q="+urlencode($(this).val());
				console.log(href);
				var loadinto = '#item-results';
				loadin(href, loadinto, function() {

				});
			//}
		});

		$("body").on("keyup", ".ci-item-search", function() {
			//if ($(this).val().length > 3) {
				var href = $(this).data('results')+'?q='+urlencode($(this).val());
				console.log(href);
				var loadinto = '#item-results';
				loadin(href, loadinto, function() {

				});
			//}
		});

		$("body").on("keyup", ".ci-cust-search", function() {
			//if ($(this).val().length > 3) {
				var thisform = $(this).closest('form');
				var href = thisform.attr('action')+"?q="+urlencode($(this).val());
				console.log(href);
				var loadinto = '#cust-results';
				loadin(href, loadinto, function() {

				});
			//}
		});

	/*==============================================================
	  TASK FUNCTIONS
	=============================================================*/
		$(".page").on("change", "#view-completed-tasks", function(e) {
			e.preventDefault();
			var element = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var url = '';
			if ($(this).is(':checked')) {url = addtoquerystring($(this).data('url'), ["completed"], ["true"]); } else { url = $(this).data('url');}
			console.log(url);
			loadin(addtoquerystring(url, ["ajax"], ["true"]), element, function() {
				if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});
			});
		});

		$(".page").on("change", "#view-completed-tasks", function(e) {
			e.preventDefault();
			var element = $(this).data('loadinto');
			var focuson = $(this).data('focus');
			var url = '';
			if ($(this).is(':checked')) {url = addtoquerystring($(this).data('url'), ["completed"], ["true"]); } else { url = $(this).data('url');}
			console.log(url);
			loadin(addtoquerystring(url, ["ajax"], ["true"]), element, function() {
				if (focuson.length > 0) { $('html, body').animate({scrollTop: $(focuson).offset().top - 60}, 1000); }
				$('.check-toggle').bootstrapToggle({on: 'Yes', off: 'No', onstyle: 'info'});
			});
		});

		$(".page").on("click", ".load-task-item", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			showajaxloading();
			console.log(ajaxloader.url);
			wait(500, function() { loadin(ajaxloader.url, ajaxloader.loadinto, function() { $(ajaxloader.modal).resizemodal('lg'); hideajaxloading(); $(ajaxloader.modal).modal(); $('.task-popover').popover('hide');}); });
		});

		$("body").on("click", ".complete-task", function(e) {
			e.preventDefault();
			var button = $(this);
			var url = button.attr('href');
			var taskid = button.data('id');
			console.log(config.urls.json.get_task+"?id="+taskid);
			$.getJSON(config.urls.json.get_task+"?id="+taskid, function(json) {
				swal({
					title: "Would you like to confirm this task as complete?",
					text: json.response.textbody,
					type: "success",
					showCancelButton: true,
					confirmButtonText: "Yes",
					closeOnConfirm: true
				},
				function() {
					$.get(url, function() { $('.tasks-refresh').click(); });
				});
			});
		});

		$("body").on("submit", "#new-task-form", function(e) {
			e.preventDefault();
			var form = $(this);
			var modal = form.data('modal');
			var formid = "#"+$(this).attr('id');
			var elementreload = form.data('refresh');
			var isformcomplete = form.formiscomplete('tr');
			if (isformcomplete) {
				$(formid).postform({formdata: false, jsoncallback: true}, function(json) {
					$.notify({
						icon: json.response.icon,
						message: json.response.message,
					},{
						element: modal + " .modal-body",
						type: json.response.notifytype,
						placement: {
							from: "top",
							align: "center"
						},
						onClose: function() {
							wait(500, function() {
								$(elementreload + " .tasks-refresh").click();
								$(modal).modal('hide');
								swal({
									title: "Your task was created!",
									text: "Would you like to create a note for this task?",
									type: "success",
									showCancelButton: true,
									confirmButtonText: "Yes, create Note",
									closeOnConfirm: true
								},
								function() {
									var href = addtoquerystring($('#notes-panel .add-note').attr('href'), ['task'], [json.response.taskid]);
									$('#notes-panel .load-crm-note').attr('href', href).click();
									var url = URI($('#tasks-panel .add-new-task').attr('href')).removeSearch("noteID").normalizeQuery();
									$('#tasks-panel .add-new-task').attr('href', url.toString());
								});
							});
						}
					});
				});
			} else {

			}
		});

		function loaditemdocument(doc) {
			var href = config.urls.json.ii_moveitemdoc + "?docnumber="+doc;
			$.getJSON(href, function(json) {
				if (json.response.error) {

				} else {
					var td = $(".doc-"+doc).find('.load-doc').parent();
					td.find('.load-doc').remove();
					var href = "<a href='"+config.urls.orderfiles+json.response.file+"' class='btn btn-sm btn-success' target='_blank'><i class='fa fa-file-text' aria-hidden='true'></i> View Document</a>";
					$(href).appendTo(td);
				}
			});
		}



	/*==============================================================
	  CRM NOTE FUNCTIONS
	=============================================================*/
		$(".page").on("click", ".load-notes", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			$.get(ajaxloader.url, function() {
				showajaxloading();
				generateurl(function(url) {
					wait(500, function() { loadin(url, ajaxloader.loadinto, function() { $(ajaxloader.modal).resizemodal('lg'); $(ajaxloader.modal).modal(); hideajaxloading(); }); });
				});
			});
		});

		$(".page").on("click", ".load-crm-note", function(e) {
			e.preventDefault();
			var button = $(this);
			var ajaxloader = new ajaxloadedmodal(button);
			showajaxloading();
			console.log(ajaxloader.url);
			wait(500, function() {
				loadin(ajaxloader.url, ajaxloader.loadinto, function() {
					$(ajaxloader.modal).resizemodal('lg'); $(ajaxloader.modal).modal(); hideajaxloading(); $(ajaxloader.modal).find('.note').focus();
				});
			});
		});

		$("body").on("submit", "#crm-note-form", function(e) {
			e.preventDefault();
			var form = $(this);
			var modal = form.data('modal');
			var formid = "#"+$(this).attr('id');
			var elementreload = form.data('refresh');
			$(formid).postform({formdata: false, jsoncallback: true}, function(json) {
				$.notify({
					icon: json.response.icon,
					message: json.response.message,
				},{
					element: modal + " .modal-body",
					type: "success",
					url_target: '_self',
					placement: {
						from: "top",
						align: "center"
					},
					onClose: function() {
						wait(200, function() {
							$(elementreload + " .notes-refresh").click();
							$(modal).modal('hide');
							swal({
								title: "Your note was created!",
								text: "Would you like to create a task for this note?",
								type: "success",
								showCancelButton: true,
								confirmButtonText: "Yes, create task",
								closeOnConfirm: true
							},
							function() {
								newnoteurl = URI($('#notes-panel .add-note').attr('href')).removeSearch("task").normalizeQuery();
								$('#notes-panel .add-note').attr('href', newnoteurl.toString());
								var url = URI($('#tasks-panel .add-new-task').attr('href')).addSearch("noteID", json.response.noteid).normalizeQuery();
								$('#tasks-panel .add-new-task').attr('href', url.toString());
								$('#tasks-panel .add-new-task').click();
							});
						});
					}
				});
			});
		});


	/*==============================================================
 		EDIT LINE ITEM FUNCTIONS
	=============================================================*/
		$(".page").on("click", ".update-line", function(e) {
			e.preventDefault();
			showajaxloading();
			var url = addtoquerystring($(this).attr('href'), [], []);
			var itemid = $(this).data('itemid');
			var custid = $(this).data('custid');

			if ($.inArray(itemid, nonstockitems) > -1) {
				console.log('skipping item get');
				loadin(url, config.modals.pricing+" .modal-body", function() {
					hideajaxloading();
					$(config.modals.pricing).modal();
				});
			} else {
				edititempricing(itemid, custid,  function() {
					console.log(url);
					loadin(url, config.modals.pricing+" .modal-body", function() {
						hideajaxloading();
						$(config.modals.pricing).modal();
						setchildheightequaltoparent('.row.row-bordered', '.grid-item');
					});
				});
			}
		});

	/*==============================================================
 		CHANGE CUSTOMER MODAL
	=============================================================*/


		$("body").on("submit", "#cust-index-search", function(e) {
			e.preventDefault();
			var form = $(this);
			var modal = form.data('modal');
			var formid = "#"+$(this).attr('id');
			var query = $(formid + " .query").val();
			var sourcepage = $(formid + " .sourcepage").val();
			var dplusfunction = $(formid + " .function").val();
			var action = form.attr('action');
			var loadinto = modal+" .modal-content";
			loadin(addtoquerystring(action, ["q", "source", "function"], [urlencode(query), urlencode(sourcepage), dplusfunction]), loadinto, function() {

			});
		});


});

/*==============================================================
 	AJAX FUNCTIONS
=============================================================*/
	function wait(time, callback) {
		var timeoutID = window.setTimeout(callback, time);
	}

	function generateurl(callback) {
		console.log(config.urls.json.getloadurl);
		$.getJSON(config.urls.json.getloadurl, function(json) {
			callback(json.response.url);
		});
	}

 	function showajaxloading() {
		var close = makeajaxclose("hideajaxloading()");
		var loadingdiv = "<div class='loading'>"+loadingwheel+"</div>";
		$("<div class='modal-backdrop tribute loading-bkgd fade in'></div>").html(close+loadingdiv).appendTo('body');
		listener.simple_combo("esc", function() { hideajaxloading(); });
	}

	function hideajaxloading() {
		$('body').find('.loading-bkgd').remove();
		listener.unregister_combo("esc");
	}

	function makeshadow() {
		$('body').find('.modal-backdrop').addClass('darkAmber').removeClass(config.modals.gradients.default).css({'z-index':'20'});;
	}

	function removeshadow() {
		$('body').find('.modal-backdrop').addClass(config.modals.gradients.default).removeClass('darkAmber').css({'z-index':'15'});;
	}

	function loadin(url, element, callback) {
		var parent = $(element).parent();
		$(element).remove();
		parent.load(url, function() { callback(); });
	}

	function loadreplace(url, element, callback) {
		$(element).load(url, function() {
			callback();
		});
	}

	/*function postform(form, callback) {
		console.log('submitting ' + form);
		var action = $(form).attr('action');
		$.post(action, $(form).serialize()).done(callback());
	}
*/
	function postform(form, formdata, returnjson, callback) {
		console.log('submitting ' + form);
		$(form).postform({formdata: formdata, jsoncallback: returnjson}, callback);

	}

	jQuery.fn.postform = function(options, callback) { //{formdata: data/false, jsoncallback: true/false}
		var form = $(this);
		var action = form.attr('action');
		console.log('submitting ' + form.attr('id'));
		if (!options.formdata) {options.formdata = form.serialize(); }
		if (options.jsoncallback) {
			$.post(action, options.formdata, function(json){callback(json);});
		} else {
			$.post(action, options.formdata).done(callback());
		}
	}

	function postformsync(form, callback) {
		console.log('submitting ' + form);
		var action = $(form).attr('action');
		$.ajax({async: false, url: action, method: "POST", data: $(form).serialize()}).done(callback());
	}

	(function ( $ ) {
		// Pass an object of key/vals to override
		$.fn.serializeform = function(overrides) {
			// Get the parameters as an array
			var newParams = this.serializeArray();

			for(var key in overrides) {
				var newVal = overrides[key]
				// Find and replace `content` if there
				for (index = 0; index < newParams.length; ++index) {
					if (newParams[index].name == key) {
						newParams[index].value = newVal;
						break;
					}
				}

				// Add it if it wasn't there
				if (index >= newParams.length) {
					newParams.push({
						name: key,
						value: newVal
					});
				}
			}

			// Convert to URL-encoded string
			return $.param(newParams);
		}
	}( jQuery ));

	function getpaginationurl(form) {
		var showonpage = form.find('.results-per-page').val();
		var displaypage = form.attr('action');
		return addtoquerystring(displaypage, ['display'], [showonpage]);
	}

/*==============================================================
 	TOOLBAR FUNCTIONS
=============================================================*/
	function showtoolbar() {
		var close = makeajaxclose("hidetoolbar()");
		$("<div class='modal-backdrop toolbar fade in'></div>").html(close).appendTo('body');
		$(config.toolbar.toolbar).removeClass('zoomOut').show().animatecss('bounceInLeft');
		$(config.toolbar.button).find('span').removeClass('glyphicon glyphicon-plus').addClass('glyphicon glyphicon-minus');
	}

	function hidetoolbar() {
		$('body').find('.modal-backdrop.toolbar.fade.in').remove();
		$(config.toolbar.toolbar).removeClass('bounceInLeft').hide(1000).animatecss('zoomOut');
		$(config.toolbar.button).find('span').removeClass('glyphicon glyphicon-minus').addClass('glyphicon glyphicon-plus');
	}

/*==============================================================
 	URL FUNCTIONS
=============================================================*/
	function urlencode(str) {
		return encodeURIComponent(str);
	}

	function addtoquerystring(url, keys, values) {
		var uri = new URI(url);
		for (var i = 0; i < keys.length; i++) {
			if (values[i]) {
				uri.addQuery(keys[i], values[i]);
			} else {
				uri.removeQuery(keys[i]);
			}
		}
		uri.normalizeQuery();
		return uri.toString();
	}

	var cleanparams = function(data) {
		var result = {};
		Object.keys(data).filter(function(key) {
			return Boolean(data[key]) && data[key].length;
		}).forEach(function(key) {
			result[key] = data[key];
		});
		return result;
	};


/*==============================================================
 	CUST INDEX FUNCTIONS
=============================================================*/
	function pickcustomer(custid, row, sourcepage) {
		var loadinto = config.modals.ajax + ' .modal-content';
        var url = config.urls.customer.load.loadindex+urlencode(custid)+'/?source='+urlencode(sourcepage);
		console.log(url);
        loadin(url, loadinto, function() {  });
    }

	function opencustindexmodal(dplusfunction, source) {
		var loadinto = config.modals.ajax + ' .modal-content';
		var url = config.urls.customer.load.loadindex+'?function='+dplusfunction+'&source='+urlencode(source);
		console.log(url);
		loadin(url, loadinto, function() { $(config.modals.ajax).modal();  });
	}


/*==============================================================
   ITEM FUNCTIONS
=============================================================*/
	function chooseitemwhse(itemid, whse) { // TODO
		var form = '#'+itemid+"-form";
		var whsefield = '.'+itemid+'-whse';
		var whserow = '.'+whse+"-row";
		$(form+" .item-whse-val").text(whse).parent().show();
		$(whsefield).val(whse);
		$('.warning').removeClass('warning');
		$(whserow).addClass('warning');
	}

	function edititempricing(itemid, custid, callback) {
		var url = config.urls.products.redir.getitempricing+"&itemid="+urlencode(itemid)+"&custID="+urlencode(custid);
		console.log(url);
		$.get(url, function() { callback(); });
	}

	$(".page").on("click", ".view-item-details", function(e) {
	   e.preventDefault();
	   var button = $(this);
	   var url = addtoquerystring(button.attr('href'), [], []);

	   console.log(url);
	   if (button.data('kit') == 'Y') {
		   var itemid = button.data('itemid');
		   var qty = 1;
		   ii_kitcomponents(itemid, qty, function() {
			   loadin(url, config.modals.ajax+" .modal-body", function() {
				  $(config.modals.ajax).resizemodal('lg');
				  $(config.modals.ajax).modal();
			  })
		   });
	   } else {
		   loadin(url, config.modals.ajax+" .modal-body", function() {
			   $(config.modals.ajax).resizemodal('lg');
			   $(config.modals.ajax).modal();
		   });
	   }

	 });

	 function ii_kitcomponents(itemid, qty, callback) {
 		var url = config.urls.products.redir.ii_kitcomponents+"&itemid="+urlencode(itemid)+"&qty="+urlencode(qty);
 		$.get(url, function() { callback(); });
 	}

/*==============================================================
 	SALES ORDER FUNCTIONS
=============================================================*/
	function reorder() {
		var forms = new Array();
		$(".item-reorder").each(function( index ) {
			if ($(this).find('input[name="qty"]').val().length > 0) {
				forms.push($(this).attr('id'));
			}
		});

		var ajaxcalls = forms.length;
		var counter = 0;
		var ajaxcomplete = function() { counter++; if (counter >= ajaxcalls) {console.log('finished with ajax calls'); } };

		for (var i = 0; i < forms.length; i++) {
			var form = new itemform($("#"+forms[i]));
			postformsync(form.formid, function(){
				$.notify({
					// options
					title: '<strong>Success</strong>',
					message: 'You added ' + form.qty + ' of ' + form.itemid + ' to the cart'
				},{
					element: "body",
					type: "warning",
					delay: 2500,
					timer: 1000,
					onClosed: function() {
						ajaxcomplete();
					},
				});
			});
		}

	}

/*==============================================================
 	STRING FUNCTIONS
=============================================================*/
	function getordinalsuffix(i) {
		var j = i % 10, k = i % 100;
		if (j == 1 && k != 11) { return i + "st"; }
		if (j == 2 && k != 12) { return i + "nd"; }
		if (j == 3 && k != 13) { return i + "rd"; }
		return i + "th";
	}

	Number.prototype.formatMoney = function(c, d, t) {
		var n = this,
		    c = isNaN(c = Math.abs(c)) ? 2 : c,
		    d = d == undefined ? "." : d,
		    t = t == undefined ? "," : t,
		    s = n < 0 ? "-" : "",
		    i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
		    j = (j = i.length) > 3 ? j % 3 : 0;
		   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };

/*==============================================================
 	FORM FUNCTIONS
=============================================================*/


	function comparefieldvalues(field1, field2) {
		if ($(field1).val() == $(field2).val()) { return true; } else { return false; }
	}


/*==============================================================
 	CONTENT FUNCTIONS
=============================================================*/
	jQuery.fn.resizemodal = function(size) {
		$(this).children('.modal-dialog').removeClass('modal-xl').removeClass('modal-lg').removeClass('modal-sm').removeClass('modal-md').removeClass('modal-xs').addClass('modal-'+size);
		return $(this);
	};

	jQuery.fn.formiscomplete = function(highightelement) {
		var form = $(this);
		var missingfields = new Array();
		form.find('.has-error').removeClass('has-error');
		form.find('.response').empty();

		form.find('.required').each(function() {
			if ($(this).val() === '') {
				var row = $(this).closest(highightelement);
				row.addClass('has-error');
				missingfields.push(row.find('.control-label').text());
			}
		});

		if (missingfields.length > 0) {
			var message = 'Please Check the following fields: <br>';
			for (var i = 0; i < missingfields.length; i++) {
				message += missingfields[i] + "<br>";
			}
			createalertpanel('#'+form.attr('id') + ' .response', message, "<span class='glyphicon glyphicon-warning-sign'></span> Error! ", "danger");
			$('html, body').animate({scrollTop: $('#'+form.attr('id') + ' .response').offset().top - 120}, 1000);
			return false;
		} else {
			return true;
		}


	};

	$.fn.extend({
		animatecss: function (animationName) {
			var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			this.addClass('animated ' + animationName).one(animationEnd, function() {
				$(this).removeClass('animated ' + animationName);
			});
			return $(this);
		}
	});

	function createalertpanel(location, alert_message, exclamation, alert_type) {
		var alertheader = '<div class="alert alert-'+alert_type+' alert-dismissible" role="alert">';
		var closebutton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		var message = '<strong>'+exclamation+'</strong> ' + alert_message
		var closeheader = '</div>';
		var thealert = alertheader + closebutton + message + closeheader;
		$(location).html(thealert);
	}

	function setequalheight(container) {
		var height = 0;
		$(container).each(function() {
			if ($(this).actual( 'height' ) > height) {
				height = $(this).actual( 'height' );
			}
		});
		$(container).height(height);
	}

	function setchildheightequaltoparent(parent, child) {
		$(parent).each(function() {
			var parentheight = $(this).actual('height');
			$(this).find(child).height(parentheight);
		});
	}

	function makeajaxclose(onclick) {
		return '<div class="close"><a href="#" onclick="'+onclick+'"><i class="material-icons md-48 md-light"></i></a></div>';
	}

	function initializedatepicker() {
		$('.datepicker').each(function(index) {
			$(this).datepicker({
				date: $(this).find('.date-input').val(),
				 allowPastDates: true,
			});
		})
	}
