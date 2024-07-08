<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/19/20
 * Time: 6:33 AM
 */
require_once ROOT . "include/vendor/autoload.php";
use Hekmatinasser\Verta\Verta;
function convert_datetime($datetime){
    $date = explode(" ", $datetime)[0];
    $date = explode("-", $date);
    $date = Verta::getJalali($date[0],$date[1],$date[2]);
    return $date[0] . "/" . $date[1] . "/" . $date[2];
}
function convert_jalali($date){
    $date = explode("/", $date);
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $nums = array(
        "0"=>"۰",
        "1"=>"۱",
        "2"=>"۲",
        "3"=>"۳",
        "4"=>"۴",
        "5"=>"۵",
        "6"=>"۶",
        "7"=>"۷",
        "8"=>"۸",
        "9"=>"۹"
    );
    foreach ($nums as $en => $fa){
        $year = str_replace($fa, $en, $year);
        $month = str_replace($fa, $en, $month);
        $day = str_replace($fa, $en, $day);
    }
    $date = Verta::getGregorian($year,$month,$day);
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    if (strlen($month) == 1){
        $month = "0" . $month;
    }
    if (strlen($day) == 1){
        $day = "0" . $day;
    }
    return $year . "-" . $month . "-" . $day;
}

function add_message($message = array()){
    if (!isset($_SESSION)){
        session_start();
    }
    $_SESSION['message'] = $message;
    $_SESSION['show_message'] = 1;
}

function add_problem_message(){
    add_message(array("مشکلی پیش آمده لطفا دوباره امتحان کنید."));
}

function get_messages(){
    if (isset($_SESSION['message']) && isset($_SESSION['show_message']) && $_SESSION['show_message'] == 1){
        $messages = $_SESSION['message'];
        return $messages;
    }
    return array();
}

function show_messages(){
    if (isset($_SESSION['message']) && isset($_SESSION['show_message']) && $_SESSION['show_message'] == 1){
        $messages = $_SESSION['message'];
        foreach ($messages as $message){
            echo "<p class='text-danger'>{$message}</p>";
        }
        unset($_SESSION['show_message']);
    }
}

function redirect_to($page){
    header("location: $page");
}
//add "," to money amount
function convert_amount($amount){
    $new = "";
    $amount = strrev(trim($amount));
    for ($i = 0; $i < strlen($amount); $i++){
        if ($i%3 == 0 && $i !== 0){
            $new .= "," . $amount[$i];
        }else{
            $new .= $amount[$i];
        }
    }
    return strrev($new);
}