<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/3/20
 * Time: 2:03 AM
 */

class plans
{
    public function get_plans($condi = "")
    {
        $plans = Database::select("plans", $condi);
        return $plans;
    }

    public function update_plan($det, $id)
    {
        if (Database::update("plans", $det, "WHERE id = $id")){
            return true;
        }
        return false;
    }

    public function insert_refer($det){
        if (Database::insert("refers", $det)){
            return true;
        }
        return false;
    }

    public function get_user_plans($user)
    {
        $user_refers = Database::select("refers", "WHERE judge_id = '$user'");
        $plans = array();
        foreach ($user_refers as $refer){
            $plan_id = $refer["plan_id"];
            $plan = $this->get_plans("WHERE id = $plan_id");
            $plan = $plan->fetch_assoc();
            $plan["rated"] = $refer["rated"];
            $plan["rate"] = $refer["rate"];
            array_push($plans, $plan);
        }
        return $plans;
    }

    public function add_rate($det){
        $plan_id = $det["plan_id"];
        $judge_id = $det["judge_id"];
        Database::delete("plan_rates", "WHERE plan_id = $plan_id && judge_id = $judge_id");
        if (Database::insert("plan_rates", $det)){
            Database::update("refers", array("rated"=>1, "rate"=>$det["rate_ave"]), "WHERE plan_id = $plan_id && judge_id = $judge_id");
            $check = Database::select("refers", "WHERE plan_id = $plan_id && rated = 0");
            if ($check->num_rows == 0){
                Database::update("plans", array("status"=>"rated"), "WHERE id = $plan_id");
            }
            return true;
        }
        return false;
    }

    public function check_judge_rate($judge, $plan)
    {
        $refer = Database::select("refers", "WHERE judge_id = $judge && plan_id = $plan");
        if ($refer && $refer->num_rows > 0){
            $refer = $refer->fetch_assoc();
            if ($refer["rated"] == 1){
                return $refer["rate"];
            }
        }
        return false;
    }

    public function calc_ave_rate($plan)
    {
        $refers = Database::select("refers", "WHERE plan_id = $plan");
        if ($refers->num_rows > 0){
            $ave = 0;
            foreach ($refers as $refer){
                $ave += $refer["rate"];
            }
            $ave /= $refers->num_rows;
            $ave = round($ave, 2);
            return $ave;
        }
        return false;
    }

    public function get_plan_rates($plan)
    {
        require_once "users.php";
        $users = new users();
        $rates = Database::select("plan_rates", "WHERE plan_id = $plan");
        $det = array();
        foreach ($rates as $rate){
            $judge_id = $rate["judge_id"];
            $judge = $users->get_judges("WHERE id = $judge_id");
            $judge = $judge->fetch_assoc();
            $this_rate["judge_name"] = $judge["judge_name"];
            $this_rate["analyz"] = $rate["analyz"];
            array_push($det, $this_rate);
        }
        return $det;
    }

    public function get_rate_by_judge($judge, $plan)
    {
        $rate = Database::select("plan_rates", "WHERE judge_id = $judge && plan_id = $plan");
        if ($rate->num_rows > 0){
            return $rate->fetch_assoc();
        }
        return false;
    }

    public function get_plan_judges($plan)
    {
        $judges = Database::select("refers", "WHERE plan_id = $plan");
        $ids = array();
        if ($judges && $judges->num_rows > 0){
            foreach ($judges as $judge){
                array_push($ids, $judge["judge_id"]);
            }
        }
        return $ids;
    }

    public function get_judge_rates($judge)
    {
        $rates = Database::select("plan_rates", "WHERE judge_id = $judge");
        return $rates;
    }
}