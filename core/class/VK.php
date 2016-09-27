<?php

/**
 * VK class for vk.com social network
 */


class VK {

    /**
     * @param $method
     * @param array $params
     * @param bool $return_items
     * @return array
     */
    public function api($method, $params = [], $return_items = true) {
        if (!isset($params) || empty($params)) {
            $params = [];
        }

        if (!isset($params['access_token']) || empty($params['access_token'])) {
            $params['access_token'] = ACCESS_TOKEN;
        }

        $params['v'] = '5.27';

        $result = json_decode($this->sendQuery($method, $params), true);

        return $return_items ? $result['response']['items'] : $result['response'];
    }

    /**
     * @param $method
     * @param $post_data
     * @return string
     */
    private function sendQuery($method, $post_data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.vk.com/method/{$method}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17');

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;
    }
}
