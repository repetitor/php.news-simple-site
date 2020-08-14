<?php

require_once 'Env.php';

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

    public function injectInTemplate($content = null, $params = [])
    {
        return $this->render(Env::TEMPLATE_PATH, [
            'content_rendered' => $content,

            'can_auth' => $params['can-auth'] ?? null,
            'is_admin' => $params['is-admin'] ?? false,

            'title_tab' => $params['title-tab'] ?? Env::DEFAULT_TITLE_TAB,
            'categories' => $params['categories'] ?? null,

            'link_css' => Env::LINK_CSS,
        ]);
    }
}