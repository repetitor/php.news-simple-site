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
            'view-file-path' => $this->views . '/index.php',
            'categories' => News::getCategories(),
            'data' => $newsListPagination,
        ];
    }

    public function show($id)
    {
        $item = $this->news->getItem($id);
        $item['uri'] = '?news&id=' . $id;

        return [
            'title-tab' => $item['title'],
            'view-file-path' => $this->views . '/item-read.php',
            'categories' => News::getCategories(),
            'data' => $item,
        ];
    }

    public function edit($id = null)
    {
        if($id){
            $data = $this->news->getItem($id);
            $data['uri'] = '?news&id=' . $id;
            $data['action'] = 'update';
        } else {
            $data['uri'] = '?news';
            $data['action'] = 'create';
        }
        $data['authors'] = Author::getAll();
        $data['categories'] = Category::getAll();

        return [
            'title-tab' => $data['title'] ?? 'News:Create',
            'view-file-path' => $this->views . '/item-edit.php',
            'categories' => News::getCategories(),
            'data' => $data,
        ];
    }

    public function create($params)
    {
        $this->news->create($params);

//        $item = $this->news->getItem($id);

//        return [
//            'title-tab' => $item['title'],
//            'view-file-path' => $this->views . '/item-read.php',
//            'categories' => News::getCategories(),
//            'data' => $item,
//        ];
        return $this->index();
    }

    public function update($id, $params)
    {
        $this->news->update($id, $params);

        $item = $this->news->getItem($id);

        return [
            'title-tab' => $item['title'],
            'view-file-path' => $this->views . '/item-read.php',
            'categories' => News::getCategories(),
            'data' => $item,
        ];
    }

    public function delete($id)
    {
        $this->news->delete($id);

        return $this->index();
    }
}