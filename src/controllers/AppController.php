<?php

class AppController{

    protected $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    static function getRequestJson(){
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        return $data;
    }
    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $template.'.php';
        $output = 'File not found';
                
        if(file_exists($templatePath)){
            extract($variables);
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}