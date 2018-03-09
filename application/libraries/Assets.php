<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assets
{
    public function get_assets () {
        $assets = "";
        $assets .= "<link rel='stylesheet' href='".base_url('../assets/css/paginator.css')."'>";
        $assets .= "<link rel='stylesheet' href='".base_url('../assets/css/bootstrap.min.css')."'>";
        $assets .= "<script src='".base_url('../assets/js/vue.min.js')."'></script>";
        $assets .= "<script src='".base_url('../assets/js/jquery-3.3.1.min.js')."'></script>";
        $assets .= "<script src='".base_url('../assets/js/pagination.js')."'></script>";
        return $assets;
    }

}

/* End of file Assets.php */
