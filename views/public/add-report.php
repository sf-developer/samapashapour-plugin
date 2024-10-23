<?php

defined( 'ABSPATH' ) || exit; // Prevent direct access

use Morilog\Jalali\Jalalian;
use SAMPA\Inc\SAMPAHelper;

wp_enqueue_style( 'bootstrap' );
wp_enqueue_style( 'sampa' );

if( ! wp_script_is( 'jquery', 'done' ) )
{
    wp_enqueue_script( 'jquery' );
}
wp_enqueue_script( 'bootstrap' );
wp_enqueue_script( 'notiflix' );
wp_enqueue_script( 'sampa' );

$today = Jalalian::forge('today')->format('%A');
$date = Jalalian::forge('today')->format('%d %B %Y');

$current_user_id = get_current_user_id();

$is_personal_info_filled = SAMPAHelper::is_persoanl_info_filled( $current_user_id );

if( $is_personal_info_filled )
{
    $personal_info = SAMPAHelper::get_presonal_info( $current_user_id );
    $monthly_report = SAMPAHelper::get_this_month_report( $current_user_id );
    $today_report = SAMPAHelper::get_today_report( $current_user_id );
    if( ! empty( $today_report ) && is_array( $today_report ) )
    {
        $water_count = $today_report[0]->water;
        wp_add_inline_script( 'sampa', 'jQuery(function($) { sampaWaterGlass = 0; $(".sampa-water-glass").each(function (k, v) { if(k < ' . $water_count . ') { $(this).prop("checked", true); sampaWaterGlass++; } }); } );' );
    }
}

include_once( SAMPA_PATH . 'views/public/package-remaining-days.php' );

