<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$CI =& get_instance();
$CI->load->model('user_model');


if ( ! function_exists('cek_login')) {

    function cek_login() {
        global $CI;
        $cookie = get_cookie('aplikasi_pos2');
        if($CI->session->user_login) {
            $user_login = json_decode($CI->session->user_login);
            $is_admin = (boolean) $user_login->is_admin;
            if ($is_admin) {
                header("Location:".base_url('admin'));
            } else {
                header("Location:".base_url('user'));
            }
        } else {
            if ($cookie) {
                $user = $CI->user_model->get_by_cookie($cookie);
                $CI->user_model->set_by_cookie($user);
                if((boolean) $user->is_admin) {
                    header("Location:".base_url('admin'));
                } else {
                    header("Location:".base_url('user'));
                }
            }
        }
        
    }

}

if ( ! function_exists('cek_login_admin')) {

    function cek_login_admin() {

        global $CI;

        $cookie = get_cookie('aplikasi_pos2');
        if($CI->session->user_login) {
            $user_login = json_decode($CI->session->user_login);
            $is_admin = (boolean) $user_login->is_admin;
            if ($is_admin) {
                header("Location:".base_url('admin'));
            }
        } else {
            if ($cookie) {
                $user = $CI->user_model->get_by_cookie($cookie);
                $CI->user_model->set_by_cookie($user);
                if((boolean) $user->is_admin) {
                    header("Location:".base_url('admin'));
                }
            }
        }
        
    }

}

if ( ! function_exists('cek_login_user')) {

    function cek_login_user() {

        global $CI;

        $cookie = get_cookie('aplikasi_pos2');
        if($CI->session->user_login) {
            $user_login = json_decode($CI->session->user_login);
            $is_admin = (boolean) $user_login->is_admin;
            if (!$is_admin) {
                header("Location:".base_url('user'));
            }
        } else {
            if ($cookie) {
                $user = $CI->user_model->get_by_cookie($cookie);
                $CI->user_model->set_by_cookie($user);
                $is_admin = (boolean) $user->is_admin;
                if(!$is_admin) {
                    header("Location:".base_url('user'));
                }
            }
        }
        
    }

}

if ( ! function_exists('cek_bukan_admin')) {

    function cek_bukan_admin () {
        
        global $CI;

        $cookie = get_cookie('aplikasi_pos2');
        if($CI->session->user_login) {
            $user_login = json_decode($CI->session->user_login);
            $is_admin = (boolean) $user_login->is_admin;
            if (!$is_admin) {
                header("Location:".base_url('user'));
            }
        } else {
            if ($cookie) {
                $user = $CI->user_model->get_by_cookie($cookie);
                $CI->user_model->set_by_cookie($user);
                $is_admin = (boolean) $user->is_admin;
                if(!$is_admin) {
                    header("Location:".base_url('user'));
                }
            } else {
                header("Location:".base_url('user/login'));
            }
        }
        
    }

}

if ( ! function_exists('cek_tidak_login') ) {

    function cek_tidak_login() {

        global $CI;
        
        if( ! $CI->session->user_login ) {

            header("Location:".base_url('user/login'));

        }

    }

} 