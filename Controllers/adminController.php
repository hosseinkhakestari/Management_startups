<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/31/20
 * Time: 12:54 AM
 */
class adminController extends Controller
{
    function __construct()
    {
        require_once ROOT . "Controllers/publicController.php";
        $publicController = new publicController();
        if (!$publicController->login("admin")){
            redirect_to("/admin/login");
        }
    }

    public function recent()
    {
        $vars['page_title'] = "طرح های جدید";
        $vars['active'] = "recent";
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        $vars['plans'] = $plans_controller->get_plans("WHERE status IS NULL");
        $this->set($vars);
        $this->layout = "admin";
        $this->render("recent");
    }

    public function filter_plans()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        $plans_status = $this->secure_input($_POST['plans_status']);
        if (empty($plans_status)){
            $condi = "WHERE status IS NULL ";
        }elseif ($plans_status == "financial"){
            $condi = "WHERE id IS NOT NULL ";
        }else{
            $condi = "WHERE status = '$plans_status' ";
        }
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
            $plan_array["id"] = $plan["id"];
            $plan_array["owner_name"] = $plan["idea_title"];
            $plan_array["startup_back"] = $plan["startup_back"];
            $plan_array["date"] = convert_datetime($plan["time"]);
            $plan_array["idea_exp"] = $plan["idea_exp"];
            $plan_array["financial"] = $plan["financial"];
            if ($plan["status"] == "sended"){
                $judges = unserialize($plan["judges"]);
                $new = array();
                foreach ($judges as $judge){
                    $judge_det = $users->get_judges("WHERE id = $judge");
                    $judge_Arr["name"] = $judge_det->fetch_assoc()["judge_name"];
                    $judge_Arr["rated"] = $plans_controller->check_judge_rate($plan["id"], $judge);
                    array_push($new, $judge_Arr);
                }
                $plan_array["judges"] = $new;
            }elseif ($plan["status"] == "rated"){
                $plan_array["rate"] = $plans_controller->calc_ave_rate($plan["id"]);
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
            $det["final_status"] = "rejected";
            $det["expl"] = $reason;
            if ($plansController->update_plan($det, $id)){
                echo "OK";
            }
            return;
        }
        if (isset($_POST["final_rate"]) && isset($_POST["final_status"]) && isset($_POST["expl"])){
            $final_status = $this->secure_input($_POST["final_status"]);
            $expl = $this->secure_input($_POST["expl"]);
            $det["final_status"] = $final_status;
            $det["expl"] = $expl;
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
            }elseif ($details["status"] == "rated"){
                $details["rate"] = $plansController->calc_ave_rate($id);
                $details["plan_rates"] = $plansController->get_plan_rates($id);
            }
            $vars['active'] = "recent";
            if ($details["status"] == "rejected"){
                $vars["active"] = "rejected";
            }elseif ($details["status"] == "sended"){
                $vars["active"] = "sended";
            }elseif ($details["status"] == "rated"){
                $vars["active"] = "rated";
            }
            $this->set($details);
            $vars['page_title'] = $details['idea_title'];
            $this->set($vars);
            $this->layout = "admin";
            $this->render("view_plan");
        }
    }

    public function add_judge()
    {
        $vars["active"] = "add-judge";
        $vars["page_title"] = "معرفی ارزیاب";
        $vars["image"] = "/Views/images/member-default.png";
        if (isset($_POST['save_judge'])){
            $vars["judge_name"] = $_POST["judge_name"];
            $vars["birth_date"] = $_POST["birth_date"];
            $vars["specialty"] = $_POST["specialty"];
            $vars["presenter"] = $_POST["presenter"];
            $vars["username"] = $_POST["username"];
            $vars["category"] = $_POST["category"];
            if (empty($_POST["judge_image"][0])){
                $image = "";
            }else{
                require_once "filesController.php";
                $filesController = new filesController();
                $image = $filesController->save_member_image($_POST['judge_image']);
                $image = $image[0];
                $vars["added_image"] = 1;
                $vars["image"] = $_POST["judge_image"][0];
            }
            require_once ROOT . "Models/users.php";
            $users = new users();
            $judge_name = $this->secure_input($_POST['judge_name']);
            $birth_date = $this->secure_input($_POST['birth_date']);
            $specialty = $this->secure_input($_POST['specialty']);
            $presenter = $this->secure_input($_POST['presenter']);
            $username = $this->secure_input($_POST['username']);
            $category = $this->secure_input($_POST['category']);
            if ($users->add_judge($judge_name, $birth_date, $specialty, $presenter, $username, $category, $image)){
                add_message(array("ارزیاب با موفقیت افزوده شد"));
                header("location: /admin/add_judge");
            }
        }else{
            $vars["judge_name"] = "";
            $vars["birth_date"] = "";
            $vars["specialty"] = "";
            $vars["presenter"] = "";
            $vars["username"] = "";
            $vars["category"] = "";
        }
        $this->set($vars);
        $this->layout = "admin";
        $this->render("add_judge");
    }

    public function sended(){
        $vars['page_title'] = "طرح های ارسال شده";
        $vars['active'] = "sended";
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        $plans = $plans_controller->get_plans("WHERE status = 'sended'");
        require_once ROOT . "Models/users.php";
        $users = new users();
        $new_plans = array();
        foreach ($plans as $plan){
            $judges = unserialize($plan["judges"]);
            $new = array();
            foreach ($judges as $judge){
                $judge_det = $users->get_judges("WHERE id = $judge");
                $judge_Arr["name"] = $judge_det->fetch_assoc()["judge_name"];
                $judge_Arr["rated"] = $plans_controller->check_judge_rate($plan["id"], $judge);
                array_push($new, $judge_Arr);
            }
            $plan["judges"] = $new;
            array_push($new_plans, $plan);
        }
        $vars['plans'] = $new_plans;
        $all_judges = $users->get_judges();
        $vars["all_judges"] = $all_judges;
        $vars["sended_page"] = 1;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("recent");
    }

    public function rejected(){
        $vars['page_title'] = "طرح های رد شده";
        $vars['active'] = "rejected";
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        $plans = $plans_controller->get_plans("WHERE status = 'rejected'");
        $vars['plans'] = $plans;
        $vars["rejected_page"] = 1;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("recent");
    }

    public function rated(){
        $vars['page_title'] = "طرح های ارزیابی شده";
        $vars['active'] = "rated";
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        $plans = $plans_controller->get_plans("WHERE status = 'rated'");
        $new = array();
        foreach ($plans as $plan){
            $plan["rate"] = $plans_controller->calc_ave_rate($plan["id"]);
            array_push($new, $plan);
        }
        $vars['plans'] = $new;
        $vars["rated_page"] = 1;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("recent");
    }

    public function get_plan_judges($plan)
    {
        require_once "plansController.php";
        $plansController = new plansController();
        $plan_det = $plansController->get_plans("WHERE id = $plan");
        if ($plan_det && $plan_det->num_rows>0){
            $plan_det = $plan_det->fetch_assoc();
            $judges = $plan_det["judges"];
            $judges = unserialize($judges);
            echo json_encode($judges);
        }
    }

    public function edit_plan_judges($plan)
    {
        require_once "plansController.php";
        $plansController = new plansController();
        $ids = $this->secure_input($_POST['ids']);
        $plan_judges = $plansController->get_plan_judges($plan);
        $det["judges"] = serialize($ids);
        if ($plansController->update_plan($det, $plan)){
            foreach ($plan_judges as $judge){
                if (!in_array($judge, $ids)){
                    Database::delete("refers", "WHERE plan_id = $plan && judge_id = $judge");
                    Database::delete("plan_rates", "WHERE plan_id = $plan && judge_id = $judge");
                }
            }
            foreach ($ids as $id){
                if (!in_array($id, $plan_judges)){
                    $plansController->insert_refer(array("judge_id"=>$id, "plan_id"=>$plan));
                }
            }
            $check = Database::select("refers", "WHERE plan_id = $plan && rated = 0");
            if ($check->num_rows == 0){
                Database::update("plans", array("status"=>"rated"), "WHERE id = $plan");
            }
            echo "OK";
        }
    }

    public function plans_financial()
    {
        require_once ROOT . "Controllers/plansController.php";
        $plans_controller = new plansController();
        if (isset($_POST["submit_plans_financial"])){
            foreach ($_POST as $name => $value){
                if (strpos($name, "plan") == 0){
                    if (empty($value)){
                        $value = 0;
                    }
                    $id = str_replace("plan", "", $name);
                    $plans_controller->update_plan(array("financial"=>str_replace(",", "", $value)), $id);
                }
            }
        }
        $vars["page_title"] = "عملیات مالی - طرح ها";
        $vars["active"] = "financial";
        $vars["plans"] =  $plans_controller->get_plans();
        $this->set($vars);
        $this->layout = "admin";
        $this->render("financial");
    }

    public function judges_financial()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        if (isset($_POST["submit_judges_financial"])){
            foreach ($_POST as $name => $value){
                if (strpos($name, "judge") == 0){
                    if (empty($value)){
                        $value = 0;
                    }
                    $id = str_replace("judge", "", $name);
                    $users->update_judge($id, array("financial" => str_replace(",", "", $value)));
                }
            }
        }
        $judges = $users->get_judges();
        $new_judges = array();
        foreach ($judges as $judge){
            $this_judge = array(
                "id" => $judge["id"],
                "judge_name" => $judge["judge_name"],
                "financial" => $judge["financial"],
                "plans_count" => $users->get_judge_plans($judge["id"])->num_rows
            );
            array_push($new_judges, $this_judge);
        }
        $vars["judges"] = $new_judges;
        $vars["judges_financial_page"] = 1;
        $vars["page_title"] = "عملیات مالی - ارزیاب ها";
        $this->set($vars);
        $this->layout = "admin";
        $this->render("judges_financial");
    }

    public function filter_judges()
    {
        if (isset($_POST["filter_judges"])){
            require_once ROOT . "Models/users.php";
            $users = new users();
            $condi = "";
            if (isset($_POST["back_filters"]) && !empty($_POST["back_filters"])){
                $filter = $_POST["back_filters"];
                $condi = "WHERE category in ($filter) ";
            }
            $searched = $this->secure_input($_POST["searched"]);
            if (!empty($searched)){
                if (!empty($condi)){
                    $condi .= " && idea_title LIKE '$searched%' ";
                }else{
                    $condi .= " WHERE judge_name LIKE '$searched%' ";
                }
            }
            if (isset($_POST["order"]) && !empty($_POST["order"])){
                $order = $_POST["order"];
                $condi .= "ORDER BY $order";
            }
            $judges = $users->get_judges($condi);
            $new_arr = array();
            foreach ($judges as $judge){
                $judge["plans_count"] = $users->get_judge_plans($judge["id"])->num_rows;
                array_push($new_arr, $judge);
            }
            echo json_encode($new_arr);
        }
    }

    public function cats_financial()
    {
        $this->layout = "admin";
        $cats = array();
        $financials = Database::select("cats_financial");
        $financials = $financials->fetch_assoc();
        $financials = unserialize($financials["financial"]);
        $new = array();
        foreach (startup_backs as $cat){
            if (!array_key_exists($cat, $financials)){
                $new[$cat] = 1000;
            }else{
                $new[$cat] = $financials[$cat];
            }
        }
        if (isset($_POST["submit_cats_financial"])){
            foreach ($_POST as $name => $value) {
                if (strpos($name, "cat") == 0){
                    $name = str_replace("cat", "", $name);
                    $new[$name] = str_replace(",", "", $value);
                }
            }
        }
        Database::update("cats_financial", array("financial" => serialize($new)));
        $vars["cats"] = $new;
        $vars["page_title"] = "عملیات مالی - دسته ها";
        $this->set($vars);
        $this->render("cats_financial");
    }

    public function plans_report()
    {
        require_once ROOT . "Controllers/plansController.php";
        require_once ROOT . "Models/users.php";
        $users = new users();
        $plans_controller = new plansController();
        $plans = $plans_controller->get_plans();
        $judges = $users->get_judges();
        $judge_array = array();
        foreach ($judges as $judge){
            $judge_array[$judge["id"]] = $judge["judge_name"];
        }
        $new_plans = array();
        foreach ($plans as $plan) {
            $rate = $plans_controller->calc_ave_rate($plan["id"]);
            if (!$rate){
                $rate = "";
            }
            $plan["rate"] = $rate;
            array_push($new_plans, $plan);
        }
        $vars["judges"] = $judge_array;
        $vars["plans"] = $new_plans;
        $vars["useselect2"] = 1;
        $vars["page_title"] = "گزارش از طرح ها";
        $this->set($vars);
        $this->layout = "admin";
        $this->render("plans_report");
    }

    public function plans_report_ajax()
    {
        $condi = "";
        $date_from = $_POST["date_from"];
        if (!empty($date_from)){
            $date_from = convert_jalali($date_from);
            $condi = "WHERE time >= '$date_from' ";
        }
        $date_to = $_POST["date_to"];
        if (!empty($date_to)){
            $date_to = convert_jalali($date_to);
            if (empty($condi)){
                $condi = "WHERE time <= '$date_to' ";
            }else{
                $condi .= "&& time <= '$date_to' ";
            }
        }
        if (isset($_POST["plans_name"])){
            $plans_name = $_POST["plans_name"];
        }
        if (isset($plans_name)){
            $plans_name = array_map(function ($item){return trim($item);}, $plans_name);
            $plans_name = implode("','", $plans_name);
            if (empty($condi)){
                $condi  = "WHERE idea_title IN ('$plans_name') ";
            }else{
                $condi  .= "&& idea_title IN ('$plans_name') ";
            }
        }
        $rate_from = $_POST["rate_from"];
        $rate_to = $_POST["rate_to"];
        $status = $_POST["status"];
        if (!empty($status)){
            if ($status == "rated"){
                if (empty($condi)){
                    $condi .= "WHERE status = 'rated' ";
                }else{
                    $condi .= "&& status = 'rated' ";
                }
            }else{
                if (empty($condi)){
                    $condi .= "WHERE (status != 'rated' || status IS NULL) ";
                }else{
                    $condi .= "&& (status != 'rated' || status IS NULL) ";
                }
            }
        }
        $cats = $_POST["cats"];
        if (!empty($cats)){
            if (empty($condi)){
                $condi .= "WHERE startup_back IN ('$cats') ";
            }else{
                $condi .= "&& startup_back IN ('$cats') ";
            }
        }
        $cities = $_POST["cities"];
        if (!empty($cities)){
            if (empty($condi)){
                $condi .= "WHERE owner_city IN ('$cities') ";
            }else{
                $condi .= "&& owner_city IN ('$cities') ";
            }
        }
        $fund = $_POST["fund"];
        if (!empty($fund)){
            if (empty($condi)){
                $condi .= "WHERE fund " . $fund . " ";
            }else{
                $condi .= "&& fund " . $fund . " ";
            }
        }
        $level = $_POST["level"];
        if (!empty($level)){
            if (empty($condi)){
                $condi .= "WHERE idea_level IN ('$level')";
            }else{
                $condi .= "&& idea_level IN ('$level')";
            }
        }
        require_once "plansController.php";
        $plansController = new plansController();
        $plans = $plansController->get_plans($condi);
        $new = array();
        require_once ROOT . "Models/users.php";
        $users = new users();
        $judges = $users->get_judges();
        $judge_array = array();
        foreach ($judges as $judge){
            $judge_array[$judge["id"]] = $judge["judge_name"];
        }
        foreach ($plans as $plan){
            if ($plan["judges"] !== null){
                $plan_judges = unserialize($plan["judges"]);
                $names = array();
                foreach ($plan_judges as $judge){
                    array_push($names, $judge_array[$judge]);
                }
                $plan["judges"] = implode(" , ", $names);
            }else{
                $plan["judges"] = "";
            }
            if (!empty($plan["startup_back_edit"])){
                $plan["backs"] = implode(" , ", unserialize($plan["startup_back_edit"]));
            }else{
                $plan["backs"] = $plan["startup_back"];
            }
            $plan["time"] = convert_datetime($plan["time"]);
            $status = $plan["status"];
            $final_status = $plan["final_status"];
            if ($status === null){
                $plan["status"] = "نا مشخص";
            }elseif ($status == "sended"){
                $plan["status"] = "در انتظار ارزیابی";
            }elseif ($status == "rejected"){
                $plan["status"] = "رد شده";
            }elseif ($status == "rated" && $final_status == "passed"){
                $plan["status"] = "ارزیابی شده - قبول";
            }elseif ($status == "rated" && $final_status == "rejected"){
                $plan["status"] = "ارزیابی شده - رد";
            }
            $rate = $plansController->calc_ave_rate($plan["id"]);
            if (!$rate){
                $rate = "";
            }
            $plan["rate"] = $rate;
            $add = 1;
            if (!empty($rate_from)){
                if (empty($rate) || $rate < $rate_from){
                    $add = 0;
                }
            }
            if (!empty($rate_to)){
                if (empty($rate) || $rate > $rate_to){
                    $add = 0;
                }
            }
            if ($add == 1){
                array_push($new , $plan);
            }
        }
        echo json_encode($new);
    }

    public function judges_report()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        $judges = $users->get_judges();
        $judges_arr = array();
        foreach ($judges as $judge){
            $user_plans = $plans->get_user_plans($judge["id"]);
            $rated = 0;
            foreach ($user_plans as $plan){
                if ($plan["rated"] == 1){
                    $rated++;
                }
            }
            $judge["rated_plans"] = $rated;
            $judge["plans_count"] = count($user_plans);
            if (!empty($judge["birth_date"])){
                $birth_date = convert_jalali($judge["birth_date"]);
                $birth_year = explode("-", $birth_date)[0];
                $judge["age"] = date("Y") - $birth_year;
            }else{
                $judge["age"] = "";
            }
            array_push($judges_arr, $judge);
        }
        $vars["judges"] = $judges_arr;
        $vars["page_title"] = "گزارش از ارزیاب ها";
        $vars["useselect2"] = 1;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("judges_report");
    }

    public function judges_report_ajax(){
        if (isset($_POST["judges_name"])){
            $judges_name = $_POST["judges_name"];
        }
        $financial_from = $_POST["financial_from"];
        $financial_to = $_POST["financial_to"];
        $date_from = $_POST["date_from"];
        $date_to = $_POST["date_to"];
        $age_from = $_POST["age_from"];
        $age_to = $_POST["age_to"];
        $cats = $_POST["cats"];
        $condi = "";
        if (!empty($financial_from)){
            $financial_from = str_replace(",", "", $financial_from);
            if (empty($condi)){
                $condi = "WHERE financial >= '$financial_from' ";
            }
        }
        if (isset($judges_name)){
            $judges_name = array_map(function ($item){return trim($item);}, $judges_name);
            $judges_name = implode("','", $judges_name);
            if (empty($condi)){
                $condi  = "WHERE judge_name IN ('$judges_name') ";
            }else{
                $condi  .= "&& judge_name IN ('$judges_name') ";
            }
        }
        if (!empty($financial_to)){
            $financial_to = str_replace(",", "", $financial_to);
            if (empty($condi)){
                $condi = "WHERE financial <= $financial_to ";
            }else{
                $condi .= "&& financial <= $financial_to ";
            }
        }
        if (!empty($date_from)){
            $date_from = convert_jalali($date_from);
            if (empty($condi)){
                $condi = "WHERE time >= '$date_from' ";
            }else{
                $condi .= "&& time >= '$date_from' ";
            }
        }
        if (!empty($date_to)){
            $date_to = convert_jalali($date_to);
            if (empty($condi)){
                $condi = "WHERE time <= '$date_to' ";
            }else{
                $condi .= "WHERE time <= '$date_to' ";
            }
        }
        if (!empty($cats)){
            if (empty($condi)){
                $condi = "WHERE category IN ('$cats') ";
            }else{
                $condi .= "&& category IN ('$cats') ";
            }
        }
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        $judges = $users->get_judges($condi);
        $judges_arr = array();
        foreach ($judges as $judge){
            if (!empty($judge["birth_date"])){
                $birth_date = convert_jalali($judge["birth_date"]);
                $birth_year = explode("-", $birth_date)[0];
                $judge["age"] = date("Y") - $birth_year;
            }else{
                $judge["age"] = "";
            }
            $judge["time"] = convert_datetime($judge["time"]);
            $user_plans = $plans->get_user_plans($judge["id"]);
            $rated = 0;
            foreach ($user_plans as $plan){
                if ($plan["rated"] == 1){
                    $rated++;
                }
            }
            $judge["rated_plans"] = $rated;
            $judge["plans_count"] = count($user_plans);
            $add = 1;
            if (!empty($age_from)){
                if ($judge["age"] < $age_from){
                    $add = 0;
                }
            }
            if (!empty($age_to)){
                if ($judge["age"] > $age_to){
                    $add = 0;
                }
            }
            if ($add == 1){
                array_push($judges_arr, $judge);
            }
        }
        echo json_encode($judges_arr);
    }

    public function financial_report()
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        $judges = $users->get_judges();
        $judges_arr = array();
        foreach ($judges as $judge){
            $user_plans = $plans->get_user_plans($judge["id"]);
            $rated = 0;
            foreach ($user_plans as $plan){
                if ($plan["rated"] == 1){
                    $rated++;
                }
            }
            $judge["rated_plans"] = $rated;
            $judge["plans_count"] = count($user_plans);
            array_push($judges_arr, $judge);
        }
        $vars["judges"] = $judges_arr;
        $vars["page_title"] = "گزارش مالی";
        $vars["useselect2"] = 1;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("financial_report");
    }

    public function financial_report_ajax()
    {
        if (isset($_POST["judges_name"])){
            $judges_name = $_POST["judges_name"];
        }
        $financial_from = str_replace(",", "", $_POST["financial_from"]);
        $financial_to = str_replace(",", "", $_POST["financial_to"]);
        $cats_from = str_replace(",", "", $_POST["cats_from"]);
        $cats_to = str_replace(",", "", $_POST["cats_to"]);
        $cats = $_POST["cats"];
        $condi = "";
        if (!empty($financial_from)){
            $financial_from = str_replace(",", "", $financial_from);
            if (empty($condi)){
                $condi = "WHERE financial >= '$financial_from' ";
            }
        }
        if (!empty($financial_to)){
            $financial_to = str_replace(",", "", $financial_to);
            if (empty($condi)){
                $condi = "WHERE financial <= $financial_to ";
            }else{
                $condi .= "&& financial <= $financial_to ";
            }
        }
        if (isset($judges_name)){
            $judges_name = array_map(function ($item){return trim($item);}, $judges_name);
            $judges_name = implode("','", $judges_name);
            if (empty($condi)){
                $condi  = "WHERE judge_name IN ('$judges_name') ";
            }else{
                $condi  .= "&& judge_name IN ('$judges_name') ";
            }
        }
        if (!empty($cats)){
            if (empty($condi)){
                $condi = "WHERE category IN ('$cats') ";
            }else{
                $condi .= "&& category IN ('$cats') ";
            }
        }
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        $judges = $users->get_judges($condi);
        $judges_arr = array();
        foreach ($judges as $judge){
            $user_plans = $plans->get_user_plans($judge["id"]);
            $rated = 0;
            foreach ($user_plans as $plan){
                if ($plan["rated"] == 1){
                    $rated++;
                }
            }
            $judge["rated_plans"] = $rated;
            $judge["plans_count"] = count($user_plans);
            $add = 1;
            $cats_financial = Database::select("cats_financial")->fetch_assoc();
            $cats_financial = unserialize($cats_financial["financial"]);
            $judge_cat = $judge["category"];
            $cat_financial = $cats_financial[$judge_cat];
            if (!empty($cats_from)){
                if ($cat_financial < $cats_from){
                    $add = 0;
                }
            }
            if (!empty($cats_to)){
                if ($cat_financial > $cats_to){
                    $add = 0;
                }
            }
            if ($add == 1){
                array_push($judges_arr, $judge);
            }
        }
        echo json_encode($judges_arr);
    }

    public function report_judge($id)
    {
        require_once ROOT . "Models/users.php";
        $users = new users();
        require_once ROOT . "Models/plans.php";
        $plans = new plans();
        $judge = $users->get_judges("WHERE id = $id");
        $judge = $judge->fetch_assoc();
        $vars["judge"] = $judge;
        $rated_plans = $plans->get_judge_rates($id);
        $rated_arr = array();
        foreach ($rated_plans as $plan){
            $plan_det = $plans->get_plans("WHERE id = " . $plan["plan_id"])->fetch_assoc();
            $plan_arr = array(
                "plan_name" => $plan_det["idea_title"],
                "rate" => $plan["rate_ave"],
                "financial" => $plan["financial"],
                "date" => convert_datetime($plan["time"]),
                "time" => explode(" ", $plan["time"])[1],
                "analyz" => $plan["analyz"],
                "answers" => unserialize($plan["answers"])
            );
            array_push($rated_arr, $plan_arr);
        }
        $vars["plans"] = $rated_arr;
        $this->set($vars);
        $this->layout = "admin";
        $this->render("report_judge");
    }

    public function reset_judge_pass($judge)
    {
        if (Database::update("judges", array("confirm" => 0), "WHERE id = $judge")){
            echo "OK";
        }
    }
}