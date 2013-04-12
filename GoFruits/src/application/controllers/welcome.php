<?php if(!defined( 'BASEPATH' )) {
    exit( 'No direct script access allowed' );
}

    class Welcome extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();

            $this->load->model( 'ckan_model' );
        }

        /**
         * Index Page for this controller.
         *
         * Maps to the following URL
         *        http://example.com/index.php/welcome
         *    - or -
         *        http://example.com/index.php/welcome/index
         *    - or -
         * Since this controller is set as the default controller in
         * config/routes.php, it's displayed at http://example.com/
         *
         * So any other public methods not prefixed with an underscore will
         * map to /index.php/welcome/<method_name>
         * @see http://codeigniter.com/user_guide/general/urls.html
         */
        public function index()
        {
            $crops      = array();
            $crop_types = $this->ckan_model->getCropTypes();

            foreach( $crop_types as $crop ) {
                $crops[ ] = sprintf( '"%s"', $crop->CropType );
            }

            $data[ 'crop_types' ] = $crops;

            $this->load->view( 'header' );
            $this->load->view( 'home', $data );
            $this->load->view( 'footer' );
        }

        public function getCropsByName( $name = "" )
        {
            if(empty( $name )) {
                $name = $this->input->post( 'name' );
            }

            $crop = $this->ckan_model->getCropsByName( $name );

            echo json_encode($crop);
        }

        public function curl()
        {
            $this->load->library( 'ckan/ckan' );

            $this->ckan->setUseProxy( true );
            $this->ckan->setProxyHost( '127.0.0.1' );
            $this->ckan->setProxyPort( 3128 );

            $this->ckan->setBaseUrl( 'http://data.caribbeanopeninstitute.org' );
            $this->ckan->setApiKey( 'a57cc518-f9bf-44ed-beeb-b0a416844359' );

            try {
                // search if a dataset or resource exist in any database
                //$data = $this->ckan->getData('/api/search/dataset', array('q' => 'crops'));
                //$data = $this->ckan->parseResponse($data, false);

                // obtener la informacion del dataset
                $data = $this->ckan->getData( '/api/rest/dataset/gofruits' );
                $data = $this->ckan->parseResponse( $data );

                // print al the resources IDs
                foreach( $data->resources as $resource ) {
                    echo sprintf( 'Name: %s<br>', $resource->name );
                    echo sprintf( 'ID: %s<br>', $resource->id );
                    echo sprintf( 'Format: %s<br>', $resource->format );
                }

                // obtener 1 tupla de la tabla crops (resource especifico) dado su id
                $params = array(
                    'resource_id' => '92fa2fc0-c89b-4150-8f80-69ee97af23ae',
                    'limit'       => 1
                );
                //$data = $this->ckan->getData('/api/action/datastore_search', $params);
                //$data = $this->ckan->parseResponse($data);


                // obtener 1 tupla de la tabla farms (resource especifico) dado su id
                $params = array(
                    'resource_id' => '5334fe13-f285-47e3-b12d-5e9f0e3ddc98',
                    'limit'       => 1
                );
                //$data = $this->ckan->getData('/api/action/datastore_search', $params);
                //$data = $this->ckan->parseResponse($data);

                //VARIANTE SQL
                $params = array(
                    'sql' => 'SELECT * FROM "5334fe13-f285-47e3-b12d-5e9f0e3ddc98" LIMIT 1'
                );

                $data = $this->ckan->getData( '/api/action/datastore_search_sql', $params );
                $data = $this->ckan->parseResponse( $data );

                echo "<h3>tabla farms</h3>";
                echo "<pre>";
                print_r( $data );
                echo "</pre>";

                // select para la tabla 'farms-headers'
                $params = array(
                    'sql' => 'SELECT * FROM "1dfab78d-d69f-4787-9773-646b4c951b7f" LIMIT 1'
                );
                $data   = $this->ckan->getData( '/api/action/datastore_search_sql', $params );
                $data   = $this->ckan->parseResponse( $data );

                echo "<h3>farms-headers</h3>";
                echo "<pre>";
                print_r( $data );
                echo "</pre>";

                // select para el join de las tablas del farms con farms-headers
                $params = array(
                    'sql' => 'SELECT * FROM "1dfab78d-d69f-4787-9773-646b4c951b7f" fheader, "5334fe13-f285-47e3-b12d-5e9f0e3ddc98" farms WHERE "fheader"."FarmerID" = "farms"."604059282"'
                );

                /*$params = array(
                    'sql' => 'SELECT "cheader"."CropType"
                    FROM
                    "66247f9e-750c-4ec4-97b7-b5801696a7c0" cheader,
                    "92fa2fc0-c89b-4150-8f80-69ee97af23ae" crops,
                    "1dfab78d-d69f-4787-9773-646b4c951b7f" fheader,
                    "5334fe13-f285-47e3-b12d-5e9f0e3ddc98" farms
                    WHERE
                    "cheader"."FarmerID" = "crops"."201001261"
                    AND "cheader"."FarmerID" = "fheader"."FarmerID"
                    AND "fheader"."FarmerID" = "farms"."604059282";'
                );*/

                //select all crop types
                $params = array(
                    'sql' => 'SELECT DISTINCT "crops"."Pumpkin" AS "CropType"
                FROM
                "92fa2fc0-c89b-4150-8f80-69ee97af23ae" crops ORDER BY "CropType" ASC;'
                );
                $data   = $this->ckan->getData( '/api/action/datastore_search_sql', $params );
                $data   = $this->ckan->parseResponse( $data );

                echo "<h3>farms-JOIN</h3>";
                echo "<pre>";
                print_r( $data );
                echo "</pre>";

                exit;


            } catch(Exception $ex) {
                print $ex->getMessage();
            }

            try {
                //create a new resource

                // create the columns name
                $columns = array(
                    array( 'id' => 'id_persona', 'type' => 'int' ),
                    array( 'id' => 'nombre', 'type' => 'text' ),
                    array( 'id' => 'fecha_nacimiento', 'type' => 'date' ),
                );

                $records = array(
                    array( 'id_persona' => 1, 'nombre' => 'Pablo Molina', 'fecha_nacimiento' => '1988-12-19' )
                );

                $params = array(
                    'fields'      => json_encode( $columns ),
                    'records'     => json_encode( $records ),
                    'primary_key' => 'id_persona',
                    'indexes'     => 'id_persona'
                );

                $data = $this->ckan->setData( '/api/action/datastore_create', $params );

                echo "<pre>";
                print_r( $data );
                echo "</pre>";
            } catch(Exception $ex) {
                print $ex->getMessage();
            }
        }

        public function curl2()
        {
            // datahub.io API key: 07608dc2-648f-4a44-9f6e-fb2667bfa084

            $base_url     = 'http://demo.ckan.org/api/3/action/tag_list';
            $query_string = '';
            $params       = array(
                'method'  => 'flickr.test.echo',
                'name'    => 'Sami',
                'api_key' => 'YOUR_API_KEY'
            );

            /*foreach( $params as $key => $value ) {
                $query_string .= "$key=" . urlencode( $value ) . "&";
            }*/

            $curl = curl_init( $base_url );
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $curl, CURLOPT_FAILONERROR, true );
            curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
            //curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=" . $file->getToken(), "GData-Version:3.0"));

            if(curl_exec( $curl ) === false) {
                echo 'Curl error: ' . curl_error( $curl );
                die();
            }

            $response = curl_multi_getcontent( $curl );
            curl_close( $curl );

            var_dump( $response );
        }
    }

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */