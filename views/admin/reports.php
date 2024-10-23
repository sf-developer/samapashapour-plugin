<?php

defined( 'ABSPATH' ) || exit; // Prevent direct access

wp_enqueue_style( 'bootstrap' );
wp_enqueue_script( 'datatables' );
wp_enqueue_style( 'sampa' );

if( ! wp_script_is( 'jquery', 'done' ) )
{
    wp_enqueue_script( 'jquery' );
}
wp_enqueue_script( 'bootstrap' );
wp_enqueue_script( 'notiflix' );
wp_enqueue_script( 'datatables' );
wp_enqueue_script( 'sampa' );

?>

<div class="container mt-5">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-daily-tab" data-bs-toggle="pill" data-bs-target="#pills-daily" type="button" role="tab" aria-controls="pills-daily" aria-selected="true"><?php _e( 'Daily reports', 'sampa' ); ?></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-monthly-tab" data-bs-toggle="pill" data-bs-target="#pills-monthly" type="button" role="tab" aria-controls="pills-monthly" aria-selected="false"><?php _e( 'Monthly reports', 'sampa' ); ?></button>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-daily" role="tabpanel" aria-labelledby="pills-daily-tab">
            <div id="ExportDailyReporttoExcel"></div>
            <table id="daily-reports" class="table table-striped table-bordered" dir="<?php echo is_rtl() ? 'rtl': 'ltr'; ?>" style="width:100%">
                <thead>
                    <tr>
                        <th><?php _e( 'Row', 'sampa' ); ?></th>
                        <th><?php _e( 'User', 'sampa' ); ?></th>
                        <th><?php _e( 'Nutrition', 'sampa' ); ?></th>
                        <th><?php _e( 'Sport', 'sampa' ); ?></th>
                        <th><?php _e( 'Sleep', 'sampa' ); ?></th>
                        <th><?php _e( 'Expenses', 'sampa' ); ?></th>
                        <th><?php _e( 'Water', 'sampa' ); ?></th>
                        <th><?php _e( 'Today work', 'sampa' ); ?></th>
                        <th><?php _e( 'Motivational sentence', 'sampa' ); ?></th>
                        <th><?php _e( 'Thanksgiving', 'sampa' ); ?></th>
                        <th><?php _e( 'Note', 'sampa' ); ?></th>
                        <th><?php _e( 'Creation date', 'sampa' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><?php _e( 'Row', 'sampa' ); ?></th>
                        <th><?php _e( 'User', 'sampa' ); ?></th>
                        <th><?php _e( 'Nutrition', 'sampa' ); ?></th>
                        <th><?php _e( 'Sport', 'sampa' ); ?></th>
                        <th><?php _e( 'Sleep', 'sampa' ); ?></th>
                        <th><?php _e( 'Expenses', 'sampa' ); ?></th>
                        <th><?php _e( 'Water', 'sampa' ); ?></th>
                        <th><?php _e( 'Today work', 'sampa' ); ?></th>
                        <th><?php _e( 'Motivational sentence', 'sampa' ); ?></th>
                        <th><?php _e( 'Thanksgiving', 'sampa' ); ?></th>
                        <th><?php _e( 'Note', 'sampa' ); ?></th>
                        <th><?php _e( 'Creation date', 'sampa' ); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane fade" id="pills-monthly" role="tabpanel" aria-labelledby="pills-monthly-tab">
            <div id="ExportMonthlyReporttoExcel"></div>
            <table id="monthly-reports" class="table table-striped table-bordered" dir="<?php echo is_rtl() ? 'rtl': 'ltr'; ?>" style="width:100%">
                <thead>
                    <tr>
                        <th><?php _e( 'Row', 'sampa' ); ?></th>
                        <th><?php _e( 'User', 'sampa' ); ?></th>
                        <th><?php _e( 'Chest', 'sampa' ); ?></th>
                        <th><?php _e( 'Left arm', 'sampa' ); ?></th>
                        <th><?php _e( 'Right arm', 'sampa' ); ?></th>
                        <th><?php _e( 'Waist', 'sampa' ); ?></th>
                        <th><?php _e( 'Belly', 'sampa' ); ?></th>
                        <th><?php _e( 'Hip', 'sampa' ); ?></th>
                        <th><?php _e( 'Left thigh', 'sampa' ); ?></th>
                        <th><?php _e( 'Right thigh', 'sampa' ); ?></th>
                        <th><?php _e( 'Left leg', 'sampa' ); ?></th>
                        <th><?php _e( 'Right leg', 'sampa' ); ?></th>
                        <th><?php _e( 'About', 'sampa' ); ?></th>
                        <th><?php _e( 'Creation date', 'sampa' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><?php _e( 'Row', 'sampa' ); ?></th>
                        <th><?php _e( 'User', 'sampa' ); ?></th>
                        <th><?php _e( 'Chest', 'sampa' ); ?></th>
                        <th><?php _e( 'Left arm', 'sampa' ); ?></th>
                        <th><?php _e( 'Right arm', 'sampa' ); ?></th>
                        <th><?php _e( 'Waist', 'sampa' ); ?></th>
                        <th><?php _e( 'Belly', 'sampa' ); ?></th>
                        <th><?php _e( 'Hip', 'sampa' ); ?></th>
                        <th><?php _e( 'Left thigh', 'sampa' ); ?></th>
                        <th><?php _e( 'Right thigh', 'sampa' ); ?></th>
                        <th><?php _e( 'Left leg', 'sampa' ); ?></th>
                        <th><?php _e( 'Right leg', 'sampa' ); ?></th>
                        <th><?php _e( 'About', 'sampa' ); ?></th>
                        <th><?php _e( 'Creation date', 'sampa' ); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>