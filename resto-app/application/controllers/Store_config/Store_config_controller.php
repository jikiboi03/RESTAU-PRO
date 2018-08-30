<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store_config_controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Store_config/Store_config_model','store');
    }

    public function index()                     
    {
        if($this->session->userdata('administrator') == '0')
        {
            redirect('error500');
        }

        $this->load->helper('url');

        $store = $this->store->get_by_id(1); // set 1 as ID since there is only 1 config entry
        
        $data['store'] = $store;                        

        $data['title'] = '<i class="fa fa-cogs"></i> Store Configurations';                 
        $this->load->view('template/dashboard_header',$data);
        $this->load->view('store_config/store_config_view',$data);
        $this->load->view('template/dashboard_navigation');
        $this->load->view('template/dashboard_footer');
    }


    // ================================================= IMAGE SECTION =====================================================


    public function do_upload() 
    {
        $version = 0;

        try
        {
            $img_name = $this->store->get_store_config_img(1);

            $version = explode("_", $img_name)[1]; // get index 1 of the exploded img_name to increment
        }
        catch (Exception $e) {
            // json_encode 'Caught exception: ',  $e->getMessage(), "\n";
        }

        $new_version = ($version + 1);

         $config['upload_path']   = 'assets/img'; 
         $config['allowed_types'] = 'png'; 
         $config['max_size']      = 2000; 
         $config['max_width']     = 5000; 
         $config['max_height']    = 5000;
         $new_name = 'complogo_' . $new_version . '_.png';
         $config['file_name'] = $new_name;
         $config['overwrite'] = TRUE;

         $this->load->library('upload', $config);
            
         if ( ! $this->upload->do_upload('userfile1')) // upload fail
         {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('upload_form', $error);
            // echo '<script type="text/javascript">alert("' . $error.toString() . '"); </script>';
         }
         else // upload success
         { 
            $data = array('upload_data' => $this->upload->data()); 
            
            $data = array(
                'img' => $new_name
            );
            $this->store->update(array('conf_id' => 1), $data); //  set id as 1 since there is only a single configuration
            redirect('/store-config-page');
         } 
    }


    // ======================================= END IMAGE SECTION ===========================================================
   
    // public function ajax_list()
    // {
    //     $list = $this->store->get_datatables();
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $store) {
    //         $no++;
    //         $row = array();
    //         $row[] = 'C' . $store->conf_id;
    //         $row[] = $store->name;
    //         $row[] = $store->descr;

    //         $row[] = $store->encoded;

    //         //add html for action
    //         $row[] = '<a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit_product('."'".$store->conf_id."'".')"><i class="fa fa-pencil-square-o"></i></a>
                      
    //                   <a class="btn btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_product('."'".$store->conf_id."'".', '."'".$store->name."'".')"><i class="fa fa-trash"></i></a>';
 
    //         $data[] = $row;
    //     }
 
    //     $output = array(
    //                     "draw" => $_POST['draw'],
    //                     "recordsTotal" => $this->store->count_all(),
    //                     "recordsFiltered" => $this->store->count_filtered(),
    //                     "data" => $data,
    //             );
    //     //output to json format
    //     echo json_encode($output);
    // }

    public function backup_db()
    {
        /**
         * Instantiate Backup_Database and perform backup
         */

        // Report all errors
        error_reporting(E_ALL);
        // Set script max execution time
        set_time_limit(900); // 15 minutes

        // if (php_sapi_name() != "cli") {
        //     echo '<div style="font-family: monospace;">';
        // }

        $backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
        $backupDatabase->obfPrint('Backup result: ' . $result, 1);

        // Use $output variable for further processing, for example to send it by email
        $output = $backupDatabase->getOutput();

        // if (php_sapi_name() != "cli") {
        //     echo '</div>';
        // }

        echo json_encode(array("status" => TRUE));
    }   
 
    public function ajax_edit($conf_id)
    {
        $data = $this->store->get_by_id($conf_id);
        echo json_encode($data);
    }
 
    // public function ajax_add()
    // {
    //     $this->_validate();
    //     $data = array(
    //             'name' => $this->input->post('name'),
    //             'descr' => $this->input->post('descr'),
                
    //             'removed' => 0
    //         );
    //     $insert = $this->store->save($data);
    //     echo json_encode(array("status" => TRUE));
    // }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'name' => $this->input->post('name'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'telephone' => $this->input->post('telephone'),
                'mobile' => $this->input->post('mobile'),
                'tin' => $this->input->post('tin'),
                'vat' => $this->input->post('vat'),
                'bs_price' => $this->input->post('bs_price'),
                'password' => $this->input->post('password')
            );
        $this->store->update(array('conf_id' => $this->input->post('conf_id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    // delete a store
    // public function ajax_delete($conf_id)
    // {
    //     $data = array(
    //             'removed' => 1
    //         );
    //     $this->store->update(array('conf_id' => $conf_id), $data);
    //     echo json_encode(array("status" => TRUE));
    // }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('name') == '')
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Store name / Company name is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('address') == '')
        {
            $data['inputerror'][] = 'address';
            $data['error_string'][] = 'Store address is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('city') == '')
        {
            $data['inputerror'][] = 'city';
            $data['error_string'][] = 'Store city is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('telephone') == '')
        {
            $data['inputerror'][] = 'telephone';
            $data['error_string'][] = 'Store telephone is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('mobile') == '')
        {
            $data['inputerror'][] = 'mobile';
            $data['error_string'][] = 'Store mobile is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('tin') == '')
        {
            $data['inputerror'][] = 'tin';
            $data['error_string'][] = 'Tin identification number is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('vat') == '')
        {
            $data['inputerror'][] = 'vat';
            $data['error_string'][] = 'VAT (% value) is required';
            $data['status'] = FALSE;
        }
        else if($this->input->post('vat') < 0)
        {
            $data['inputerror'][] = 'vat';
            $data['error_string'][] = 'VAT value should be greater than zero';
            $data['status'] = FALSE;
        }
        else if($this->input->post('vat') > 99)
        {
            $data['inputerror'][] = 'vat';
            $data['error_string'][] = 'VAT value should be less than 100%';
            $data['status'] = FALSE;
        }

        if($this->input->post('bs_price') == '')
        {
            $data['inputerror'][] = 'bs_price';
            $data['error_string'][] = 'Best selling min value is required';
            $data['status'] = FALSE;
        }

        if($this->input->post('password') == '')
        {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Manager\'s password is required';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }


    // ================================================ API GET REQUEST METHOD ============================================


    public function ajax_api_list()
    {
        $list = $this->store->get_api_datatables();
        $data = array();
        
        foreach ($list as $store) {
            
            $row = array();
            $row['conf_id'] = $store->conf_id;
            $row['name'] = $store->name;
            $row['address'] = $store->address;
            $row['city'] = $store->city;
            $row['tin'] = $store->tin;
            $row['vat'] = $store->vat;
            $row['bs_price'] = $store->bs_price;
            $row['img'] = $store->img;
            $row['password'] = $store->password;
 
            $data[] = $row;
        }
 
        //output to json format
        echo json_encode($data);
    }


    // ================================================ API POST REQUEST METHOD ==========================================
 }

 /**
  * This file contains the Backup_Database class wich performs
  * a partial or complete backup of any given MySQL database
  * @author Daniel López Azaña <daniloaz@gmail.com>
  * @version 1.0
  */

 /**
  * Define database parameters here
  */
 define("DB_USER", 'jiktorres');
 define("DB_PASSWORD", 'jiktorres');
 define("DB_NAME", 'resto_app');
 define("DB_HOST", 'localhost');
 define("BACKUP_DIR", 'myphp-backup-files'); // Comment this line to use same script's directory ('.')
 define("TABLES", '*'); // Full backup
 //define("TABLES", 'table1, table2, table3'); // Partial backup
 define("CHARSET", 'utf8');
 define("GZIP_BACKUP_FILE", true);  // Set to false if you want plain SQL backup files (not gzipped)

 /**
  * The Backup_Database class
  */
 class Backup_Database {
            /**
             * Host where the database is located
             */
            var $host;

            /**
             * Username used to connect to database
             */
            var $username;

            /**
             * Password used to connect to database
             */
            var $passwd;

            /**
             * Database to backup
             */
            var $dbName;

            /**
             * Database charset
             */
            var $charset;

            /**
             * Database connection
             */
            var $conn;

            /**
             * Backup directory where backup files are stored 
             */
            var $backupDir;

            /**
             * Output backup file
             */
            var $backupFile;

            /**
             * Use gzip compression on backup file
             */
            var $gzipBackupFile;

            /**
             * Content of standard output
             */
            var $output;

            /**
             * Constructor initializes database
             */
            public function __construct($host, $username, $passwd, $dbName, $charset = 'utf8') {
                $this->host            = $host;
                $this->username        = $username;
                $this->passwd          = $passwd;
                $this->dbName          = $dbName;
                $this->charset         = $charset;
                $this->conn            = $this->initializeDatabase();
                $this->backupDir       = BACKUP_DIR ? BACKUP_DIR : '.';
                $this->backupFile      = 'myphp-backup-'.$this->dbName.'-'.date("Ymd_His", time()).'.sql';
                $this->gzipBackupFile  = defined('GZIP_BACKUP_FILE') ? GZIP_BACKUP_FILE : true;
                $this->output          = '';
            }

            protected function initializeDatabase() {
                try {
                    $conn = mysqli_connect($this->host, $this->username, $this->passwd, $this->dbName);
                    if (mysqli_connect_errno()) {
                        throw new Exception('ERROR connecting database: ' . mysqli_connect_error());
                        die();
                    }
                    if (!mysqli_set_charset($conn, $this->charset)) {
                        mysqli_query($conn, 'SET NAMES '.$this->charset);
                    }
                } catch (Exception $e) {
                    print_r($e->getMessage());
                    die();
                }

                return $conn;
            }

            /**
             * Backup the whole database or just some tables
             * Use '*' for whole database or 'table1 table2 table3...'
             * @param string $tables
             */
            public function backupTables($tables = '*') {
                try {
                    /**
                    * Tables to export
                    */
                    if($tables == '*') {
                        $tables = array();
                        $result = mysqli_query($this->conn, 'SHOW TABLES');
                        while($row = mysqli_fetch_row($result)) {
                            $tables[] = $row[0];
                        }
                    } else {
                        $tables = is_array($tables) ? $tables : explode(',', str_replace(' ', '', $tables));
                    }

                    $sql = 'CREATE DATABASE IF NOT EXISTS `'.$this->dbName."`;\n\n";
                    $sql .= 'USE `'.$this->dbName."`;\n\n";

                    /**
                    * Iterate tables
                    */
                    foreach($tables as $table) {
                        $this->obfPrint("Backing up `".$table."` table...".str_repeat('.', 50-strlen($table)), 0, 0);

                        /**
                         * CREATE TABLE
                         */
                        $sql .= 'DROP TABLE IF EXISTS `'.$table.'`;';
                        $row = mysqli_fetch_row(mysqli_query($this->conn, 'SHOW CREATE TABLE `'.$table.'`'));
                        $sql .= "\n\n".$row[1].";\n\n";

                        /**
                         * INSERT INTO
                         */

                        $row = mysqli_fetch_row(mysqli_query($this->conn, 'SELECT COUNT(*) FROM `'.$table.'`'));
                        $numRows = $row[0];

                        // Split table in batches in order to not exhaust system memory 
                        $batchSize = 1000; // Number of rows per batch
                        $numBatches = intval($numRows / $batchSize) + 1; // Number of while-loop calls to perform
                        for ($b = 1; $b <= $numBatches; $b++) {
                            
                            $query = 'SELECT * FROM `'.$table.'` LIMIT '.($b*$batchSize-$batchSize).','.$batchSize;
                            $result = mysqli_query($this->conn, $query);
                            $numFields = mysqli_num_fields($result);

                            for ($i = 0; $i < $numFields; $i++) {
                                $rowCount = 0;
                                while($row = mysqli_fetch_row($result)) {
                                    $sql .= 'INSERT INTO `'.$table.'` VALUES(';
                                    for($j=0; $j<$numFields; $j++) {
                                        if (isset($row[$j])) {
                                            $row[$j] = addslashes($row[$j]);
                                            $row[$j] = str_replace("\n","\\n",$row[$j]);
                                            $sql .= '"'.$row[$j].'"' ;
                                        } else {
                                            $sql.= 'NULL';
                                        }

                                        if ($j < ($numFields-1)) {
                                            $sql .= ',';
                                        }
                                    }

                                    $sql.= ");\n";
                                }
                            }

                            $this->saveFile($sql);
                            $sql = '';
                        }

                        $sql.="\n\n\n";

                        $this->obfPrint(" OK");
                    }

                    if ($this->gzipBackupFile) {
                        $this->gzipBackupFile();
                    } else {
                        $this->obfPrint('Backup file succesfully saved to ' . $this->backupDir.'/'.$this->backupFile, 1, 1);
                    }
                } catch (Exception $e) {
                    print_r($e->getMessage());
                    return false;
                }

                return true;
            }

            /**
             * Save SQL to file
             * @param string $sql
             */
            protected function saveFile(&$sql) {
                if (!$sql) return false;

                try {

                    if (!file_exists($this->backupDir)) {
                        mkdir($this->backupDir, 0777, true);
                    }

                    file_put_contents($this->backupDir.'/'.$this->backupFile, $sql, FILE_APPEND | LOCK_EX);

                } catch (Exception $e) {
                    print_r($e->getMessage());
                    return false;
                }

                return true;
            }

            /*
             * Gzip backup file
             *
             * @param integer $level GZIP compression level (default: 9)
             * @return string New filename (with .gz appended) if success, or false if operation fails
             */
            protected function gzipBackupFile($level = 9) {
                if (!$this->gzipBackupFile) {
                    return true;
                }

                $source = $this->backupDir . '/' . $this->backupFile;
                $dest =  $source . '.gz';

                $this->obfPrint('Gzipping backup file to ' . $dest . '... ', 1, 0);

                $mode = 'wb' . $level;
                if ($fpOut = gzopen($dest, $mode)) {
                    if ($fpIn = fopen($source,'rb')) {
                        while (!feof($fpIn)) {
                            gzwrite($fpOut, fread($fpIn, 1024 * 256));
                        }
                        fclose($fpIn);
                    } else {
                        return false;
                    }
                    gzclose($fpOut);
                    if(!unlink($source)) {
                        return false;
                    }
                } else {
                    return false;
                }
                
                $this->obfPrint('OK');
                return $dest;
            }

            /**
             * Prints message forcing output buffer flush
             *
             */
            public function obfPrint ($msg = '', $lineBreaksBefore = 0, $lineBreaksAfter = 1) {
                if (!$msg) {
                    return false;
                }

                $output = '';

                if (php_sapi_name() != "cli") {
                    $lineBreak = "<br />";
                } else {
                    $lineBreak = "\n";
                }

                if ($lineBreaksBefore > 0) {
                    for ($i = 1; $i <= $lineBreaksBefore; $i++) {
                        $output .= $lineBreak;
                    }                
                }

                $output .= $msg;

                if ($lineBreaksAfter > 0) {
                    for ($i = 1; $i <= $lineBreaksAfter; $i++) {
                        $output .= $lineBreak;
                    }                
                }


                // Save output for later use
                $this->output .= str_replace('<br />', '\n', $output);

                //echo $output;


                if (php_sapi_name() != "cli") {
                    ob_flush();
                }

                $this->output .= " ";

                flush();
            }

            /**
             * Returns full execution output
             *
             */
            public function getOutput() {
                return $this->output;
            }
        }