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
                if(isset($_GET['edit'])){
                    $this->response = $controller->edit($_GET['id']);
                } elseif (isset($_POST['update'])) {
                    $this->response = $controller->update($_GET['id'], $_POST);
                } else {
                    $this->response = $controller->show($_GET['id']);
                }
            } elseif (isset($_POST['delete'])) {
                $this->response = $controller->delete($_POST['id']);
            } elseif (isset($_GET['create'])) {
                $this->response = $controller->edit();
            } elseif (isset($_POST['create'])) {
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
                'param_test' => 'value: Test',
                'param_test2' => 'value2: Test2',
            ],
        ];
    }
}