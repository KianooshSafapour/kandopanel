<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$title = __("Your orders", SAMYAR_TEXT_DOMAIN);
?>


<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("API documentation", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php _e("Note: Please read the API instructions carefully.", SAMYAR_TEXT_DOMAIN); ?>
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <td><?php _e("HTTP method", SAMYAR_TEXT_DOMAIN); ?></td>
                <td>POST</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php _e("Answer format", SAMYAR_TEXT_DOMAIN); ?></td>
                <td>Json</td>
            </tr>
            <tr>
                <td>API URL</td>
                <td><a class="CopyToClipBoard2" href="<?= get_rest_url( '', 'api/v1' ) ?>"><?= get_rest_url( '', 'api/v1' ) ?>&nbsp;<i class="fal fa-copy"></i></a></td>

            </tr>

            <tr>
                <td><?php _e("API key", SAMYAR_TEXT_DOMAIN); ?></td>
                <td>
					<?php
                    if ( is_user_logged_in() ):
						$token = get_user_meta( get_current_user_id(), 'api_token', wp_generate_password( 32, false ) );
						if ( $token ) :
                            ?>
<!--                            <a class="CopyToClipBoard2" href="--><?php //= kando_hide_api_key( $token )  ?><!--">--><?php //= kando_hide_api_key( $token )  ?><!--&nbsp;</a>-->
<!--                        <br>-->
                            <?php
                            $text = __('Go to your <a href="%s" target="_self">Edit Profile</a> section and click on Generate New in the API Key section.', SAMYAR_TEXT_DOMAIN);
                            $link = home_url('dashboard/?action=edit-profile');
                            echo sprintf($text, esc_url($link));
                            ?>
                        <?php
						else:
                            _e("Log in to edit your profile and tap New Production in the API Key section", SAMYAR_TEXT_DOMAIN);
						endif;
					else:
                        _e("You must be logged in to receive an API key", SAMYAR_TEXT_DOMAIN);
					endif; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("New order", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <div class="kt-col-xs-12 kt-col-md-12" style="margin-bottom:10px">
            <select name="filter_type" class="ajaxChangeOrderType">
                    <option value="default">default</option>
                    <option value="custom_comments">custom comments</option>
                <!--
                <option value="package">Package</option>
                    <option value="mentions_with_hashtags">Mentions with Hashtags</option>
                    <option value="mentions_custom_list">Mentions Custom List</option>
                    <option value="mentions_hashtag">Mentions Hashtag</option>
                    <option value="mentions_user_followers">Mentions User Followers</option>
                    <option value="mentions_media_likers">Mentions Media Likers</option>
                    <option value="custom_comments_package">Custom Comments Package</option>
                    <option value="comment_likes">Comment Likes</option>
                    <option value="poll">Poll</option>
                    <option value="comment_replies">Comment Replies</option>
                    <option value="invites_from_groups">Invites from Groups</option>
                    <option value="subscriptions">Subscriptions</option>
-->
            </select>
        </div>

        <!-- Default -->
        <table class="table table-hover table-order-type table-bordered  service-default">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>runs (optional)</td>
                <td>Runs to deliver</td>
            </tr>
            <tr>
                <td>interval (optional)</td>
                <td>Interval in minutes</td>
            </tr>
            </tbody>
        </table>
        <!-- package -->
        <table class="table table-hover table-order-type table-bordered service-package d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>

            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>

            </tbody>
        </table>

        <!-- Custom Comments -->
        <table class="table table-hover table-order-type table-bordered service-custom_comments d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>comments</td>
                <td>Comments list separated by \r\n or \n</td>
            </tr>
            </tbody>
        </table>

        <!-- mentions_with_hashtags -->
        <table class="table table-hover table-order-type table-bordered service-mentions_with_hashtags d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>usernames</td>
                <td>Usernames list separated by \r\n or \n</td>
            </tr>
            <tr>
                <td>hashtags</td>
                <td>Hashtags list separated by \r\n or \n</td>
            </tr>
            </tbody>
        </table>

        <!-- mentions_custom_list -->
        <table class="table table-hover table-order-type table-bordered service-mentions_custom_list d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>usernames</td>
                <td>Usernames list separated by \r\n or \n</td>
            </tr>
            </tbody>
        </table>

        <!-- mentions-hashtag -->
        <table class="table table-hover table-order-type table-bordered service-mentions_hashtag d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>

            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>

            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>

            <tr>
                <td>hashtag</td>
                <td>Hashtag to scrape usernames from</td>
            </tr>

            </tbody>
        </table>

        <!-- mentions-user-followers -->
        <table class="table table-hover table-order-type table-bordered service-mentions_user_followers d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>username</td>
                <td>URL to scrape followers from</td>
            </tr>

            </tbody>
        </table>

        <!-- custom-comments-package -->
        <table class="table table-hover table-order-type table-bordered service-custom_comments_package d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>comments</td>
                <td>Comments list separated by \r\n or \n</td>
            </tr>

            </tbody>
        </table>

        <!-- mentions-media-likers -->
        <table class="table table-hover table-order-type table-bordered service-mentions_media_likers d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>

            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>

            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>

            <tr>
                <td>media</td>
                <td>Media URL to scrape likers from</td>
            </tr>

            </tbody>
        </table>

        <!-- comment-likes -->
        <table class="table table-hover table-order-type table-bordered service-comment_likes d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>username</td>
                <td>Username of the comment owner</td>
            </tr>
            </tbody>
        </table>



        <!-- poll -->
        <table class="table table-hover table-order-type table-bordered service-poll d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>answer_number</td>
                <td>Answer number of the poll</td>
            </tr>
            </tbody>
        </table>

        <!-- comment-replies -->
        <table class="table table-hover table-order-type table-bordered service-comment_replies d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>username</td>
                <td>Username</td>
            </tr>
            <tr>
                <td>comments</td>
                <td>Comments list separated by \r\n or \n</td>
            </tr>
            </tbody>
        </table>

        <!-- invites_from_groups -->
        <table class="table table-hover table-order-type table-bordered service-invites_from_groups d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>link</td>
                <td>Link to page</td>
            </tr>
            <tr>
                <td>quantity</td>
                <td>Needed quantity</td>
            </tr>
            <tr>
                <td>groups</td>
                <td>Groups list separated by \r\n or \n</td>
            </tr>
            </tbody>
        </table>

        <!-- Subscriptions -->
        <table class="table table-hover table-order-type table-bordered service-subscriptions d-none">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td>Your API key</td>
            </tr>
            <tr>
                <td>action</td>
                <td>add</td>
            </tr>
            <tr>
                <td>service</td>
                <td>Service ID</td>
            </tr>
            <tr>
                <td>username</td>
                <td>Username</td>
            </tr>
            <tr>
                <td>min</td>
                <td>Quantity min</td>
            </tr>
            <tr>
                <td>max</td>
                <td>Quantity max</td>
            </tr>
            <tr>
                <td>posts (optional)</td>
                <td>Use this parameter if you want to limit the number of new (future) posts that will be parsed and for which orders will be created. If posts parameter is not set, the subscription will be created for an unlimited number of posts.</td>
            </tr>
            <tr>
                <td>old_posts (optional)</td>
                <td>Number of existing posts that will be parsed and for which orders will be created, can be used if this option is available for the service.</td>
            </tr>
            <tr>
                <td>delay</td>
                <td>Delay in minutes</td>
            </tr>
            <tr>
                <td>expiry (optional)</td>
                <td>Expiry date. Format d/m/Y</td>
            </tr>

            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>{
  "status": "success",
  "order": 32
}</pre>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("List of services", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>services</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>[
  {
      "service": "5",
      "name": "Instagram Followers [15K] ",
      "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
      "rate": "1.02",
      "min": "500",
      "max": "10000"
      "type": default
      "desc": usernames
      "dripfeed": 1
  },
  {
      "service": "9",
      "name": "Instagram Followers - Max 300k - No refill - 30-40k\/Day",
      "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
      "rate": "0.04",
      "min": "500",
      "max": "300000"
      "type": default
      "desc": usernames
      "dripfeed": 1
  },
  {
      "service": "10",
      "name": "Instagram Followers ( 30 days auto refill ) ( Max 350K ) (Indian Majority )",
      "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
      "rate": "1.2",
      "min": "100",
      "max": "350000"
      "type": default
      "desc": usernames
      "dripfeed": 1
  }
]</pre>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("Order status", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>status</td>
            </tr>
            <tr>
                <td>order</td>
                <td><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>
{
  "order": "32",
  "status": "pending",
  "charge": "0.0360",
  "start_count": "0",
  "remains": "0"
}</pre>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"> <?php _e("Status of multiple orders", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>status</td>
            </tr>
            <tr>
                <td>orders</td>
                <td><?php _e("Your order IDs are comma separated (array data)", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>  {
      "12": {
          "order": "12",
          "status": "processing",
          "charge": "1.2600",
          "start_count": "0",
          "remains": "0"
      },
      "2": "Incorrect order ID",
      "13": {
          "order": "13",
          "status": "pending",
          "charge": "0.6300",
          "start_count": "0",
          "remains": "0"
      }
  }</pre>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("Sending a refill order", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>refill</td>
            </tr>
            <tr>
                <td>order</td>
                <td><?php _e("Order ID", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>
{
    "refill": "1"
}</pre>
    </div>
</div>

<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("Getting the refill order status", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>refill_status</td>
            </tr>
            <tr>
                <td>refill</td>
                <td><?php _e("Refill ID", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>
{
    "status": "Completed"
}</pre>
    </div>
</div>




<div class="dashboard-posts-box dashboard-tickets-box api-documentation">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e("Balance", SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <table class="table table-hover table-bordered projects">
            <thead>
            <tr>
                <th><?php _e("Parameter", SAMYAR_TEXT_DOMAIN); ?></th>
                <th><?php _e("Description", SAMYAR_TEXT_DOMAIN); ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>key</td>
                <td><?php _e("Your API key", SAMYAR_TEXT_DOMAIN); ?></td>
            </tr>
            <tr>
                <td>action</td>
                <td>balance</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="card-body">
        <?php _e("Example answer:", SAMYAR_TEXT_DOMAIN); ?>
        <pre>  {
      "status": "success",
      "balance": "0.03",
      "currency": "USD"
  }</pre>
    </div>
</div>
<script>
    'use strict';
    var $j = jQuery;
    // callback ajaxChange
    $j(document).on("change", ".ajaxChangeOrderType", function () {
        event.preventDefault();
        var _that = $j(this),
            _type = _that.val();

        $j(".table-order-type").addClass("d-none");
        $j(".service-"+_type).removeClass("d-none");

        /*
        switch (_type) {

            case "package":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").removeClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            case "custom_comments":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").removeClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            case "mentions_with_hashtags":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").removeClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            case "mentions_custom_list":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").removeClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            case "mentions_hashtag":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").removeClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            case "mentions_user_followers":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").removeClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;

            case "mentions_media_likers":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").removeClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;

            case "custom_comments_package":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").removeClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;

            case "comment_likes":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").removeClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;

            case "subscriptions":
                $j(".table.service-default").addClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").removeClass("d-none");
                break;
            case "poll":
                $j(".table.service-default").removeClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
            default:
                $j(".table.service-default").removeClass("d-none");
                $j(".table.service-package").addClass("d-none");
                $j(".table.service-custom-comments").addClass("d-none");
                $j(".table.service-mentions-with-hashtags").addClass("d-none");
                $j(".table.service-mentions-custom-list").addClass("d-none");
                $j(".table.service-mentions-hashtag").addClass("d-none");
                $j(".table.service-mentions-user-followers").addClass("d-none");
                $j(".table.service-mentions-media-likers").addClass("d-none");
                $j(".table.service-custom-comments-package").addClass("d-none");
                $j(".table.service-comment-likes").addClass("d-none");
                $j(".table.service-subscriptions").addClass("d-none");
                break;
        }

         */
    })

</script>