<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://dasun.ediris.in/ghe
 * @since      1.0.0
 *
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/public/partials
 */


 function couvert_reservation_form_shortcode( $atts , $content = null) {

    $atts = shortcode_atts(

      array(
        'restaurant' => '',
        'analytics' => '',
        'api_key' => '',
      ),
      $atts,
      'booking_widget'
    );

    ob_start();

    ?>

    <div class="couvert-reservation__wrapper">
      <div class="couvert-reservation__inner row" data-resturent="<?php echo $atts['restaurant'];?>" data-apikey="<?php echo base64_encode($atts['api_key'])?>">
          <div class="column-12 couvert_intro"><?php echo wpautop( $content ); ?></div>
          <div class="column-6">
            <div class="input-wrapper">
              <label for="select-date"><?php echo get_option( 'couvert_reservation_date_picker' );?> ? <span>( * Required )</span></label>
              <input type="text" placeholder="<?php echo get_option('couvert_reservation_date_picker_ph');?> " class="select-date">
            </div>
          </div>
          <div class="column-6">
            <div class="input-wrapper">
              <label for="number-heades"><?php echo get_option( 'couvert_reservation_person_number' );?> ?</label>
              <select name="number-heades" id="persons-count" disabled="disabled">
                <option value="1">1 <?php echo get_option('couvert_reservation_person_number_ph');?> </option>
                <option value="2">2 <?php echo get_option('couvert_reservation_person_number_ph');?> </option>
                <option value="3">3 <?php echo get_option('couvert_reservation_person_number_ph');?> </option>
                <option value="4">4 <?php echo get_option('couvert_reservation_person_number_ph');?> </option>
                <option value="5">5 <?php echo get_option('couvert_reservation_person_number_ph');?> </option>
              </select>
            </div>
          </div>
          <!-- Time Slots -->
          <div class="column-12">
            <div class="input-wrapper time-slot_wrapper">
              <label for="time-slots" class="hidden"><?php echo get_option( 'couvert_reservation_time_slot_label' );?></label>
              <div class="time-slots">
                
              </div>
            </div>
          </div>
          <!-- Reservtaion Form -->
          <div class="reservation-from hidden">
            <!-- Fisrt Name Filed -->
            <div class="column-6">
              <div class="input-wrapper">
                <label for="first-name"><?php echo get_option( 'couvert_reservation_first_name_label' );?></label>
                <input type="text" placeholder="<?php echo get_option('couvert_reservation_first_name_label_ph');?> " class="first-name">
              </div>
            </div>
            <!-- Last Name Filed-->
            <div class="column-6">
              <div class="input-wrapper">
                <label for="last-name"><?php echo get_option( 'couvert_reservation_last_name_label' );?> </label>
                <input type="text" placeholder="<?php echo get_option( 'couvert_reservation_last_name_label_ph' );?>" class="last-name">
              </div>
            </div>
            <!-- E-mail -->
            <div class="column-6">
              <div class="input-wrapper">
                <label for="emial"><?php echo get_option( 'couvert_reservation_email_address_label' );?> <span>( * Required )</span></label>
                <input type="emial" placeholder="<?php echo get_option( 'couvert_reservation_email_address_label_ph' );?>" class="email-add">
              </div>
            </div>
            <!-- Phone Number -->
            <div class="column-6">
              <div class="input-wrapper">
                <label for="phone"><?php echo get_option( 'couvert_reservation_phone_number_label' );?></label>
                <input type="text" placeholder="<?php echo get_option( 'couvert_reservation_phone_number_label_ph' );?>" class="phone-number">
              </div>
            </div>
            <div class="column-12">
              <label for="message"><?php echo get_option( 'couvert_reservation_message_label' );?></label>
              <textarea name="message" id="couvert-message" cols="30" rows="2"></textarea>
              <p></p>
            </div>
            <div class="column-12 resturent-fields">
              <div class="column-6">
                <div class="input-wrapper brunch">
                  <label for="brunch"></label>
                  <input type="Number" placeholder="<?php echo get_option('couvert_reservation_high_teal_label_ph'); ?>" class="brunch">
                </div>
              </div>
              <div class="column-6">
                <div class="input-wrapper high-tea">
                  <label for="high-tea"></label>
                  <input type="Number" placeholder="<?php echo get_option('couvert_reservation_high_teal_label_ph'); ?>" class="hight-tea">
                </div>
              </div>
              <div class="column-6">
                <div class="input-wrapper pick-nick">
                  <label for="pick-nick"></label>
                  <input type="Number" placeholder="<?php echo get_option('couvert_reservation_picknick_label_ph'); ?>" class="pick-nick">
                </div>
              </div>
            </div>
          </div>
          <div class="column-12">
            <div class="input-wrapper">
              <div class='loader loader--audioWave hidden'></div>
              <div class="reservaton-message">
                
              </div>
              <button class="submit btn" id="time-avialbility"><?php echo get_option( 'couvert_reservation_availability_button' ); ?></button>
              <button class="submit btn hidden" id="ready-reservation"><?php echo get_option( 'couvert_reservation_form_rquest_button' ); ?></button>
              <button class="submit btn hidden" id="make-reservation" data-successurl="<?php echo get_option('couvert_reservation_redirect_url');?>"><?php echo get_option( 'couvert_reservation_resvertaion_button_label' ); ?></button>
            </div>
          </div>
          <div class="clear-fix"></div>
      </div>
    </div>
    <?php


    couvert_google_analytics($atts['analytics']);

    return ob_get_clean();



 }

 add_shortcode( 'booking_widget' , 'couvert_reservation_form_shortcode' );

 function couvert_google_analytics( $tracking_id ){

?>

<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', '<?php echo $tracking_id; ?>', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->

<?php

 }

add_action( 'wp_head', 'couvert_google_analytics' );

