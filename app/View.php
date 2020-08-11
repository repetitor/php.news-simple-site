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

//    public function injectInTemplate($content = null, $titleTab = null, $hasPermissionChange = false)
    public function injectInTemplate($content = null, $params = [])
    {
//        $titleTab = $params['title-tab'] ?? null;
//        $authenticated = $params['authenticated'] ?? false;

        return $this->render('views/templates/' . Env::TEMPLATE_PATH, [
            'titleTab' => $params['title-tab'],
            'loginLogoutForm' => $params['login-logout-form'],
//            'loginLogoutForm' => $this->render('views/auth/loginLogoutForm.php', [
//                'authenticated' => $params['authenticated'] ?? false,
//            ]),
//            'categories' => News::getCategories(),
            'categories' => $params['categories'],
            'content' => $content,
        ]);
    }
}