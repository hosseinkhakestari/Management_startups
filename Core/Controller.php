<?php
    class Controller
    {
        var $vars = [
            "page_title" => ""
        ];
        var $layout = "default";

        function set($d)
        {
            $this->vars = array_merge($this->vars, $d);
        }
        function render($filename)
        {
            extract($this->vars);
            ob_start();
            require(ROOT . "Views/" . str_replace('Controller', '', get_class($this)) . '/' . $filename . '.php');
            $content_for_layout = ob_get_clean();

            if ($this->layout == false)
            {
                echo $content_for_layout;
            }
            else
            {
                require(ROOT . "Views/Layouts/" . $this->layout . '.php');
            }
        }

        protected function secure_input($data)
        {
            if (gettype($data) !== "array"){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
            }
            return $data;
        }

        protected function secure_form($form)
        {
            foreach ($form as $key => $value)
            {
                $form[$key] = $this->secure_input($value);
            }
            return $form;
        }

    }
?>