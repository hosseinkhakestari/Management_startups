<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/3/20
 * Time: 2:03 AM
 */

class plansController extends Controller
{
    public function get_plans($condi = ""){
        require_once ROOT . "Models/plans.php";
        $model = new plans();
        $plans = $model->get_plans($condi);
        if ($plans){
            return $plans;
        }
        return array();
    }

    public function update_plan($det, $id){
        require_once ROOT . "Models/plans.php";
        $model = new plans();
        if ($model->update_plan($det, $id)){
            return true;
        }
        return false;
    }

    public function insert_refer($det)
    {
        require_once ROOT . "Models/plans.php";
        $model = new plans();
        if ($model->insert_refer($det)){
            return true;
        }
        return false;
    }

    public function check_judge_rate($plan, $judge)
    {
        require_once ROOT . "Models/plans.php";
        $plansModel = new plans();
        return $plansModel->check_judge_rate($judge, $plan);
    }

    public function calc_ave_rate($plan)
    {
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        return $plans->calc_ave_rate($plan);
    }

    public function get_plan_rates($plan)
    {
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        return $plans->get_plan_rates($plan);
    }

    public function get_plan_judges($plan)
    {
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        return $plans->get_plan_judges($plan);
    }
}