$package_remaining_days = SAMPAHelper::get_remaining_days();
$package_period = intval( get_user_meta( get_current_user_id(), '_sampa_package_period', true ) );
?>
<div class="container text-center sampa-bg">
    <div class="report-step-1">
        <?php if( $package_period == $package_remaining_days ) : ?>
            <div class="sampa-title sampa-title-picture">
                <?php _e( 'MY BODY', 'sampa' ); ?>
            </div>
            <div class="sampa-body">
                <div class="sampa-human">
                    <h3 class="mb-3"><?php _e( 'Specifications:', 'sampa' ); ?></h3>
                    <div class="row mb-3">
                        <label for="my-name" class="col-sm-3 col-form-label"><?php _e( 'My name:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="my-name" name="my_name" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_name : ''; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="my-height" class="col-sm-3 col-form-label"><?php _e( 'My height:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="my-height" name="my_height" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_height : ''; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="my-weight" class="col-sm-3 col-form-label"><?php _e( 'My weight:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="my-weight" name="my_weight" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_weight : ''; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="my-age" class="col-sm-3 col-form-label"><?php _e( 'My age:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="my-age" name="my_age" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_age : ''; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="my-number" class="col-sm-3 col-form-label"><?php _e( 'My number:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="my-number" name="my_number" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_number : ''; ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="my-goal" class="col-sm-3 col-form-label"><?php _e( 'My goal:', 'sampa' ); ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="my-goal" name="my_goal" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_goal : ''; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sampa-body mt-3">
                <div class="sampa-human sampa-agreement">
                    <p>من <input type="text" class="sampa-agreement-input sampa-name-input" placeholder="......" id="agreement-name" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_name : ''; ?>" readonly /> با وزن <input type="number" class="sampa-agreement-input" placeholder="......" id="agreement-weight" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_weight : ''; ?>" readonly /> و قد <input type="number" class="sampa-agreement-input" placeholder="......" id="agreement-height" value="<?php echo ( $is_personal_info_filled ) ? $personal_info[0]->my_height : ''; ?>" readonly /> خود را همینطور که هستم دوست دارم و در جهت ارتقاء و بهبود وضعیت جسمانی‌ام تلاش می کنم.<br/> تعهد می دهم به خوراکم آگاه باشم و فعالیت روزانه را فراموش نکنم.</p>
                    <div class="row">
                        <div class="col-6">
                            <?php _e( 'Signeture', 'sampa' ); ?>
                        </div>
                        <div class="col-6">
                            <img src="<?php echo SAMPA_URL . 'assets/images/fingerprint.png'; ?>" class="float-end" alt="<?php _e( 'Fingerprint', 'sampa' ); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row align-items-start sampa-report">
                <div class="col-md-6 col-sm-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="sampa-today"><?php _e( 'Today', 'sampa' ); ?></span>
                        <input type="text" class="form-control sampa-date" value="<?php echo $today; ?>" aria-label="<?php _e( 'Today', 'sampa' ); ?>" aria-describedby="sampa-today" readonly>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="sampa-date"><?php _e( 'Date', 'sampa' ) ?></span>
                        <input type="text" class="form-control sampa-date" value="<?php echo $date; ?>" aria-label="<?php _e( 'Date', 'sampa' ) ?>" aria-describedby="sampa-date" readonly>
                    </div>
                </div>
                <div class="col-12 sampa-section">
                    <div class="sampa-title w-auto position-relative mb-0 sampa-title-motivational-sentence">
                        <?php _e( 'Today motivational sentence', 'sampa' ); ?>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control sampa-textbox-lines" name="sampa_motivational_sentence" id="sampa-motivational-sentence" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->motivational_sentence : ''; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 sampa-section">
                    <div class="sampa-thanksgiving">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-thanksgiving">
                            <?php _e( 'Thanksgiving', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_thanksgiving" id="sampa-thanksgiving" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->thanksgiving : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 sampa-section">
                    <div class="sampa-works">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-works">
                            <?php _e( 'Today works', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_works" id="sampa-works" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->today_work : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 sampa-section">
                    <div class="sampa-title w-auto position-relative mb-0 sampa-title-works">
                        <?php _e( 'Water', 'sampa' ); ?>
                    </div>
                    <div class="sampa-content">
                        <div class="bg-white p-4 sampa-water">
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="1" id="water-1">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="2" id="water-2">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="3" id="water-3">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="4" id="water-4">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="5" id="water-5">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="6" id="water-6">
                            </div>
                            <div class="glass-container position-relative d-inline-block">
                                <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="7" id="water-7">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <button class="sampa-title sampa-goto-step-2 w-100" data-type="<?php echo ( $package_period == $package_remaining_days || fmod( $package_remaining_days, $package_period ) == 1 ) ? 'monthly' : 'daily'; ?>" <?php echo ( $package_period == $package_remaining_days ) ? 'data-time="first"' : ''; ?>><?php _e( 'Next step', 'sampa' ); ?></button>
    </div>
    <div class="report-step-2">
        <?php if( $package_period == $package_remaining_days ) : ?>

                <div class="sampa-title w-100">
                    <?php _e( 'About this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_about_this_month" id="sampa-about-this-month" rows="7"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? $monthly_report[0]->about : ''; ?></textarea>
                        </div>
                    </div>
                </div>
        <?php else: ?>
            <div class="row align-items-start sampa-report">
                <div class="col-md-6 col-sm-12 sampa-section">
                    <div class="sampa-nutrition">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-nutrition">
                            <?php _e( 'Today nutrition', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_nutrition" id="sampa-nutrition" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->nutrition : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 sampa-section">
                    <div class="sampa-sport">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-sport">
                            <?php _e( 'Today sport', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_sport" id="sampa-sport" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->sport : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="sampa-sleep">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-sleep">
                            <?php _e( 'Today sleep', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_sleep" id="sampa-sleep" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->sleep : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="sampa-expenses">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-expenses">
                            <?php _e( 'Today expenses', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_expenses" id="sampa-expenses" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->expenses : ''; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 sampa-section">
                    <div class="sampa-title w-auto position-relative mb-0 sampa-title-note">
                        <?php _e( 'Today note', 'sampa' ); ?>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control sampa-textbox-lines" name="sampa_note" id="sampa-note" rows="4"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->note : ''; ?></textarea>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <button class="sampa-title sampa-return-to-step-1 d-inline-block" data-type="<?php echo ( ( $package_period == $package_remaining_days ) || fmod( $package_remaining_days, $package_period ) == 1 ) ? 'monthly' : 'daily'; ?>"><?php _e( 'Previous step', 'sampa' ); ?></button>
        <?php if( $package_period == $package_remaining_days || fmod( $package_remaining_days, $package_period ) == 1 ) : ?>
            <button class="sampa-title sampa-goto-step-3 d-inline-block" data-time="<?php echo ( $package_period == $package_remaining_days ) ? 'first' : ''; ?>"><?php _e( 'Next step', 'sampa' ); ?></button>
        <?php else: ?>
            <button class="sampa-title d-inline-block <?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? 'sampa-update-daily-form' : 'sampa-save-daily-form'; ?>" data-uid="<?php echo get_current_user_id(); ?>" <?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? 'data-form-id="' . $today_report[0]->ID . '"' : ''; ?>><?php _e( 'Save', 'sampa' ); ?></button>
        <?php endif; ?>
    </div>
    <div class="report-step-3">
            <?php if( $package_period == $package_remaining_days ) : ?>
                <div class="sampa-title w-100">
                    <?php _e( 'My measurements this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <img src="<?php echo SAMPA_URL . 'assets/images/human.png'; ?>" alt="<?php _e( 'Human', 'sampa' ); ?>" width="300">
                        <div class="sizes-container">
                            <div class="input-group mb-3">
                                <span id="chest-label" class="input-group-text"><?php _e( 'Chest', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="chest" placeholder="<?php _e( 'Chest size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['chest'] : ''; ?>" aria-describedby="chest-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-arm-label" class="input-group-text"><?php _e( 'Left arm', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-arm" placeholder="<?php _e( 'Left arm size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_arm'] : ''; ?>" aria-describedby="left-arm-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-arm-label" class="input-group-text"><?php _e( 'Right arm', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-arm" placeholder="<?php _e( 'Right arm size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_arm'] : ''; ?>" aria-describedby="right-arm-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="waist-label" class="input-group-text"><?php _e( 'Waist', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="waist" placeholder="<?php _e( 'Waist size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['waist'] : ''; ?>" aria-describedby="waist-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="" class="input-group-text"><?php _e( 'Belly', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="belly" placeholder="<?php _e( 'Belly size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['belly'] : ''; ?>" aria-describedby="belly-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="hip-label" class="input-group-text"><?php _e( 'Hip', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="hip" placeholder="<?php _e( 'Hip size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['hip'] : ''; ?>" aria-describedby="hip-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-thigh-label" class="input-group-text"><?php _e( 'Left thigh', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-thigh" placeholder="<?php _e( 'Left thigh size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_thigh'] : ''; ?>" aria-describedby="left-thigh-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-thigh-label" class="input-group-text"><?php _e( 'Right thigh', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-thigh" placeholder="<?php _e( 'Right thigh size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_thigh'] : ''; ?>" aria-describedby="right-thigh-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-leg-label" class="input-group-text"><?php _e( 'Left leg', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-leg" placeholder="<?php _e( 'Left leg size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_leg'] : ''; ?>" aria-describedby="left-leg-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-leg-label" class="input-group-text"><?php _e( 'Right leg', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-leg" placeholder="<?php _e( 'Right leg size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_leg'] : ''; ?>" aria-describedby="right-leg-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif( fmod( $package_remaining_days, $package_period ) == 1 ): ?>
                <div class="sampa-title w-100">
                    <?php _e( 'About this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_about_this_month" id="sampa-about-this-month" rows="7"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? $monthly_report[0]->about : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <button class="sampa-title sampa-return-to-step-2 d-inline-block" data-type="<?php echo ( $package_period == $package_remaining_days || fmod( $package_remaining_days, $package_period ) == 1 ) ? 'monthly' : 'daily'; ?>"><?php _e( 'Previous step', 'sampa' ); ?></button>
            <?php if( $package_period == $package_remaining_days || fmod( $package_remaining_days, $package_period ) == 1 ) : ?>
                <button class="sampa-title sampa-goto-step-4 d-inline-block" data-time="<?php echo ( $package_period == $package_remaining_days ) ? 'first' : ''; ?>"><?php _e( 'Next step', 'sampa' ); ?></button>
            <?php else: ?>
                <button class="sampa-title <?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? 'sampa-update-monthly-form' : 'sampa-save-monthly-form'; ?>" data-uid="<?php echo get_current_user_id(); ?>" <?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? 'data-form-id="' . $monthly_report[0]->ID . '"' : ''; ?> data-time="<?php echo ( $package_period == $package_remaining_days ) ? 'first' : ''; ?>"><?php _e( 'Save', 'sampa' ); ?></button>
            <?php endif; ?>
        </div>
        <div class="report-step-4">
            <?php if( $package_period == $package_remaining_days ) : ?>
                <div class="row align-items-start sampa-report">
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="sampa-today"><?php _e( 'Today', 'sampa' ); ?></span>
                            <input type="text" class="form-control sampa-date" value="<?php echo $today; ?>" aria-label="<?php _e( 'Today', 'sampa' ); ?>" aria-describedby="sampa-today" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="sampa-date"><?php _e( 'Date', 'sampa' ) ?></span>
                            <input type="text" class="form-control sampa-date" value="<?php echo $date; ?>" aria-label="<?php _e( 'Date', 'sampa' ) ?>" aria-describedby="sampa-date" readonly>
                        </div>
                    </div>
                    <div class="col-12 sampa-section">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-motivational-sentence">
                            <?php _e( 'Today motivational sentence', 'sampa' ); ?>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_motivational_sentence" id="sampa-motivational-sentence" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->motivational_sentence : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 sampa-section">
                        <div class="sampa-thanksgiving">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-thanksgiving">
                                <?php _e( 'Thanksgiving', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_thanksgiving" id="sampa-thanksgiving" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->thanksgiving : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 sampa-section">
                        <div class="sampa-works">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-works">
                                <?php _e( 'Today works', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_works" id="sampa-works" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->today_work : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 sampa-section">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-water">
                            <?php _e( 'Water', 'sampa' ); ?>
                        </div>
                        <div class="sampa-content">
                            <div class="bg-white p-4 sampa-water">
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="1" id="water-1">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="2" id="water-2">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="3" id="water-3">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="4" id="water-4">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="5" id="water-5">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="6" id="water-6">
                                </div>
                                <div class="glass-container position-relative d-inline-block">
                                    <img src="<?php echo SAMPA_URL . 'assets/images/glass.png' ?>" alt="Glass" class="position-relative">
                                    <input class="form-check-input mt-0 position-absolute top-50 rounded-5 sampa-water-glass" type="checkbox" value="7" id="water-7">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif( fmod( $package_remaining_days, $package_period ) == 1 ): ?>
                <div class="sampa-title w-100">
                    <?php _e( 'My measurements this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <img src="<?php echo SAMPA_URL . 'assets/images/human.png'; ?>" alt="<?php _e( 'Human', 'sampa' ); ?>" width="300">
                        <div class="sizes-container">
                            <div class="input-group mb-3">
                                <span id="chest-label" class="input-group-text"><?php _e( 'Chest', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="chest" placeholder="<?php _e( 'Chest size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['chest'] : ''; ?>" aria-describedby="chest-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-arm-label" class="input-group-text"><?php _e( 'Left arm', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-arm" placeholder="<?php _e( 'Left arm size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_arm'] : ''; ?>" aria-describedby="left-arm-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-arm-label" class="input-group-text"><?php _e( 'Right arm', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-arm" placeholder="<?php _e( 'Right arm size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_arm'] : ''; ?>" aria-describedby="right-arm-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="waist-label" class="input-group-text"><?php _e( 'Waist', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="waist" placeholder="<?php _e( 'Waist size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['waist'] : ''; ?>" aria-describedby="waist-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="" class="input-group-text"><?php _e( 'Belly', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="belly" placeholder="<?php _e( 'Belly size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['belly'] : ''; ?>" aria-describedby="belly-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="hip-label" class="input-group-text"><?php _e( 'Hip', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="hip" placeholder="<?php _e( 'Hip size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['hip'] : ''; ?>" aria-describedby="hip-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-thigh-label" class="input-group-text"><?php _e( 'Left thigh', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-thigh" placeholder="<?php _e( 'Left thigh size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_thigh'] : ''; ?>" aria-describedby="left-thigh-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-thigh-label" class="input-group-text"><?php _e( 'Right thigh', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-thigh" placeholder="<?php _e( 'Right thigh size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_thigh'] : ''; ?>" aria-describedby="right-thigh-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="left-leg-label" class="input-group-text"><?php _e( 'Left leg', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="left-leg" placeholder="<?php _e( 'Left leg size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['left_leg'] : ''; ?>" aria-describedby="left-leg-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                            <div class="input-group mb-3">
                                <span id="right-leg-label" class="input-group-text"><?php _e( 'Right leg', 'sampa' ); ?></span>
                                <input type="number" class="form-control" id="right-leg" placeholder="<?php _e( 'Right leg size in mm', 'sampa' ) ?>" value="<?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? maybe_unserialize( $monthly_report[0]->measurement )[0]['right_leg'] : ''; ?>" aria-describedby="right-leg-label">
                                <span class="sampa-unit">mm</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <button class="sampa-title sampa-return-to-step-3 d-inline-block"><?php _e( 'Previous step', 'sampa' ); ?></button>
            <button class="sampa-title sampa-goto-step-5 d-inline-block" data-time="<?php echo ( $package_period == $package_remaining_days ) ? 'first' : ''; ?>"><?php _e( 'Next step', 'sampa' ); ?></button>
        </div>
        <div class="report-step-5">
            <?php if( $package_period == $package_remaining_days ): ?>
                <div class="row align-items-start sampa-report">
                    <div class="col-md-6 col-sm-12 sampa-section">
                        <div class="sampa-nutrition">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-nutrition">
                                <?php _e( 'Today nutrition', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_nutrition" id="sampa-nutrition" rows="3"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->nutrition : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 sampa-section">
                        <div class="sampa-sport">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-sport">
                                <?php _e( 'Today sport', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_sport" id="sampa-sport" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->sport : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="sampa-sleep">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-sleep">
                                <?php _e( 'Today sleep', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_sleep" id="sampa-sleep" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->sleep : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="sampa-expenses">
                            <div class="sampa-title w-auto position-relative mb-0 sampa-title-expenses">
                                <?php _e( 'Today expenses', 'sampa' ); ?>
                            </div>
                            <div class="sampa-content">
                                <div class="mb-3">
                                <textarea class="form-control sampa-textbox-lines" name="sampa_expenses" id="sampa-expenses" rows="1"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->expenses : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 sampa-section">
                        <div class="sampa-title w-auto position-relative mb-0 sampa-title-note">
                            <?php _e( 'Today note', 'sampa' ); ?>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_note" id="sampa-note" rows="4"><?php echo ( ! empty( $today_report ) && is_array( $today_report ) ) ? $today_report[0]->note : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            <?php elseif( fmod( $package_remaining_days, $package_period ) == 1 ): ?>
                <div class="sampa-title w-auto position-relative mb-0 sampa-title-result">
                    <?php _e( 'Result of this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <div class="mb-3">
                            <div id="sampa-holder">
                                <textarea class="form-control sampa-textbox-lines sampa-title-text" name="sampa_this_month_diet" id="sampa-this-month-diet" rows="2"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) && isset( $monthly_report[0]->end_month ) ) ? maybe_unserialize( $monthly_report[0]->end_month )[0]['this_month_diet'] : ''; ?></textarea>
                                <span class="sampa-before-title"><?php _e( 'This month my diet', 'sampa' ) ?></span>
                            </div>
                            <div id="sampa-holder2">
                                <textarea class="form-control sampa-textbox-lines sampa-title-text2" name="sampa_this_month_gym" id="sampa-this-month-gym" rows="2"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) && isset( $monthly_report[0]->end_month ) ) ? maybe_unserialize( $monthly_report[0]->end_month )[0]['this_month_gym'] : ''; ?></textarea>
                                <span class="sampa-before-title2"><?php _e( 'This month my gym', 'sampa' ) ?></span>
                            </div>
                            <div id="sampa-holder3">
                                <textarea class="form-control sampa-textbox-lines sampa-title-text3" name="sampa_this_month_sleep_time" id="sampa-this-month-sleep-time" rows="2"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) && isset( $monthly_report[0]->end_month ) ) ? maybe_unserialize( $monthly_report[0]->end_month )[0]['this_month_sleep_time'] : ''; ?></textarea>
                                <span class="sampa-before-title3"><?php _e( 'This month my sleep time', 'sampa' ) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sampa-title w-100">
                    <span class="sampa-title-right">
                        <?php _e( 'Weight at beginning', 'sampa' ); ?>
                    </span>
                    <span class="sampa-scales-icon"><img src="<?php echo SAMPA_URL . 'assets/images/scale.png'; ?>" alt="<?php _e( 'Scale', 'sampa' ); ?>" /></span>
                    <span class="sampa-title-left">
                        <?php _e( 'Weight at ending', 'sampa' ); ?>
                    </span>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="sampa-body">
                            <div class="sampa-human">
                                <div class="mb-3">
                                    <textarea class="form-control sampa-textbox-lines" name="sampa_begining_weight" id="sampa-begining-weight" rows="1"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? $monthly_report[0]->begining_weight : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="sampa-body">
                            <div class="sampa-human">
                                <div class="mb-3">
                                    <textarea class="form-control sampa-textbox-lines" name="sampa_ending_weight" id="sampa-ending-weight" rows="1"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? $monthly_report[0]->ending_weight : ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sampa-title  w-auto position-relative mb-0 sampa-title-gift">
                    <?php _e( 'Award of this month', 'sampa' ); ?>
                </div>
                <div class="sampa-body">
                    <div class="sampa-human">
                        <div class="mb-3">
                            <textarea class="form-control sampa-textbox-lines" name="sampa_this_month_award" id="sampa-this-month-award" rows="1"><?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? $monthly_report[0]->award : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <button class="sampa-title sampa-return-to-step-4 d-inline-block"><?php _e( 'Previous step', 'sampa' ); ?></button>
            <button class="sampa-title <?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? 'sampa-update-monthly-form' : 'sampa-save-monthly-form'; ?>" data-time="<?php echo ( $package_period == $package_remaining_days ) ? 'first' : ''; ?>" data-uid="<?php echo get_current_user_id(); ?>" <?php echo ( ! empty( $monthly_report ) && is_array( $monthly_report ) ) ? 'data-form-id="' . $monthly_report[0]->ID . '"' : ''; ?>><?php _e( 'Save', 'sampa' ); ?></button>
        </div>
        <?php if( fmod( $package_remaining_days, $package_period ) == 1 ): ?>
            <div class="report-step-6">
                <div class="row align-items-start sampa-report">
                    <div class="col-12 sampa-section">
                        <div class="sampa-title w-100">
                            <?php _e( 'GOD...', 'sampa' ); ?>
                        </div>
                        <div class="sampa-body">
                            <div class="sampa-human">
                                <div class="mb-3">
                                    <p><?php _e( 'God, I thank you that I finished this month with full energy and strength, this month I loved myself more and gave more importance to the health of my body.
        Now, with your name and memory, I will start the new month with more energy ❤️', 'sampa' ); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
</div>