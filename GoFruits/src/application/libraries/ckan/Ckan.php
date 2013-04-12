<?php if(!defined( 'BASEPATH' )) {
    exit( 'No direct script access allowed' );
}

    /**
     * Class Ckan
     */
    class Ckan
    {
        /**
         * Url del host donde se obtendran los datos del ckan
         * @var string
         * @example 'http://data.caribbeanopeninstitute.org/'
         */
        private $baseUrl = '';

        /**
         * API key para efectuar cambio en la base de datos o dataset
         * @var string
         * @example 'a57cc518-f9bf-44ed-beeb-b0a416844359'
         */
        private $apiKey = '';

        /**
         * @var bool
         */
        private $useProxy = false;

        /**
         * @var string
         */
        private $proxyHost = '';

        /**
         * @var int
         */
        private $proxyPort = 0;

        private $proxyUserName = '';

        private $proxyPassword = '';

        private $chHeaders = array();

        private $userAgent = '';

        /**
         * @param bool $baseUrl
         * @param bool $apiKey
         */
        function __construct( $baseUrl = false, $apiKey = false )
        {
            if(false !== $baseUrl) {
                $this->baseUrl = $baseUrl;
            } else {
                $this->baseUrl = "";
            }

            if(false !== $apiKey) {
                $this->apiKey = $apiKey;
            } else {
                $this->apiKey = "";
            }

            $this->setHeaders();

            $this->setUserAgent();
        }

        public function curl()
        {
            $data = 'params';
            $url  = "http://search.yahooapis.com/WebSearchService/V1/spellingSuggestion?appid=YahooDemo&query=apocalipto";
            $ch   = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_GET, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
            $response = curl_exec( $ch );
            curl_close( $ch );
            echo $response;
        }

        /**
         * @param string $request
         * @param array  $params
         *
         * @return string
         * @throws Exception Throw an exception if couldn't make a cURL request.
         */
        public function getData( $request = '', $params = array() )
        {
            //generate the url
            $queryString = '';
            foreach( $params as $key => $value ) {
                $queryString .= sprintf( '%1$s=%2$s&', $key, urlencode( $value ) );
            }

            $url = $this->getBaseUrl() . $request;
            if(!empty( $queryString )) {
                $url .= '?' . $queryString;
            }

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

            if($this->getUseProxy()) {
                curl_setopt( $ch, CURLOPT_PROXYAUTH, CURLAUTH_NTLM );
                curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );

                if(0 === $this->proxyPort && empty( $this->proxyHost )) {
                    throw new Exception( 'If you use proxy, you must define the proxyHost and proxyPort.' );
                } else {
                    curl_setopt( $ch, CURLOPT_PROXY, "$this->proxyHost:$this->proxyPort" );
                    curl_setopt( $ch, CURLOPT_PROXYUSERPWD, "$this->proxyUserName:$this->proxyPassword" );
                }
            }

            if(curl_exec( $ch ) === false) {
                $error = curl_error( $ch );

                if(empty( $error )) {
                    throw new Exception( 'Error connection, check if you are behind a firewall.' );
                } else {
                    throw new Exception( 'Curl Exception: ' . $error );
                }
            }

            $response = curl_multi_getcontent( $ch );
            curl_close( $ch );

            return $response;
        }

        public function setData( $request = '', $params = array() )
        {
            //TODO: Terminar de hacer la funcion para enviar datos al servidor.
            //generate the url
            /*$queryString = '';
            foreach( $params as $key => $value ) {
                $queryString .= sprintf( '%1$s=%2$s&', $key, urlencode( $value ) );
            }*/

            $url = $this->getBaseUrl() . $request;
            /*if(!empty( $queryString )) {
                $url .= '?' . $queryString;
            }*/

            $ch = curl_init();
            curl_setopt( $ch, CURLOPT_URL, $url );
            curl_setopt( $ch, CURLOPT_URL, strtoupper('POST') );
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_USERAGENT, 'Ckan-PHP/%s' );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );

            if($this->apiKey) {
                $this->chHeaders[] = 'Authorization: ' . $this->getApiKey();
                $this->chHeaders[] = array('Content-type: text/plain', sprintf('Content-length: 100'));
            }
            else{
                throw new Exception('You must set up your API key to make changes');
            }
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->chHeaders );

            if($this->getUseProxy()) {
                curl_setopt( $ch, CURLOPT_PROXYAUTH, CURLAUTH_NTLM );
                curl_setopt( $ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );

                if(0 === $this->proxyPort && empty( $this->proxyHost )) {
                    throw new Exception( 'If you use proxy, you must define the proxyHost and proxyPort.' );
                } else {
                    curl_setopt( $ch, CURLOPT_PROXY, "$this->proxyHost:$this->proxyPort" );
                    curl_setopt( $ch, CURLOPT_PROXYUSERPWD, "$this->userName:$this->password" );
                }
            }

            $info = curl_getinfo( $ch );
            echo "<pre>";
            print_r($info);
            echo "</pre>";
            exit;

            if(curl_exec( $ch ) === false) {
                $info = curl_getinfo( $ch );

                $error = curl_error( $ch );

                if(empty( $error )) {
                    throw new Exception( 'Error connection, check if you are behind a firewall.' );
                } else {
                    throw new Exception( 'Curl Exception: ' . $error );
                }
            }

            $response = curl_multi_getcontent( $ch );
            curl_close( $ch );

            return $response;
        }

        /**
         * Sets the custom cURL headers.
         *
         * @access    private
         * @return    void
         * @since    Version 0.1.0
         */
        private function setHeaders()
        {
            $date            = new DateTime( NULL, new DateTimeZone( 'UTC' ) );
            $this->chHeaders = array(
                'Date: ' . $date->format( 'D, d M Y H:i:s' ) . ' GMT', // RFC 1123
                'Accept: application/json;q=1.0, application/xml;q=0.5, */*;q=0.0',
                'Accept-Charset: utf-8',
                'Accept-Encoding: gzip'
            );
        }

        /**
         * Parse the response from the CKAN API.
         *
         * @access    private
         *
         * @param bool $data
         * @param bool $assoc
         *
         * @internal param string $format
         *
         * @internal param \Data $string returned from the CKAN API.
         * @internal param \Format $string of data returned from the CKAN API.
         *
         * @return    mixed    If success, either an array or object. Otherwise FALSE.
         * @since    Version 0.1.0
         */
        public function parseResponse( $data = false, $assoc = false )
        {
            if($data) {
                return json_decode( $data, $assoc );
            }

            return FALSE;
        }

        /**
         * Sets the Ckan_client user agent string.
         *
         * @access    private
         * @return    void
         * @since    Version 0.1.0
         */
        private function setUserAgent()
        {
            if('80' === @$_SERVER[ 'SERVER_PORT' ]) {
                $server_name = 'http://' . $_SERVER[ 'SERVER_NAME' ];
            } else {
                $server_name = '';
            }
            $this->userAgent = sprintf( $this->userAgent ) . ' (' . $server_name . $_SERVER[ 'PHP_SELF' ] . ')';
        }

        /**
         * @param string $apiKey
         */
        public function setApiKey( $apiKey )
        {
            $this->apiKey = $apiKey;
        }

        /**
         * @return string
         */
        public function getApiKey()
        {
            return $this->apiKey;
        }

        /**
         * @param string $baseUrl
         */
        public function setBaseUrl( $baseUrl )
        {
            $this->baseUrl = $baseUrl;
        }

        /**
         * @return string
         */
        public function getBaseUrl()
        {
            return $this->baseUrl;
        }

        /**
         * @param int $proxyPort
         */
        public function setProxyPort( $proxyPort )
        {
            $this->proxyPort = $proxyPort;
        }

        /**
         * @return int
         */
        public function getProxyPort()
        {
            return $this->proxyPort;
        }

        /**
         * @param boolean $useProxy
         */
        public function setUseProxy( $useProxy )
        {
            $this->useProxy = $useProxy;
        }

        /**
         * @return boolean
         */
        public function getUseProxy()
        {
            return $this->useProxy;
        }

        /**
         * @param string $proxyHost
         */
        public function setProxyHost( $proxyHost )
        {
            $this->proxyHost = $proxyHost;
        }

        /**
         * @return string
         */
        public function getProxyHost()
        {
            return $this->proxyHost;
        }

        public function setProxyUserName( $proxyUserName )
        {
            $this->proxyUserName = $proxyUserName;
        }

        public function getProxyUserName()
        {
            return $this->proxyUserName;
        }

        public function setProxyPassword( $proxyPassword )
        {
            $this->proxyPassword = $proxyPassword;
        }

        public function getProxyPassword()
        {
            return $this->proxyPassword;
        }


    }
