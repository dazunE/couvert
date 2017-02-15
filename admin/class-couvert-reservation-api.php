<?php


function couvert_remote_data( $url_part, $data = null) {

	$api_key = base64_decode($_POST['apikey']);
	$api_url = get_option( 'couvert_reservation_api_url' );
	$resturent_id   = $_POST['resturentID'];


	if($api_key) {

		if ( $data ) {

	      $pass_data = json_encode($data);
	    }

	    $url = $api_url.$url_part;

	    $ch = curl_init($url);
	    curl_setopt_array(
	      $ch,
	      array(
	        CURLOPT_HTTPHEADER => array(
	          "Authorization: Basic " . base64_encode($resturent_id . ":" . $api_key),
	          "Content-Type: application/json",
	        ),
	        CURLOPT_RETURNTRANSFER => true,
	      )
	    );
	    
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

	    // If we have a data, we need to POST, otherwise we GET
	    if ( $data ) {
	      curl_setopt($ch,CURLOPT_POST,true);
	      curl_setopt($ch,CURLOPT_POSTFIELDS,$pass_data);
	    }

	    $reply = curl_exec($ch);

	    curl_close($ch);


	} else {

		$reply = 'There is a issue with your api key';
	}


	return  $reply;

}


function couvert_get_resturent_data(){

	$resturent_id   = $_POST['resturentID'];
	$url_part = $base_url.'/basicinfo';

	$info = couvert_remote_data( $url_part );

	echo $info;

	exit;

}

add_action( 'wp_ajax_couvert_get_resturent_data' ,'couvert_get_resturent_data');
add_action( 'wp_ajax_nopriv_couvert_get_resturent_data' ,'couvert_get_resturent_data');


function couvert_config_for_day(){

	$year 			= $_POST['year'];
	$month			= $_POST['month'];
	$date 			= $_POST['day'];

	$url_part = '/configforday?&year='.$year.'&month='.$month.'&day='.$date;

	$info = couvert_remote_data( $url_part );

	echo $info;

	exit;

}

add_action( 'wp_ajax_couvert_config_for_day' ,'couvert_config_for_day' );
add_action( 'wp_ajax_nopriv_couvert_config_for_day' , 'couvert_config_for_day' );


function couvert_time_avilability(){


	$number_persons = $_POST['numPersons'];
	$year 			= $_POST['year'];
	$month			= $_POST['month'];
	$date 			= $_POST['day'];

	$url_part ='/AvailableTimes?numPersons='.$number_persons.'&year='.$year.'&month='.$month.'&day='.$date;

	$info = couvert_remote_data( $url_part );

	echo $info;

	exit;

}

add_action( 'wp_ajax_couvert_time_avilability' ,'couvert_time_avilability');
add_action( 'wp_ajax_nopriv_couvert_time_avilability' ,'couvert_time_avilability');


function couvert_get_input_fields(){

	$year 			= $_POST['year'];
	$month			= $_POST['month'];
	$date 			= $_POST['day'];
	$hours			= $_POST['hours'];
	$minutes 		= $_POST['minutes'];

	$url_part = '/inputfields?year='.$year.'&month='.$month.'&day='.$date.'&hours='.$hours.'&minutes='.$minutes;


	$info = couvert_remote_data( $url_part );

	echo $info;

	exit;
}

add_action( 'wp_ajax_couvert_get_input_fields', 'couvert_get_input_fields' );
add_action( 'wp_ajax_nopriv_couvert_get_input_fields', 'couvert_get_input_fields' );


function couvert_make_reservation(){

	$language = get_option( 'couvert_reservation_plugin_lang' );

	$data = array(

		'Date' => array(
				'Day' 	=> $_POST['date'],
			    'Month' => $_POST['month'],
			    'Year' 	=> $_POST['year']
				),
		'Time' => array(
				'Hours'   => $_POST['hour'],
				'Minutes' => $_POST['min']
				),
		'NumPersons' => $_POST['perosns'],
		'Language' 	 => $language,
		'LastName' 	 => $_POST['lastName'],
		'FirstName'  => $_POST['firstName'],
		'Email' 	 => $_POST['email'],
		'PhoneNumber'=> $_POST['phone'],
		'Comments' => $_POST['message'],
		'RestaurantSpecificFields' => array(
			  array(
			  	 'Id'=> $_POST['bookingId'],
			  	 'Value' => 'Picknic :'.$_POST['pickNic'].' HighTea:'.$_POST['highTea'],
			  	)
			),
	    'NewsletterRestaurant' => true,
	    'NewsletterCouverts' => false

		);

	$url_part = '/reservation';

	$info = couvert_remote_data( $url_part , $data );

	echo $info;

	exit;
}

add_action( 'wp_ajax_couvert_make_reservation' , 'couvert_make_reservation' );
add_action( 'wp_ajax_nopriv_couvert_make_reservation', 'couvert_make_reservation' );
