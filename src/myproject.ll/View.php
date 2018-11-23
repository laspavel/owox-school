<?php

class View
{

    public function render($template = '', $data = array())
    {
        if (file_exists(__DIR__ . '/templates/' . $template . '.php')) {

            if (!empty($data)) {
                extract($data);
            }
            ob_start();

            require(__DIR__ . '/templates/' . $template . '.php');

            $output = ob_get_contents();

            ob_end_clean();

        } else {
            $output = $template . ' not found';
        }

        return $output;
    }

}