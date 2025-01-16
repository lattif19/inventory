<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    function Helper_log($tipe = "", $str = ""){
        $CI =& get_instance();
     
        if (strtolower($tipe) == "login"){
            $log_tipe   = 0;
        }
        elseif(strtolower($tipe) == "logout")
        {
            $log_tipe   = 1;
        }
        elseif(strtolower($tipe) == "add"){
            $log_tipe   = 2;
        }
        elseif(strtolower($tipe) == "edit"){
            $log_tipe  = 3;
        }
        else{
            $log_tipe  = 4;
        }
     
        // paramter
        // $param['log_user']      = $CI->session->userdata('username');
        $param['user_action']   = $log_tipe;
        $param['modul']         = $str;
        $param['level']         = $CI->session->userdata('level');
        $param['longtime']      = date("Y-m-d H:i:s");
     
        //load model log
        $CI->load->model('ModelLog');
     
        //save to database
        $CI->ModelLog->save_log($param);
     }


/* End of file log.php */
/* Location: .//C/Users/asus/AppData/Local/Temp/fz3temp-2/log.php */