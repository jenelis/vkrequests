<?php

    class requests
    {
        private $token;
        private $version_api;
        private $vk_url_to_requests = 'https://api.vk.com/method/';
        function __construct (string $token, string $version_api)
        {
            $this->token = $token;
            $this->version_api = $version_api;
        }

        public function getVersionAPI ()
        {
            return $this->version_api;
        }
        public function setVersionAPI (string $version_api)
        {
            $this->version_api = $version_api;
        }

        public function request ($method, $arguments)
        {
            $arguments['v'] = $this->version_api;
            $arguments['access_token'] = $this->token;

            $url = $this->vk_url_to_requests . $method . '?' . http_build_query($arguments);
            if (function_exists('curl_exec')) {
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($ch);

                curl_close($ch);
            } else {
                $response = file_get_contents($url);
            }

            if ($response === false) {
                return ['status' => 'false', 'data' => 'Проблема в интернет соединении, или у вк проблемы'];
            } else {
                return ['status' => 'true', 'data' => json_decode($response, true)];
            }
        }
    }