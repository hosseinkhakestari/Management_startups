<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 4/13/20
 * Time: 6:02 AM
 */

class judgeController extends Controller
{
    function __construct()
    {
        require_once ROOT . "Controllers/publicController.php";
        $publicController = new publicController();
        if (!$publicController->login("judge")){
            redirect_to("/judge/login");
        }
    }

    public function plans()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Controllers/sessionController.php";
        $session = new sessionController();
        require_once ROOT . "Models/plans.php";
        $plansModel = new plans();
        $username = $session->check_session("Uname");
        $judge = $users->get_judge($username);
        $vars["plans"] = $plansModel->get_user_plans($judge["id"]);
        $vars["page_title"] = "طرح های من";
        $vars["active"] = "plans";
        $vars["judge_page"] = 1;
        $this->set($vars);
        $this->layout = "judge";
        $this->render("my_plans");
    }

    public function filter_plans()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Controllers/sessionController.php";
        $session = new sessionController();
        require_once ROOT . "Models/plans.php";
        $plansModel = new plans();
        $username = $session->check_session("Uname");
        $judge = $users->get_judge($username);
        if ($judge){
            $refers = $plansModel->get_user_plans($judge["id"]);
        }
        $plans_id = array();
        $rates = array();
        foreach ($refers as $refer){
            array_push($plans_id, $refer["id"]);
            $rates[$refer["id"]] = array("rate"=>$refer["rate"], "rated"=>$refer["rated"]);
        }
        $plans_id = implode(",", $plans_id);
        $plans_status = $this->secure_input($_POST['plans_status']);
        $condi = "WHERE id IN ($plans_id) ";
        $searched = $this->secure_input($_POST["searched"]);
        if (!empty($searched)){
            $condi .= " && idea_title LIKE '$searched%' ";
        }
        if (isset($_POST['back_filters']) && !empty($_POST['back_filters'])){
            $back_filters = $this->secure_input($_POST['back_filters']);
            $condi .= "&& startup_back IN ($back_filters) ";
        }
        if (isset($_POST['level_filters']) && !empty($_POST['level_filters'])){
            $level_filters = $this->secure_input($_POST['level_filters']);
            $condi .= "&& idea_level IN ($level_filters) ";
        }
        if (isset($_POST['fund_filter']) && !empty($_POST['fund_filter'])){
            $fund_filter = $this->secure_input($_POST['fund_filter']);
            if ($fund_filter == "100"){
                $condi .= "&& fund < 100000000 ";
            }elseif ($fund_filter == "100-400"){
                $condi .= "&& fund >= 100000000 && fund <= 400000000 ";
            }elseif ($fund_filter == "400-700"){
                $condi .= "&& fund >= 400000000 && fund <= 700000000 ";
            }elseif ($fund_filter == "700"){
                $condi .= "&& fund > 700000000 ";
            }
        }
        if (isset($_POST['cities_filter']) && !empty($_POST['cities_filter'])){
            $cities_filter = $this->secure_input($_POST['cities_filter']);
            $condi .= "&& owner_city IN ($cities_filter) ";
        }
        if (isset($_POST['order']) && $_POST['order'] !== null && !empty($_POST['order'])){
            $order = $this->secure_input($_POST["order"]);
            $condi .= "ORDER BY $order";
        }
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        $plans = $plans_controller->get_plans($condi);
        $plans_array = array();
        foreach ($plans as $plan){
            $id = $plan["id"];
            $plan_array["id"] = $id;
            $plan_array["owner_name"] = $plan["idea_title"];
            $plan_array["startup_back"] = $plan["startup_back"];
            $plan_array["date"] = convert_datetime($plan["time"]);
            $plan_array["idea_exp"] = $plan["idea_exp"];
            $plan_array["rate"] = $rates[$id]["rate"];
            if (isset($_POST["rated"]) && !empty($_POST["rated"])){
                if ($rates[$id]["rated"] !== $_POST["rated"]){
                    continue;
                }
            }
            array_push($plans_array, $plan_array);
        }
        echo json_encode($plans_array);
    }

    public function view($id)
    {
        require_once 'plansController.php';
        $plansController = new plansController();
        $id = $this->secure_input($id);
        $details = $plansController->get_plans("WHERE id = $id");
        if ((isset($_POST['cats']) || isset($_POST['judges'])) && isset($_POST["confirm_plan"])){
            if (!empty($_POST['cats'])){
                $det["startup_back_edit"] = serialize($this->secure_input($_POST['cats']));
            }else{
                $det["startup_back_edit"] = serialize(array());
            }
            if (!empty($_POST["judges"])){
                $det["judges"] = serialize($this->secure_input($_POST['judges']));
            }else{
                $det["judges"] = serialize(array());
            }
            if ($plansController->update_plan($det, $id)){
                foreach ($_POST['judges'] as $judge){
                    $plansController->insert_refer(array("judge_id"=>$judge,"plan_id"=>$id));
                }
                $plansController->update_plan(array("status"=>"sended"), $id);
                echo "OK";
            }
            return;
        }
        if (isset($_POST['reject_plan']) && isset($_POST['reason']) && !empty($_POST['reason'])){
            $reason = $this->secure_input($_POST['reason']);
            $det["status"] = "rejected";
            $det["reject_reason"] = $reason;
            if ($plansController->update_plan($det, $id)){
                echo "OK";
            }
            return;
        }
        if (!empty($details) && $details->num_rows > 0){
            $details = $details->fetch_assoc();
            if ($details['status'] == NULL || $details["status"] == "rejected"){
                require_once ROOT . "Models/users.php";
                $users = new users();
                $plan_cat = $details['startup_back'];
                $cat_judges = $users->get_judges("WHERE category = '$plan_cat'");
                if (!$cat_judges){
                    $cat_judges = array();
                }
                $details["cat_judges"] = $cat_judges;
                $other_judges = $users->get_judges("WHERE category != '$plan_cat'");
                if (!$other_judges){
                    $other_judges = array();
                }
                $details["other_judges"] = $other_judges;
            }
            $this->set($details);
            $vars['page_title'] = $details['idea_title'];
            $vars['active'] = "recent";
            $this->set($vars);
            $this->layout = "judge";
            $this->render("view_plan");
        }
    }

    public function rate($id)
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        $judge_id = $users->get_judge($_SESSION["Uname"]);
        $judge_id = $judge_id["id"];
        require_once ROOT . "Models/plans.php";
        $plansModel = new plans();
        $rate = $plansModel->get_rate_by_judge($judge_id, $id);
        if ($rate){
            $answers = unserialize($rate["answers"]);
            $i = 1;
            foreach ($answers as $answer){
                $vars["ans" . $i] = $answer["ans"];
                $vars["rate" . $i] = $answer["rate"];
                $i++;
            }
            $vars["analyz"] = $rate["analyz"];
        }else{
            $i = 1;
            foreach (judge_ques as $que){
                $vars["ans" . $i] = "";
                $vars["rate" . $i] = "";
                $i++;
            }
            $vars["analyz"] = "";
        }
        if (isset($_POST['rate_plan'])){
            $det["judge_id"] = $judge_id;
            $det["plan_id"] = $id;
            $empty = 0;
            $i = 1;
            $answers = array();
            $rate_ave = 0;
            foreach (judge_ques as $question){
                $ans = $this->secure_input($_POST["ans$i"]);
                if (isset($_POST["rate$i"])){
                    $rate = $this->secure_input($_POST["rate$i"]);
                }else{
                    $rate = "";
                }
                $vars["ans" . $i] = $ans;
                $vars["rate" . $i] = $rate;
                if (empty($ans) || empty($rate)){
                    $empty = 1;
                    add_message(array("همه ی موارد را وارد کنید"));
                }
                $question_det = array(
                    "ans" => $ans,
                    "rate" => $rate
                );
                $answers[$question] = $question_det;
                if (empty($rate)){
                    $rate = 0;
                }
                $rate_ave += $this->secure_input($rate);
                $i++;
            }
            $analyz = $this->secure_input($_POST["analyz"]);
            $vars["analyz"] = $analyz;
            if (empty($analyz)){
                $empty = 1;
            }
            if ($empty !== 1){
                $rate_ave /= ($i-1);
                $det["answers"] = serialize($answers);
                $det["analyz"] = $analyz;
                $det["rate_ave"] = $rate_ave;
                $det["financial"] = $users->calc_financial($id, $_SESSION["Uname"]);
                if ($plansModel->add_rate($det)){
                    redirect_to("/judge/plans");
                }
            }
        }
        $vars["page_title"] = "ارزیابی طرح";
        $vars["active"] = "plans";
        $this->set($vars);
        $this->layout = "judge";
        $this->render("rate_plan");
    }

}