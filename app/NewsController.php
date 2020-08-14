<?php

require_once 'News.php';
require_once 'Author.php';
require_once 'Category.php';


class NewsController
{
    private $news;
    private $views = 'views/news';

    public function __construct()
    {
        $this->news = new News();
    }

    public function index()
    {
        $params['page'] = $_GET['page'] ?? 1;
        $params['category'] = $_GET['category'] ?? null;

        $newsListPagination = $this->news->getNewsListPagination($params);

        return [
            'title-tab' => 'Новости - Список',
            'view-file-path' => $this->views . '/list.php',
            'categories' => Category::getAll(),
            'data' => $newsListPagination,
        ];
    }

    public function show($id)
    {
        $item = $this->news->getItem($id);

        return [
            'title-tab' => $item['title'],
            'view-file-path' => $this->views . '/item.php',
            'categories' => Category::getAll(),
            'data' => $item,
        ];
    }

    public function edit($id = null)
    {
        if($id){
            $data = $this->news->getItem($id);
            $data['uri_action'] = $data['uri'];
            $data['action'] = 'update';
        } else {
            $data['uri_action'] = News::URI;
            $data['action'] = 'create';
        }

        $data['authors'] = Author::getAll();
        $data['categories'] = Category::getAll();

        return [
            'title-tab' => $data['title'] ?? 'News:Create',
            'view-file-path' => $this->views . '/item-form.php',
            'categories' => Category::getAll(),
            'data' => $data,
        ];
    }

    public function create($params)
    {
        $id = $this->news->create($params);

        return $this->show($id);
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
}