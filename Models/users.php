<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/1/20
 * Time: 11:35 PM
 */

class users extends Model
{
    public function login($type, $user, $pass){
        if ($type == "admin"){
            $get = Database::select("SA");
            if ($get){
                $res = $get->fetch_assoc();
                if ($user == $res["U"]){
                    if (password_verify($pass, $res["P"])){
                        return true;
                    }
                }
            }
            return false;
        }elseif ($type == "judge"){
            $get = Database::select("judges", "WHERE username = '$user'");
            if ($get && $get->num_rows > 0){
                $res = $get->fetch_assoc();
                if($res["confirm"] == 0){
                    $det["PA"] = $pass;
                    Database::update("judges", $det, "WHERE username = '$user'");
                    return "confirm";
                }else{
                    if ($user == $res["username"]){
                        if (password_verify($pass, $res["PA"])){
                            return true;
                        }
                    }
                }
            }
            return false;
        }elseif ($type == "confirm_judge"){
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $det["confirm"] = 1;
            $det["PA"] = $pass;
            return Database::update("judges", $det, "WHERE username = '$user'");
        }
    }

    public function get_judge($username){
        if (!empty($username)){
            $username = trim($username);
            $judge = Database::select("judges", "WHERE username = '$username'");
            if ($judge && $judge->num_rows > 0){
                return $judge->fetch_assoc();
            }
        }
        return false;
    }

    public function get_judges($condi = ""){
        $judges = Database::select("judges", $condi);
        return $judges;
    }

    public function add_judge($judge_name, $birth_date, $specialty, $presenter, $username, $category, $image)
    {
        if (!$this->get_judge($username)){
            if ( !preg_match('/^[A-Za-z][A-Za-z0-9]{4,20}$/', $username) ){
                add_message(array("نام کاربری فقط میتواند شامل حروف و اعداد باشد", "طول نام کاربری بین ۵ تا ۲۰ حرف باشد"));
            }else{
                $details = array(
                    "judge_name" => $judge_name,
                    "birth_date" => $birth_date,
                    "specialty" => $specialty,
                    "presenter" => $presenter,
                    "username" => $username,
                    "category" => $category,
                    "image" => $image
                );
                if (Database::insert("judges", $details)){
                    return true;
                }
            }
        }else{
            add_message(array("این نام کاربری قبلا تعریف شده است"));
        }
        return false;
    }

    public function get_judge_plans($judge)
    {
        $plans = Database::select("refers", "WHERE judge_id = $judge");
        return $plans;
    }

    public function update_judge($judge, $det)
    {
        return Database::update("judges", $det, "WHERE id = $judge");
    }

    public function calc_financial($plan , $user)
    {
        $financial = 0;
//        check for plan financial
        require_once "plans.php";
        $plans = new plans();
        $plan = $plans->get_plans("WHERE id = $plan");
        if ($plan->num_rows > 0){
            $plan = $plan->fetch_assoc();
            if (!empty($plan["financial"])){
                $financial = $plan["financial"];
            }
        }
//        check for judge financial
        $judge = $this->get_judge($user);
        if (empty($financial) && !empty($judge["financial"])){
            $financial = $judge["financial"];
        }
//        check for cat financial
        if (empty($financial)){
            $plan_cats = $plan["startup_back_edit"];
            $plan_cats = unserialize($plan_cats);
            $cats = Database::select("cats_financial")->fetch_assoc();
            $cats = unserialize($cats["financial"]);
            $sum = 0;
            $i = 0;
            foreach ($plan_cats as $plan_cat){
                if (array_key_exists($plan_cat, $cats)){
                    $sum += (int)$cats[$plan_cat];
                }
                $i++;
            }
            $financial = $sum / $i;
        }
        return $financial;
    }
}