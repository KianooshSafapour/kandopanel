<?php


use samyar\Log;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php if ( samyar_is_admin() && isset($_GET['user'])): ?>
<style>

    /* --------------------------------

	Modules - reusable parts of our design

	-------------------------------- */
    .cd-container {
        /* this class is used to give a max-width to the element it is applied to, and center it horizontally when it reaches that max-width */
        width: 90%;
        max-width: 1170px;
        margin: 0 auto;
    }

    .cd-container::after {
        /* clearfix */
        content: "";
        display: table;
        clear: both;
    }

    /* --------------------------------

	Main components

	-------------------------------- */


    #cd-timeline {
        position: relative;
        padding: 2em 0;
        margin-top: 2em;
        margin-bottom: 2em;
    }

    #cd-timeline::before {
        /* this is the vertical line */
        content: "";
        position: absolute;
        top: 0;
        right: 18px;
        height: 100%;
        width: 4px;
        background: #d7e4ed;
    }

    @media only screen and (min-width: 1170px) {
        #cd-timeline {
            margin-top: 3em;
            margin-bottom: 3em;
        }

        #cd-timeline::before {
            right: 50%;
            margin-right: -2px;
        }

    }

    .cd-timeline-block {
        position: relative;
        margin: 2em 0;
    }

    .cd-timeline-block::after {
        clear: both;
        content: "";
        display: table;
    }

    .cd-timeline-block:first-child {
        margin-top: 0;
    }

    .cd-timeline-block:last-child {
        margin-bottom: 0;
    }

    @media only screen and (min-width: 1170px) {
        .cd-timeline-block {
            margin: 4em 0;
        }

        .cd-timeline-block:first-child {
            margin-top: 0;
        }

        .cd-timeline-block:last-child {
            margin-bottom: 0;
        }
    }

    .cd-timeline-img {
        position: absolute;
        top: 0;
        right: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-shadow: 0 0 0 4px #ffffff, inset 0 2px 0 rgba(0, 0, 0, 0.08), 0 3px 0 4px rgba(0, 0, 0, 0.05);
    }

    .cd-timeline-img i {
        display: block;
        margin-top: 15px;
        font-size: 26px;
        color: #fff;
        text-align: center;
    }

    .cd-timeline-img.cd-green {
        background: #75ce66;
    }

    .cd-timeline-img.cd-red {
        background: #c03b44;
    }

    .cd-timeline-img.cd-yello {
        background: #f0ca45;
    }

    @media only screen and (min-width: 1170px) {
        .cd-timeline-img {
            width: 60px;
            height: 60px;
            right: 50%;
            margin-right: -30px;
            /* Force Hardware Acceleration in WebKit */
            -webkit-transform: translateZ(0);
            -webkit-backface-visibility: hidden;
        }

        .cssanimations .cd-timeline-img.is-hidden {
            visibility: hidden;
        }

        .cssanimations .cd-timeline-img.bounce-in {
            visibility: visible;
            -webkit-animation: cd-bounce-1 0.6s;
            -moz-animation: cd-bounce-1 0.6s;
            animation: cd-bounce-1 0.6s;
        }
    }

    @-webkit-keyframes cd-bounce-1 {
        0% {
            opacity: 0;
            -webkit-transform: scale(0.5);
        }
        60% {
            opacity: 1;
            -webkit-transform: scale(1.2);
        }
        100% {
            -webkit-transform: scale(1);
        }
    }

    @-moz-keyframes cd-bounce-1 {
        0% {
            opacity: 0;
            -moz-transform: scale(0.5);
        }
        60% {
            opacity: 1;
            -moz-transform: scale(1.2);
        }
        100% {
            -moz-transform: scale(1);
        }
    }

    @keyframes cd-bounce-1 {
        0% {
            opacity: 0;
            -webkit-transform: scale(0.5);
            -moz-transform: scale(0.5);
            -ms-transform: scale(0.5);
            -o-transform: scale(0.5);
            transform: scale(0.5);
        }
        60% {
            opacity: 1;
            -webkit-transform: scale(1.2);
            -moz-transform: scale(1.2);
            -ms-transform: scale(1.2);
            -o-transform: scale(1.2);
            transform: scale(1.2);
        }
        100% {
            -webkit-transform: scale(1);
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -o-transform: scale(1);
            transform: scale(1);
        }
    }

    .cd-timeline-content {
        position: relative;
        margin-right: 60px;
        background: #ffffff;
        border-radius: 0.25em;
        padding: 1em;
        box-shadow: 0 3px 0 #d7e4ed;
        border: 1px solid #d7e4ed;
    }

    .cd-timeline-content::after {
        clear: both;
        content: "";
        display: table;
    }

    .cd-timeline-content h2 {
        color: #303e49;
    }

    .cd-timeline-content p,
    .cd-timeline-content .cd-read-more,
    .cd-timeline-content .cd-date {
        font-size: 13px;
        font-size: 0.8125rem;
    }

    .cd-timeline-content .cd-read-more,
    .cd-timeline-content .cd-date {
        display: inline-block;
    }

    .cd-timeline-content p {
        margin: .5em 0;
        line-height: 1.6;
    }

    .cd-timeline-content .cd-read-more {
        float: left;
        padding: 0.8em 1em;
        background: #acb7c0;
        color: #ffffff;
        border-radius: 0.25em;
    }

    .no-touch .cd-timeline-content .cd-read-more:hover {
        background-color: #bac4cb;
    }

    .cd-timeline-content .cd-date {
        float: right;
        padding: 0.8em 0;
        opacity: 0.7;
    }

    .cd-timeline-content::before {
        content: "";
        position: absolute;
        top: 16px;
        left: 100%;
        height: 0;
        width: 0;
        border: 7px solid transparent;
        border-left: 7px solid #d7e4ed;
    }

    @media only screen and (min-width: 768px) {
        .cd-timeline-content h2 {
            font-size: 20px;
            font-size: 1.25rem;
        }

        .cd-timeline-content p {
            font-size: 16px;
            font-size: 1rem;
        }

        .cd-timeline-content .cd-read-more,
        .cd-timeline-content .cd-date {
            font-size: 14px;
            font-size: 0.875rem;
        }


    }
    @media only screen and (max-width: 1170px) {


        .cd-timeline-img i {
            margin-top: 7px;
        }
    }


    @media only screen and (min-width: 1170px) {
        .cd-timeline-content {
            margin-right: 0;
            padding: .6em 1.6em;
            width: 45%;
        }

        .cd-timeline-content::before {
            top: 24px;
            right: 100%;
            border-color: transparent;
            border-right-color: #d7e4ed;
        }

        .cd-timeline-content .cd-read-more {
            float: right;
        }

        .cd-timeline-content .cd-date {
            position: absolute;
            width: 100%;
            right: 122%;
            top: 6px;
            font-size: 16px;
            font-size: 1rem;
        }

        .cd-timeline-block:nth-child(even) .cd-timeline-content {
            float: left;
        }

        .cd-timeline-block:nth-child(even) .cd-timeline-content::before {
            top: 24px;
            right: auto;
            left: 100%;
            border-color: transparent;
            border-left-color: #d7e4ed;
        }

        .cd-timeline-block:nth-child(even) .cd-timeline-content .cd-read-more {
            float: left;
        }

        .cd-timeline-block:nth-child(even) .cd-timeline-content .cd-date {
            right: auto;
            left: 122%;
            text-align: left;
        }

        .cssanimations .cd-timeline-content.is-hidden {
            visibility: hidden;
        }

        .cssanimations .cd-timeline-content.bounce-in {
            visibility: visible;
            -webkit-animation: cd-bounce-2 0.6s;
            -moz-animation: cd-bounce-2 0.6s;
            animation: cd-bounce-2 0.6s;
        }
    }

    @media only screen and (min-width: 1170px) {
        /* inverse bounce effect on even content blocks */
        .cssanimations .cd-timeline-block:nth-child(even) .cd-timeline-content.bounce-in {
            -webkit-animation: cd-bounce-2-inverse 0.6s;
            -moz-animation: cd-bounce-2-inverse 0.6s;
            animation: cd-bounce-2-inverse 0.6s;
        }
    }

    @-webkit-keyframes cd-bounce-2 {
        0% {
            opacity: 0;
            -webkit-transform: translateX(100px);
        }
        60% {
            opacity: 1;
            -webkit-transform: translateX(-20px);
        }
        100% {
            -webkit-transform: translateX(0);
        }
    }

    @-moz-keyframes cd-bounce-2 {
        0% {
            opacity: 0;
            -moz-transform: translateX(100px);
        }
        60% {
            opacity: 1;
            -moz-transform: translateX(-20px);
        }
        100% {
            -moz-transform: translateX(0);
        }
    }

    @keyframes cd-bounce-2 {
        0% {
            opacity: 0;
            -webkit-transform: translateX(100px);
            -moz-transform: translateX(100px);
            -ms-transform: translateX(100px);
            -o-transform: translateX(100px);
            transform: translateX(100px);
        }
        60% {
            opacity: 1;
            -webkit-transform: translateX(-20px);
            -moz-transform: translateX(-20px);
            -ms-transform: translateX(-20px);
            -o-transform: translateX(-20px);
            transform: translateX(-20px);
        }
        100% {
            -webkit-transform: translateX(0);
            -moz-transform: translateX(0);
            -ms-transform: translateX(0);
            -o-transform: translateX(0);
            transform: translateX(0);
        }
    }

    @-webkit-keyframes cd-bounce-2-inverse {
        0% {
            opacity: 0;
            -webkit-transform: translateX(-100px);
        }
        60% {
            opacity: 1;
            -webkit-transform: translateX(20px);
        }
        100% {
            -webkit-transform: translateX(0);
        }
    }

    @-moz-keyframes cd-bounce-2-inverse {
        0% {
            opacity: 0;
            -moz-transform: translateX(-100px);
        }
        60% {
            opacity: 1;
            -moz-transform: translateX(20px);
        }
        100% {
            -moz-transform: translateX(0);
        }
    }

    @keyframes cd-bounce-2-inverse {
        0% {
            opacity: 0;
            -webkit-transform: translateX(-100px);
            -moz-transform: translateX(-100px);
            -ms-transform: translateX(-100px);
            -o-transform: translateX(-100px);
            transform: translateX(-100px);
        }
        60% {
            opacity: 1;
            -webkit-transform: translateX(20px);
            -moz-transform: translateX(20px);
            -ms-transform: translateX(20px);
            -o-transform: translateX(20px);
            transform: translateX(20px);
        }
        100% {
            -webkit-transform: translateX(0);
            -moz-transform: translateX(0);
            -ms-transform: translateX(0);
            -o-transform: translateX(0);
            transform: translateX(0);
        }
    }
