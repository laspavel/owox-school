<?php

class View
{

    public function render($template = '', $data = array())
    {
        if (file_exists(__DIR__ . '/../views/' . $template . '.php')) {

            if (!empty($data)) {
                extract($data);
            }
            ob_start();

            require(__DIR__ . '/../views/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

        } else {
            $output = __DIR__ . '/../views/' . $template . '.php not found';
        }

        return $output;
    }

}