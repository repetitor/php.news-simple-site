<?php

require_once 'News.php';


class NewsController
{
    private $news;

    public function __construct()
    {
        $this->news = new News();
    }

    public function index()
    {
//        return $this->news->getList();
        $params['page'] = $_GET['page'] ?? 1;
        $params['category'] = $_GET['category'] ?? null;

        return $this->news->getListPagination($params);
    }

    public function show($id)
    {
        return $this->news->getItem($id);
    }

    public function create()
    {
        return $this->news->form_store();
    }

    public function store($params)
    {
        $id = $this->news->store($params);

        return $this->show($id);
    }

    public function edit($id)
    {
        return $this->news->form_update($id);
    }

    public function update($id, $params)
    {
        $this->news->update($id, $params);

        return $this->show($id);
    }

    public function delete($id)
    {
        $this->news->delete($id);

        return $this->index();
    }

    public function deleteImage($id)
    {
        $this->news->deleteImage($id);

        return $this->show($id);
    }
}