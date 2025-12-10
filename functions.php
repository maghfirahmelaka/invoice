<?php
// functions.php - helper functions
session_start();
require_once 'db.php';

function is_logged_in(){
    return isset($_SESSION['user_logged']) && $_SESSION['user_logged'] === true;
}

function require_login(){
    if(!is_logged_in()){
        header('Location: index.php');
        exit;
    }
}

function flash($msg){
    $_SESSION['flash'] = $msg;
}

function get_flash(){
    if(isset($_SESSION['flash'])){
        $m = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $m;
    }
    return '';
}

function generate_invoice_no($id=null){
    $prefix = 'MKM-INV-';
    if($id) return $prefix . str_pad($id,6,'0',STR_PAD_LEFT);
    // fallback with random
    return $prefix . date('Ymd') . '-' . rand(100,999);
}
?>