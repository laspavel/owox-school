<?php

class View

{
    public $path;

    public function __construct($path)
    {
        $this->path = '/' . $path;
    }


    public function render($template = '', $data = array())
    {
        if (file_exists(__DIR__ . '/..' . $this->path . '/views/' . $template . '.php')) {

            if (!empty($data)) {
                extract($data);
            }
            ob_start();

            require(__DIR__ . '/..' . $this->path . '/views/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

        } else {
            $output = $this->path . '/views/' . $template . '.php not found';
        }

        return $output;
    }

}