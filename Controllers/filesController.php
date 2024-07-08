<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/21/20
 * Time: 7:10 AM
 */

class filesController
{
    private $max_size = 20000000;
    private $upload_dir = ROOT . "uploads/";
    private $allowed = array('apk', 'mp4', 'pptx', 'ppt', 'doc', 'docx', 'pdf', "png", "jpeg", "jpg", "JPG");
    function check_files($files){
        $files_count = count($files['name']);
//        check errors
        for ($i = 0; $i < $files_count; $i++){
            if ($files['error'][$i] !== 0 && $files['error'][$i] !== 4){
                add_message(array("فایل های آپلود شده اشکال دارد. مجدد امتحان کنید"));
                return false;
            }
        }
//        check files size
        for ($i = 0; $i < $files_count; $i++){
            if ($files['error'][$i] == 4){
                continue;
            }
            if ($files['size'][$i] > $this->max_size){
                add_message(array("حجم فایل ها باید کمتر از " . $this->max_size/1000000 . " مگابایت باشد.", "فایل ها را مجدد آپلود کنید."));
                return false;
            }
        }
//        check files type
        for ($i = 0; $i < $files_count; $i++){
            if ($files['error'] == 4){
                continue;
            }
            $file_ext = explode(".", $files['name'][$i]);
            $file_ext = end($file_ext);
            if (!array_search($file_ext, $this->allowed)){
                add_message(array("فایل غیر مجاز", "فایل ها را مجداد آپلود کنید"));
                return false;
            }
        }
        return true;
    }

    function upload_files($files = array()){
        $files_count = count($files['name']);
        $file_names = array();
        for ($i = 0; $i < $files_count; $i++){
            if ($files['error'][$i] == 4){
                continue;
            }
            $file_ext = explode(".", $files['name'][$i]);
            $file_ext = end($file_ext);
            $name = date("Y-m-d - H-i-s") . " " . rand();
            $name = $name . "." . $file_ext;
            if (move_uploaded_file($files['tmp_name'][$i], $this->upload_dir . $name)){
                array_push($file_names, $name);
            }else{
                return false;
            }
        }
        return $file_names;
    }

    function save_member_image($images){
        $names = array();
        for ($i = 0; $i < count($images); $i++){
            $data = $images[$i];
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $name = date("Y-m-d - H-i-s") . " " . rand();
            $name .= ".png";
            $save = file_put_contents($this->upload_dir . $name, $data);
            if ($save){
                array_push($names, $name);
            }else{
                add_message("تصاویر اعضا را به درستی وارد کنید");
                return false;
            }
        }
        return $names;
    }

    public function dl($file_name, $file_ext)
    {
        $file = ROOT . "uploads/" . str_replace("_", " ", $file_name) . "." . $file_ext;
        if (file_exists($file)){
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
}