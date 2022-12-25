<?php
/**
 * Plugin Name: wp-apitest
 * Plugin URI: /wp-admin/admin.php?page=mainpage_wp_apitest
 * Description: Плагин для тестирования нгрузки сервера. Он создаёт несколько endpoints для тестирования сайта.
 * Version: 1.0.0
 * Author: Bogdanov Andrey
 * Author URI: mailto://swarzone2100@yandex.ru
 *
 * @package Тестирование API
 * @author Bogdanov Andrey (swarzone2100@yandex.ru)
 * @since 1.1.0
*/

function shortSql()
{
    global $wpdb;
    return $wpdb->get_results(
        "SELECT * FROM `" . $wpdb->prefix . "posts`",
        ARRAY_A
    );
}

function longSql()
{
  global $wpdb;
  return $wpdb->get_results(
      "SELECT `post_title`, `post_content`, COUNT(*) FROM(
          SELECT * , `meta`.`meta_key` AS key_meta, `meta`.`meta_value` AS value_meta FROM `" . $wpdb->prefix . "posts` AS posts
          LEFT JOIN `" . $wpdb->prefix . "postmeta` AS meta
          ON `posts`.`ID` = `meta`.`post_id`) AS result
       GROUP BY `post_title`, `post_content`",
      ARRAY_A
  );
}

add_action('rest_api_init', function()
{
    register_rest_route(
        'wp-apitest/v1',
        '/longsql',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $start = microtime(true);
                longSql();
                $end = microtime(true);
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Long sql query. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/shortsql',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $start = microtime(true);
                shortSql();
                $end = microtime(true);
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Short sql query. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/emptypoint',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $start = microtime(true);
                $end = microtime(true);
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Empty endpoint. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/trylogin',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $username = (string)$request->get_param('wp-apitest-username');
                $password = (string)$request->get_param('wp-apitest-password');

                if ( empty( $username ) || empty( $password ) )
                {
                    return [
                        'code' => -99,
                        'message' => 'Too few arguments for this argument.'
                    ];
                }

                $start = microtime(true);
                $auth = wp_authenticate( $username, $password );

                if ( is_wp_error( $auth ) )
                	 $error_string = $auth->get_error_message();
                else
                	 wp_set_auth_cookie( $auth->ID );

                $end = microtime(true);
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Login tried. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/phpinfo',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $start = microtime(true);
                phpinfo();
                $end = microtime(true);
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Call php info function. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/writefiletxt',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                $start = microtime(true);
                $text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
                file_put_contents(__DIR__ . '/wp-apitest-file.txt', $text);
                $end = microtime(true);
                unlink(__DIR__ . '/wp-apitest-file.txt');
                $runtime = $end - $start;

                return [
                    'code' => 0,
                    'message' => 'Query: Write lorem text in file and delete file. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );

    register_rest_route(
        'wp-apitest/v1',
        '/uploadpng',
        [
            'methods' => 'POST',
            'callback' => function(WP_REST_Request $request)
            {
                if ( empty( $_FILES['wp-apitest-file'] ) )
                {
                    return [
                        'code' => -99,
                        'message' => 'Too few arguments for this argument.'
                    ];
                }

                $start = microtime(true);
                move_uploaded_file($_FILES['wp-apitest-file']['tmp_name'], __DIR__ . '/wp-apitest-upload.png');
                $end = microtime(true);
                $runtime = $end - $start;
                unlink(__DIR__ . '/wp-apitest-upload.png');

                return [
                    'code' => 0,
                    'message' => 'Query: Upload Png. Lead time in microsecond: ' . $runtime
                ];
            }
        ]
    );
});

add_action('plugins_loaded', function()
{
    add_menu_page(
        'Тест API',
        'Плагин тестирования API',
        'manage_options',
        'mainpage_wp_apitest',
        'wp_apitest_mainpage_callback',
        'dashicons-admin-generic',
        20
    );
});

function wp_apitest_mainpage_callback()
{
   require_once(__DIR__.'/admin-view.php');
}
