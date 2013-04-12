<?php

    class Ckan_Model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();

            $proxy = $this->config->item( 'proxy' );

            $this->load->library( 'ckan/ckan' );

            $this->ckan->setUseProxy( true );
            $this->ckan->setProxyHost( $proxy[ 'proxyHost' ] );
            $this->ckan->setProxyPort( $proxy[ 'proxyPort' ] );
            $this->ckan->setProxyUserName( $proxy[ 'proxyUser' ] );
            $this->ckan->setProxyPassword( $proxy[ 'proxyPass' ] );

            $this->ckan->setBaseUrl( 'http://data.caribbeanopeninstitute.org' );
            $this->ckan->setApiKey( 'a57cc518-f9bf-44ed-beeb-b0a416844359' );
        }

        /**
         * Devuelve todos los tipos de cultivo ordenados alfabeticamente
         * @return mixed
         */
        public function getCropTypes()
        {
            //select all crop types
            $params = array(
                'sql' => 'SELECT DISTINCT "crops"."Pumpkin" AS "CropType"
                FROM
                "92fa2fc0-c89b-4150-8f80-69ee97af23ae" crops ORDER BY "CropType" ASC;'
            );
            $data   = $this->ckan->getData( '/api/action/datastore_search_sql', $params );
            $data   = $this->ckan->parseResponse( $data );

            if(false === $data->success) {
                return array();
            }

            return $data->result->records;
        }

        /**
         * Devuelve todos los cultivos de ese nombre junto con sus coordenadas para plotearlos en el mapa
         *
         * @param $name string El nombre del cultivo a buscar.
         *
         * @return mixed
         */
        public function getCropsByName($name = '1=1')
        {
            //select all crop types
            $params = array(
                'sql' => sprintf('SELECT "crops"."1" AS "id", "crops"."Pumpkin" AS "CropType", "crops"."201001261" AS "FarmerID", "crops"."0.04" AS "CropArea", "crops"."MIDDLE" AS "FarmerAge", "crops"."-76.74091925" AS "Xcoord", "crops"."18.068764429" AS "Ycoord"
                FROM
                "92fa2fc0-c89b-4150-8f80-69ee97af23ae" crops WHERE "crops"."Pumpkin" LIKE \'%s\';', $name)
            );

            $data   = $this->ckan->getData( '/api/action/datastore_search_sql', $params );
            $data   = $this->ckan->parseResponse( $data );

            if(false === $data->success) {
                return array();
            }

            return $data->result->records;
        }
    }