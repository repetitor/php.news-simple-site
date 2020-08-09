<?php

require_once 'Env.php';
require_once 'News.php';

class View
{
    public function render($viewFilePath, $data = null)
    {
        if($data){
            extract($data);
        }
        ob_start();
        require $viewFilePath;

        return ob_get_clean();
    }

    public function injectInTemplate($content = null, $titleTab = null)
    {
        return $this->render(Env::TEMPLATE_PATH, [
            'titleTab' => $titleTab,
            'categories' => News::getCategories(),
            'content' => $content,
        ]);
    }
}