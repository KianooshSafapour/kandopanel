<?php


namespace samyar;


// -------------------------------------------------------------
// کلاس api اسمارت پنل
// -------------------------------------------------------------
use settingsController;

class smartPanelApi
{


// API URL
    public $api_url = '';

// Your API key
    public $api_key = '';

    public function __construct()
    {
        $options = settingsController::getInstance();
        $this->api_url = kando_get_option('api-url');
        $this->api_key = kando_get_option('api-key');
    }


    /**
     *
     * Add Order
     *
     */
    public function user_sync($data)
    {
        $post = array_merge(array('key' => $this->api_key, 'action' => 'user-sync'), $data);
        $result = $this->connect($post);

        return json_decode($result, true);
    }


    public function services_sync($data)
    {
        $post = array_merge(array('key' => $this->api_key, 'action' => 'services-sync'), $data);
        $result = $this->connect($post);

        return json_decode($result, true);
    }

    /**
     *
     * Balance
     *
     */
    public function balance()
    {
        if ((isset($this->api_key) && !empty($this->api_key)) && (isset($this->api_url) && !empty($this->api_url))) {
            $result = $this->connect(array(
                'key' => $this->api_key,
                'action' => 'balance',
            ));
            if ($result) {
                return json_decode($result);
            }
        }else{
            return NULL;
        }
    }

    /**
     *
     * Connect to panel
     *
     */
    private function connect($post)
    {
        if(empty($post)){
            return false;
        }
        $curl_args = array(
            'method' => 'POST',
            'timeout' => 15,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => $post,
            'cookies' => array()
        );


        $res = wp_remote_post($this->api_url, $curl_args);


        if (!is_wp_error($res)) {
            return $res['body'];
        }


    }

}