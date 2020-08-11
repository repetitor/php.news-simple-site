<?php

require_once 'NewsController.php';

class RequestResponse
{
    private $response = null;

    public function __construct()
    {
        $this->setResponse();
    }

    private function setResponse()
    {
        if(isset($_GET['news'])){
            $controller = new NewsController();

            if(isset($_GET['id'])){
                if(isset($_GET['action']) && $_GET['action'] == 'edit'){
                    $this->response = $controller->edit($_GET['id']);
                } elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
                    $this->response = $controller->update($_GET['id'], $_POST);
                } elseif (isset($_GET['action']) && $_GET['action'] == 'delete') {
                    $this->response = $controller->delete($_GET['id']);
                } else {
                    $this->response = $controller->show($_GET['id']);
                }
            } elseif (isset($_GET['action']) && $_GET['action'] == 'create') {
                $this->response = $controller->edit();
            } elseif (isset($_POST['action']) && $_POST['action'] == 'create') {
                $this->response = $controller->create($_POST);
            } else {
                $this->response = $controller->index();
            }
        } elseif (isset($_GET['test'])) {
            $this->response = $this->test();
        } else {
            //default
//            $this->response = $this->test();
            $this->response = (new NewsController())->index();
        }
    }

    public function getResponse()
    {
        return $this->response;
    }

    private function test()
    {
        return [
            'title-tab' => 'tab - Test',
            'view-file-path' => 'views/testview.php',
            'data' => [
                'paramTest' => 'value: Test',
                'paramTest2' => 'value2: Test2',
            ],
        ];
    }
}