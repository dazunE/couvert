(function( $ ) {

	'use strict';

	 var AjaxUrl 		= '/wp-admin/admin-ajax.php',
	     dateTime		= $('.select-date').pickadate(),
	 	 resturentId 	= $('.couvert-reservation__inner').data('resturent'),
	 	 apiKey 		= $('.couvert-reservation__inner').data('apikey');
	 	 

	$( window ).load(function() {

		$.post(
				AjaxUrl,{
					action:'couvert_get_resturent_data',
					resturentID:resturentId,
					apikey:apiKey,
				},

				function( response ){

					console.log(response);
				}

			)

	});

	if($('.select-date').length > 0 ){

		$(function() {

			var dateInput = dateTime.pickadate('picker');

			 dateInput.on('set' , function(){

				 var date 	= parseInt(dateInput.get('select').date),
			 	     month 	= parseInt(dateInput.get('select').month + 1),
			 	     year	= parseInt(dateInput.get('select').year);

			 	 $('.loader').removeClass('hidden');
			 	 $('.couvert_intro i').remove();

					$.post(
						AjaxUrl,{
							action:'couvert_config_for_day',
							resturentID:resturentId,
							apikey:apiKey,
							year:year,
							month:month,
							day:date
						} ,

						function ( response ){

							var configData  = JSON.parse(response),
								maxHead		= configData.GroupReservationFromNumberOfPeople + 1,
								groupRes    = configData.IsGroupReservationAllowed,
								minHead 	= configData.MinimumNumberOfPeople,
								isClosed	= configData.IsRestaurantClosed,
								resBefore	= configData.GroupReservationMinimumMinutesBefore,
								message		= configData.Message;

								if(message){

									$('.couvert_intro').append('<i>'+message+'</i>');
								}

								if(isClosed){

									$('.couvert_intro').append('<i>Sorry..! Resturent is closed on selected date </i>');
									$('#persons-count').empty();
									return false;

								} else{

									$('#persons-count').empty();

									for (var i = minHead ; i < maxHead; i++) {
										
										$('#persons-count').append('<option value="'+i+'">'+i+' Person </option>');
									}

								}

								if(minHead > 0 ) {

									$('#persons-count').prop("disabled", false);
								}

								$('.loader').addClass('hidden');
						}
					);
			})

			$('#time-avialbility').on('click', function (){

				$('.loader').removeClass('hidden');
				$('.time-slots input').remove();
				$('.time-slots label').remove();
				$('.time-slots p').remove();

				var	 date 			= parseInt(dateInput.get('select').date),
				 	 month 			= parseInt(dateInput.get('select').month + 1),
				 	 year			= parseInt(dateInput.get('select').year),
				 	 perosns 		= parseInt($('#persons-count').val());


					$.post( 
						AjaxUrl,
						{
							action:'couvert_time_avilability',
							resturentID:resturentId,
							apikey:apiKey,
							numPersons:perosns,
							year:year,
							month:month,
							day:date
						} ,

						function(response){

							if ( response != ""){

								$('.loader').addClass('hidden');
								$('#time-avialbility').addClass('hidden');
								$('.time-slot_wrapper label').removeClass('hidden');
								$('#ready-reservation').removeClass('hidden');

								var bDate = $('.birth-date').pickadate({
									selectYears: true,
	  								selectYears:100
								});

								var timeSlots = JSON.parse(response).Times;

								timeSlots.forEach( function(e){

									var Hour = e.Hours,
										Min  = e.Minutes,
										Val  = Hour+'.'+Min,
										Name = Hour+'-'+Min;
									
									if(Min == 0){

										var Time = Hour+':'+Min+'0';

									} else{

										var Time = Hour+':'+Min;
									}
				




									
									$('.time-slots').append('<input type="radio" id="radio-'+Name+'"  name="radio" value="'+Val+'"><label  data-min="'+Min+'" data-hour="'+Hour+'" for="radio-'+Name+'">'+Time+'</label>');

								});

							} else{

								$('.time-slots').append('<p>There is an error connecting to the server</p>');
								$('.loader').addClass('hidden');
							}

							
						}
					);
			});

			$('#ready-reservation').on('click' , function(){

				$('.loader').removeClass('hidden');

				var	 date 	  = parseInt(dateInput.get('select').date),
				 	 month 	  = parseInt(dateInput.get('select').month + 1),
				 	 year	  = parseInt(dateInput.get('select').year),
				 	 perosns  = parseInt($('#persons-count').val()),
				 	 time 	  = $("input[type='radio']:checked + label"),
				 	 min	  = parseInt(time.data('min')),
				 	 hour 	  = parseInt(time.data('hour'));
				 	 

				 	 $.post( 
						AjaxUrl,
						{
							action:'couvert_get_input_fields',
							resturentID:resturentId,
							apikey:apiKey,
							year:year,
							month:month,
							day:date,
							hours:hour,
							minutes:min
						} ,

						function ( response ){

							if ( 'respones' != "") {

							 $('.loader').addClass('hidden');
							 $('.reservation-from').removeClass('hidden');
							 $('#make-reservation').removeClass('hidden');
							 $('#ready-reservation').addClass('hidden');

							 var formConfig = JSON.parse(response),
							     restData 	= formConfig.RestaurantSpecificFields;
							     
							     $.each( restData , function( e , val ){

							     	if(val.Title.English == "High Tea"){

							     		$('.resturent-fields').find('div.high-tea label').html(val.Title.Dutch);
							     		$('.resturent-fields').data('hight-tea' ,val.Id );

							     	} else if ( val.Title.English == "Picknick"){

							     		$('.resturent-fields').find('div.pick-nick label').html(val.Title.Dutch);
							     		$('.resturent-fields').data('pick-nick' ,val.Id );

							     	} else {

							     		$('.resturent-fields').find('div.brunch label').html(val.Title.Dutch);
							     		$('.resturent-fields').data('brunch' ,val.Id );

							     	}

							     });
							}
						}
					);
			});

			$('#make-reservation').on('click' , function (){

				var _this = $(this);

					$('.loader').removeClass('hidden');
					$('.reservaton-message').empty();

					var firstName 	= $('.first-name').val(),
						lastName	= $('.last-name').val(),
						email 		= $('.email-add').val(),
						phone		= $('.phone-number').val(),
						date 	  	= parseInt(dateInput.get('select').date),
					 	month 	  	= parseInt(dateInput.get('select').month + 1),
					 	year	  	= parseInt(dateInput.get('select').year),
					 	perosns  	= parseInt($('#persons-count').val()),
					 	time 	  	= $("input[type='radio']:checked + label"),
					 	min	  		= parseInt(time.data('min')),
					 	message     = $('#ouvert-message').val(),
					 	bookingId 	= $('.reservation-from').data('bookingid'),
					 	pickNic  	= $('.pick-nick').val(),
				 	 	highTea  	= $('.hight-tea').val(),
					 	hour 	  	= parseInt(time.data('hour'));



					 	$.post(
					 		AjaxUrl,
					 		{

					 			action:'couvert_make_reservation',
					 			resturentID:resturentId,
					 			apikey:apiKey,
					 			firstName:firstName,
								lastName:lastName,
								email:email,
								phone:phone,
								date:date,
								month:month,
								year:year,
								perosns:perosns,
								min:min,
								message:message,
								hour:hour,
								bookingId:bookingId,
								pickNic:pickNic,
								highTea:highTea

					 		},

					 		function ( response ) {

					 			 $('.loader').addClass('hidden');

					 			var responseData = JSON.parse(response);

					 			if(responseData.Message){

					 				$('.reservaton-message').append('<p>'+responseData.Message+'</p>');

					 			}else if(responseData.ConfirmationText ){

					 				$('.reservaton-message').append('<p>'+responseData.ConfirmationText.Dutch+'</p>');

					 				var redirectUrl = $('#make-reservation').data('successurl');

					 				window.location.replace(redirectUrl);

					 			}

					 			
					 		}
						);

			});

		});

	}

})( jQuery );

