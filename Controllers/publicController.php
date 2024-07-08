<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/13/20
 * Time: 4:37 AM
 */

class publicController extends Controller
{
    function mainpage()
    {
        $page['homepage'] = 1;
        $this->set($page);
        $this->layout = "public";
        $this->render("main");
    }

    function add_plan()
    {
        $page['add_plan_page'] = 1;
        $page['page_title'] = "ثبت طرح";
        $page["useselect2"] = 1;
        $this->set($page);
        if (isset($_POST['add-plan'])) {
            $vars = array(
                "owner_name" => $_POST['fl_name'],
                "owner_gender" => $_POST['owner_gender'],
                "owner_birth" => $_POST['birth_date'],
                "owner_phone" => $_POST['phone'],
                "owner_email" => $_POST['email'],
                "owner_city" => $_POST['city'],
                "team_count" => $_POST['team_count'],
                "use_hours" => $_POST['use_hours'],
                "startup_level" => $_POST['startup_level'],
                "startup_term" => $_POST['startup_term'],
                "startup_back" => $_POST['startup_background'],
                "fund" => str_replace(",","", $_POST['fund']),
//                "idea_level" => $_POST['idea_level'],
                "idea_exp" => $_POST['idea_exp'],
                "customers" => $_POST['customers'],
                "income_model" => $_POST['income_model'],
                "economic_model" => $_POST['economic_model'],
                "rival" => $_POST['rival'],
                "innovation" => $_POST['innovation'],
                "rival_advantage" => $_POST['rival_advantage'],
                "concept" => $_POST['concept'],
                "push_history" => $_POST['push_history'],
                "investment_history" => $_POST['investment_history'],
                "presentation" => $_POST['presentation'],
                "idea_title" => $_POST['idea_title']
            );
            if (isset($_POST['members_name'])) {
                $vars["members_name"] = $_POST['members_name'];
                $vars["members_image"] = $_POST['members_image'];
                $vars["members_birth"] = $_POST['members_birth'];
                $vars["members_age"] = $_POST['members_age'];
                $vars["members_certificate"] = $_POST['members_certificate'];
                $vars["members_history"] = $_POST['members_history'];
            }
            $ok = true;
            $concept_files = "";
            $presentation_files = "";
            $members_image = "";
            if (isset($_FILES)) {
                require_once 'filesController.php';
                $filesController = new filesController();
                if (isset($_FILES['concept_files'])) {
                    $ok = $filesController->check_files($_FILES['concept_files']);
                }
                if ($ok && isset($_FILES['presentation_files'])) {
                    $ok = $filesController->check_files($_FILES['presentation_files']);
                }
                if ($ok) {
                    if (isset($_FILES['concept_files']) && !empty($_FILES['concept_files'])) {
                        $ok = $concept_files = $filesController->upload_files($_FILES['concept_files']);
                    }
                    if ($ok && isset($_FILES['presentation_files']) && !empty($_FILES['presentation_files'])) {
                        $ok = $presentation_files = $filesController->upload_files($_FILES['presentation_files']);
                    }
                }
            }
            if ($ok) {
                if (isset($_POST['members_image'])){
                    $ok = $members_image = $filesController->save_member_image($_POST['members_image']);
                }
            }
            if ($ok){
                $vars['concept_files'] = $concept_files;
                $vars['presentation_files'] = $presentation_files;
                $new_vars = $vars;
                if (isset($_POST['members_name'])) {
                    $new_vars['members_image'] = serialize($members_image);
                    $new_vars["members_name"] = serialize($vars['members_name']);
                    $new_vars["members_birth"] = serialize($vars['members_birth']);
                    $new_vars["members_age"] = serialize($vars['members_age']);
                    $new_vars["members_certificate"] = serialize($vars['members_certificate']);
                    $new_vars["members_history"] = serialize($vars['members_history']);
                    $new_vars['members_count'] = count($vars['members_name']);
                }
                $new_vars['presentation_files'] = serialize($vars['presentation_files']);
                $new_vars['concept_files'] = serialize($vars['concept_files']);
                while (true){
                    $tracking_code = rand(100000,999999);
                    $check_code = Database::select("plans", "WHERE tracking_code = $tracking_code");
                    if ($check_code->num_rows == 0){
                        break;
                    }
                }
                $new_vars["tracking_code"] = $tracking_code;
                $this->secure_form($new_vars);
                if(Database::insert("plans", $new_vars)){
                    require_once "sessionController.php";
                    $session = new sessionController();
                    add_message(array("طرح شما با موفقیت ثبت شد. کد پیگیری شما " . $tracking_code . " میباشد."));
                    redirect_to("/");
                }else{
                    add_problem_message();
                }
            }
            $vars['messages'] = get_messages();
        } else {
            $vars = array(
                "owner_name" => "",
                "owner_gender" => "",
                "owner_birth" => "",
                "owner_phone" => "",
                "owner_email" => "",
                "owner_city" => "",
                "team_count" => "",
                "use_hours" => "",
                "startup_level" => "",
                "startup_term" => "",
                "startup_back" => "",
                "fund" => "",
                "idea_level" => "",
                "idea_exp" => "",
                "customers" => "",
                "income_model" => "",
                "economic_model" => "",
                "rival" => "",
                "innovation" => "",
                "rival_advantage" => "",
                "concept" => "",
                "push_history" => "",
                "investment_history" => "",
                "presentation" => "",
                "idea_title" => ""
            );
        }
        $vars = $this->secure_form($vars);
        $this->set($vars);
        $this->layout = "public";
        $this->render('add-plan');
    }

