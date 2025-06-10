<?php
// Define route mappings for better maintainability
$routes = [
    'dashboard' => SAMYAR_DIR_TEMPLATE . '/dashboard/dashboard.php',

    'orders' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/admin/edit.php',
        'user-orders' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/admin/user-orders.php',
        'dripfeed' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeeds.php',
        'subscriptions' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/subscriptions.php',
        'default' => SAMYAR_DIR_VIEW . '/orders/orders.php'
    ],

    'refill' => [
        'edit' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/refill/edit.php',
            'capability' => 'edit_order'
        ],
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/refill/orders.php'
    ],

    'cancel' => [
        'edit' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/cancel/edit.php',
            'capability' => 'edit_order'
        ],
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/cancel/orders.php'
    ],

    'notifications' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/notification/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/notification/edit.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/notification/notifications.php',
        'capability' => 'show_notifications'
    ],

    'social' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/social/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/social/edit.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/social/socials.php',
        'capability' => 'show_brands'
    ],

    'service-tags' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/service-tags/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/service-tags/edit.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/service-tags/tags.php',
        'capability' => 'show_brands'
    ],

    'categories' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/categories/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/categories/edit.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/categories/categories.php',
        'capability' => 'show_categories'
    ],

    'services' => [
        'new' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/add.php',
            'capability' => 'add_service'
        ],
        'edit' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/edit.php',
            'capability' => 'edit_service'
        ],
        'log' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/service_log.php',
            'capability' => 'show_service_log'
        ],
        'all' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/services-all.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/services.php'
    ],

    'payments' => [
        'payments' => SAMYAR_DIR_TEMPLATE . '/dashboard/payment/payments.php',
        'users-payment' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/payment/users-payment.php',
            'admin_only' => true
        ],
        'all' => [
            'file' => SAMYAR_DIR_TEMPLATE . '/dashboard/payment/all-payments.php',
            'admin_only' => true
        ],
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/payment/payments.php'
    ],

    'tickets' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/add.php',
        'show' => SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/show.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/tickets/tickets.php'
    ],

    'add-credit' => [
        'cart-to-cart' => SAMYAR_DIR_TEMPLATE . '/dashboard/wallet/cart-to-cart.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/wallet/add.php'
    ],

    'providers' => [
        'new' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/add.php',
        'edit' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/edit.php',
        'sync-services' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/sync-services.php',
        'service-list' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/service-list.php',
        'new-service' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/new-service/new-service-list.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/api-provider/providers.php',
        'capability' => 'show_providers'
    ],

    'edit-profile' => [
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/profile/edit.php'
    ],

    'api' => [
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/api/api.php'
    ],

    'timeline' => [
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/timeline.php',
        'admin_only' => true
    ],

    'get-package' => SAMYAR_DIR_TEMPLATE . '/dashboard/packages/packages.php',
    'updates' => SAMYAR_DIR_TEMPLATE . '/dashboard/updates/updates.php',

    'bulk-update-price' => [
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/services/bulk/bulk-update-price.php',
        'capability' => 'show_bulk_update_price'
    ],

    'dripfeeds' => [
        'dripfeeds' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeeds.php',
        'drips' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/drips.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/dripfeed/dripfeeds.php'
    ],

    'subscriptions' => [
        'subscriptions' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/subscriptions.php',
        'childs' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/childs.php',
        'default' => SAMYAR_DIR_TEMPLATE . '/dashboard/orders/subscriptions/subscriptions.php'
    ],

    'verify-mobile' => SAMYAR_DIR_TEMPLATE . '/dashboard/verify-mobile.php'
];

// Route handling function
function handle_route($action, $section, $routes) {
    if (!isset($routes[$action])) {
        do_action('panel_page_list');
        return;
    }

    $route = $routes[$action];

    // Handle simple routes (no sections)
    if (is_string($route)) {
        include_once($route);
        return;
    }

    // Handle routes with sections
    $section_key = isset($route[$section]) ? $section : 'default';

    if (!isset($route[$section_key])) {
        do_action('panel_page_list');
        return;
    }

    $target = $route[$section_key];

    // Check for capability requirements
    if (isset($route['capability']) && !kando_user_can($route['capability'])) {
        return;
    }



    // Check for admin-only routes
    if (isset($target['admin_only']) && $target['admin_only'] && !samyar_is_admin()) {
        return;
    }

    // Check for capability in specific section
    if (is_array($target) && isset($target['capability']) && !kando_user_can($target['capability'])) {
        return;
    }

    $file = is_array($target) ? $target['file'] : $target;

    if (file_exists($file)) {
        include_once($file);
    }
}

// Execute the route handling
handle_route($action, $section ?? '', $routes);