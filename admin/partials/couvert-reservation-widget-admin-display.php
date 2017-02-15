<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://dasun.ediris.in/ghe
 * @since      1.0.0
 *
 * @package    Couvert_Reservation_Widget
 * @subpackage Couvert_Reservation_Widget/admin/partials
 */
?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php


	$active_tab = 'general-options';

	if(isset($_GET['tab'])){

		if($_GET['tab'] == 'general-options'){

			$active_tab = 'general-options';

		} else{

			$active_tab = 'language-options';
		}
	}

	?>

     <h2 class="nav-tab-wrapper">
     	<a class="nav-tab <?php echo ( $active_tab == 'general-options') ? 'nav-tab-active' : '' ;?>" href="?page=couvert-reservation-widget&tab=general-options">General Settings</a>
     	<a class="nav-tab <?php echo ( $active_tab == 'language-options') ? 'nav-tab-active' : '' ;?>" href="?page=couvert-reservation-widget&tab=language-options">Form Settings</a>
     </h2>


    <form action="options.php" method="post">
        <?php

            if ( isset($_GET['tab']) && $_GET['tab'] == 'language-options' ) {

	        	settings_fields( $this->plugin_name.'-language' );
	            do_settings_sections($this->plugin_name.'-language');
	            submit_button();
            	
          	} else {

          	settings_fields( $this->plugin_name.'-general' );
            do_settings_sections($this->plugin_name.'-general');
            submit_button();

          }
        ?>
    </form>
</div>