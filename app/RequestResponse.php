<?php

require_once 'Env.php';
require_once 'View.php';


class RequestResponse
{
    private $response;

    public function __construct()
    {
        $this->setResponse();
    }

    private function setResponse()
    {
        $this->response = [
            'view-file-path' => Env::TEST_VIEW_PATH,
            'data' => [
                'paramTest' => 'valueTest',
            ]
        ];
    }

    public function getResponse()
    {
        return $this->response;
    }
}