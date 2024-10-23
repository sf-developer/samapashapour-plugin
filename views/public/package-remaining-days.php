<?php

defined( 'ABSPATH' ) || exit; // Prevent direct access

use SAMPA\Inc\SAMPAHelper;

wp_enqueue_style( 'bootstrap' );
wp_enqueue_style( 'sampa' );

wp_enqueue_script( 'bootstrap' );

$package_remaining_days = SAMPAHelper::get_remaining_days();
?>

<div class="alert alert-<?php echo ( 0 == $package_remaining_days ) ? 'danger' : 'primary'; ?>" role="alert">
    <?php if( 0 == $package_remaining_days ): ?>
        <strong><?php _e( 'Your package time is expired!', 'sampa' ) ?></strong>
    <?php else: ?>
        <strong><?php _e( 'Package remaining time: ', 'sampa' ) ?></strong> <?php echo $package_remaining_days . __( ' Day(s)', 'sampa' ); ?>
    <?php endif; ?>
</div>