    public function login($type, $page = ""){
        require_once ROOT . "Controllers/sessionController.php";
        $sessionController = new sessionController();
        require_once ROOT . "Models/users.php";
        $usersModel = new users();
        if ($type == "admin"){
            $logged = $sessionController->check_session("admin_logged");
        }elseif ($type == "judge"){
            $logged = $sessionController->check_session("judge_logged");
        }
        if (!$logged){
            $vars['username'] = "";
            if (isset($_POST['login'])){
                $vars['username'] = trim($_POST['username']);
                $vars['password'] = trim($_POST['password']);
                if ($res = $usersModel->login($type, $_POST['username'], $_POST['password'])){
                    if ($res === "confirm"){
                        $vars["page_title"] = "تایید پسورد";
                        $vars["username"] = $_POST["username"];
                        $vars["login_page"] = 1;
                        $this->set($vars);
                        $this->layout = "public";
                        $this->render("confirm_pass");
                        return false;
                    }
                    if ($type == "admin"){
                        $sessionController->add_session(array("admin_logged" => true, "Uname" => $vars['username']));
                    }elseif ($type == "judge"){
                        $username = $vars["username"];
                        $flname = $usersModel->get_judge($username);
                        $flname = $flname["judge_name"];
                        $sessionController->add_session(array("judge_logged" => true, "Uname" => $vars['username'], "flname" => $flname));
                    }
                    if ($type == "admin"){
                        redirect_to("/admin/recent");
                    }elseif ($type == "judge"){
                        redirect_to("/judge/plans");
                    }
                    return true;
                }else{
                    add_message(array("نام کاربری یا کلمه ی عبور صحیح نیست"));
                }
            }elseif (isset($_POST['confirm_pass'])){
                $pass = $this->secure_input($_POST['password_repeat']);
                $username = $this->secure_input($_POST["username"]);
                $judge = $usersModel->get_judge($username);
                $flname = $judge["judge_name"];
                if ($judge["PA"] == $pass){
                    if ($usersModel->login("confirm_judge", $username, $pass)){
                        $sessionController->add_session(array("judge_logged"=>true, "Uname" => $username, "flname"=>$flname));
                        redirect_to("/judge/plans");
                    }
                }
            }
            $vars['page_title'] = "ورود";
            $vars['login_page'] = 1;
            $this->set($vars);
            $this->layout = "public";
            $this->render("login");
            return false;
        }
//        if ($type == "admin" && $page == "login"){
//            redirect_to("/admin/recent");
//        }
        return true;
    }

    public function tracking()
    {
        $vars["page_title"] = "پیگیری طرح";
        $vars["tracking_code_page"] = 1;
        $page = "add_tracking_code";
        if (isset($_POST["get_plan_status"]) && isset($_POST["tracking_code"])){
            $tracking_code = $this->secure_input($_POST["tracking_code"]);
            require_once "plansController.php";
            $planscontroller = new plansController();
            $plan = $planscontroller->get_plans("WHERE tracking_code = $tracking_code");
            if ($plan->num_rows > 0){
                $plan = $plan->fetch_assoc();
                $vars["name"] = $plan["idea_title"];
                $status = $plan["final_status"];
                if ($status === NULL){
                    $status = "نامشخص";
                    $status_color = "blue";
                }elseif ($status == "passed"){
                    $status = "قبول شده";
                    $status_color = "lightgreen";
                }elseif ($status == "rejected"){
                    $status = "رد شده";
                    $status_color = "red";
                }
                $vars["status"] = $status;
                $vars["status_color"] = $status_color;
                $vars["expl"] = $plan["expl"];
                $page = "tracking_page";
                unset($vars["tracking_code_page"]);
            }else{
                add_message(array("کد وارد شده معتبر نمیباشد"));
            }
        }
        $this->set($vars);
        $this->layout = "public";
        $this->render($page);
    }
}