</style>
<?php
$logs = Log::where(['order'=>'DESC','order_by'=>'id','uid'=>$_GET['user']]);
?>
<div class="dashboard-welcome-box cssanimations">
    <div class="dashboard-welcome-box-inner clearfix">
        <div class="dashboard-welcome-box-desc">

			<?php if ( $logs ): ?>
                <h4 style="text-align: center">فعالیت های کاربر</h4>
                <section id="cd-timeline" class="cd-container">
					<?php foreach ( $logs as $log ):

						switch ( $log->type ) {
							case 'register':
								$icon  = '<i class="fal fa-user"></i>';
								$color = 'cd-green';
								break;
							case 'change_mobile':
							case 'mobile_approved':
								$icon  = '<i class="fal fa-mobile"></i>';
								$color = 'cd-red';
								break;
							default:
								$icon  = '<i class="fal fa-info"></i>';
								$color = 'cd-yello';
								break;
						}

						?>
                        <div class="cd-timeline-block">
                            <div class="cd-timeline-img <?= $color ?>">
								<?= $icon ?>
                            </div> <!-- cd-timeline-img -->

                            <div class="cd-timeline-content">
                                <p><?= $log->content ?></p>
                                <span class="cd-date"><?= date_i18n( 'd M Y - h:i a', strtotime( $log->created_at ) ) ?></span>
                            </div> <!-- cd-timeline-content -->
                        </div> <!-- cd-timeline-block -->
					<?php endforeach; ?>

                </section> <!-- cd-timeline -->
			<?php else: ?>
            در حال حاضر فعالیتی وجود ندارد
            <?php endif; ?>
        </div>
    </div>
</div>


<?php endif; ?>
