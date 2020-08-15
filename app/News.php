<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'Database.php';
require_once 'Author.php';
require_once 'Category.php';


class News
{
    const URI = Env::URI . '?news';
    const VIEWS_PATH = 'views/news';
    const MESSAGE_INVALID_ID = 'ID is invalid';

    private $template;

    public function __construct()
    {
        $this->template = [
            'path' => Env::MAIN_TEMPLATE_PATH,
            'data' => [
                'title_tab' => Env::DEFAULT_TITLE_TAB,
                'link_css' => Env::LINK_MAIN_TEMPLATE_CSS,
                'categories' => Category::getAll(),
            ],
        ];
    }

    public function getList($params = [])
    {
        $sql = 'SELECT 
            news.id,
            news.name AS title, 
            authors.name AS author,
            categories.name AS category,
            news.description,
            news.created_at,
            news.updated_at
            FROM news 
            JOIN authors ON news.author_id = authors.id
            JOIN categories ON news.category_id = categories.id 
        ';

        if($params['category_id']){
            $sql .=' WHERE news.category_id = ' . $params['category_id'];
        }

        $limit = $params['limit'] ?? Env::NEWS_LIMIT_PER_PAGE ?? null;
        if($limit){
            $sql .= ' ORDER BY news.id DESC LIMIT ' . $limit;
        }

        if($params['offset']){
            $sql .= ' OFFSET ' . $params['offset'];
        }

        $news = Database::query($sql);

        $newsUpdated = [];

        foreach ($news as $item){
            $item['title'] = Helper::trimText($item['title'], 30);
            $item['description'] = Helper::trimText($item['description'], 150);
            $item['created_at'] = Helper::fromUtcToLocalTime($item['created_at']);
            $item['updated_at'] = Helper::fromUtcToLocalTime($item['updated_at']);

            $item['uri'] = self::URI . '&id=' . $item['id'];
            $item['uri_edit'] = self::URI . '&id=' . $item['id'] . '&edit';

            array_push($newsUpdated, $item);
        }

        $data = [
            'news' => $newsUpdated,
            'uri_parent' => self::URI,
            'uri_create' => self::URI . '&create',
        ];

        $this->template['data']['title_tab'] = 'Новости - Список';

        return [
            'template' => $this->template,
            'content' => [
                'path' => self::VIEWS_PATH . '/list.php',
                'data' => $data,
            ],
        ];
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getListPagination($params = []){
        $categoryId = $params['category'] ?? null;
        $currentPage = $params['page'] ?? 1;
        $limitPerPage = Env::NEWS_LIMIT_PER_PAGE; // How many items to list per current page

        $startQueryPage = ($currentPage != 1) ? ($currentPage-1) : null;
        $finishQueryPage = $currentPage + 1;

        // How many items to all query pages
        $limit = $startQueryPage ? ($limitPerPage * 3) : ($limitPerPage * 2);

        // How many items to skip
        $offset = $startQueryPage ? (($startQueryPage - 1) * $limitPerPage) : 0;

        $data = $this->getList([
            'category_id' => $categoryId,
            'limit' => $limit,
            'offset' => $offset,
        ]);
        $news = $data['content']['data']['news'];

        if($startQueryPage){
            $newsPrevPage = array_slice($news, 0, $limitPerPage);
            $newsCurrentPage = array_slice($news, $limitPerPage, $limitPerPage);
            $newsNextPage = array_slice($news, $limitPerPage * 2, $limitPerPage);
        } else {
            $newsPrevPage = [];
            $newsCurrentPage = array_slice($news, 0, $limitPerPage);
            $newsNextPage = array_slice($news, $limitPerPage, $limitPerPage);
        }

        $uriPrevPage = count($newsPrevPage) ? (self::URI . '&page=' . $startQueryPage) : null;
        $uriNextPage = count($newsNextPage) ? (self::URI . '&page=' . $finishQueryPage) : null;

        if($categoryId){
            if($uriPrevPage){
                $uriPrevPage .= '&category=' . $categoryId;
            }
            if($uriNextPage){
                $uriNextPage .= '&category=' . $categoryId;
            }
        }

        $data['content']['data']['news'] = $newsCurrentPage;
        $data['content']['data']['uriPrevPage'] = $uriPrevPage;
        $data['content']['data']['uriNextPage'] = $uriNextPage;

        return $data;
    }

    public function getItem($id){
        $sql = 'SELECT 
            news.id,
            news.name AS title, 
            news.author_id, 
            authors.name AS author,
            categories.name AS category,
            news.category_id, 
            news.description,
            news.created_at,
            news.updated_at
            FROM news 
            LEFT JOIN authors ON news.author_id = authors.id
            LEFT JOIN categories ON news.category_id = categories.id 
            WHERE news.id = ' . $id . ' 
            LIMIT 1
        ';

        $item = Database::query($sql)->fetch();

        if(! $item){
            return ['message' => self::MESSAGE_INVALID_ID];
        }

        $item['created_at'] = Helper::fromUtcToLocalTime($item['created_at']);
        $item['updated_at'] = Helper::fromUtcToLocalTime($item['updated_at']);
        $item['uri'] = self::URI . '&id=' . $id;
        $item['uri_edit'] = self::URI . '&id=' . $id . '&edit';
        $item['uri_parent'] = self::URI;

        $this->template['data']['title_tab'] = $item['title'];

        return [
            'template' => $this->template,
            'content' => [
                'path' => self::VIEWS_PATH . '/item.php',
                'data' => $item,
            ],
        ];
    }

    private function specialDataForm()
    {
        $data['authors'] = Author::getAll();
        $data['categories'] = Category::getAll();

        return $data;
    }

    public function form_store()
    {
        $data = $this->specialDataForm();
        $data['uri_action'] = News::URI;
        $data['action'] = 'store';

        $this->template['data']['title_tab'] = 'Добавить новости';

        return [
            'template' => $this->template,
            'content' => [
                'path' => self::VIEWS_PATH . '/item-form.php',
                'data' => $data,
            ],
        ];
    }

    public function store($params){
        $statement = 'INSERT INTO news (`name`, `description`, `author_id`, `category_id`) VALUES (
            "' . $params['name'] . '",
            "' . $params['description'] . '",
            "' . $params['author_id'] . '",
            "' . $params['category_id'] . '"
        )';

        return Database::insertGetLastId($statement);
    }

    public function form_update($id)
    {
        $item = $this->getItem($id);

        if(isset($item['message']) && $item['message'] == self::MESSAGE_INVALID_ID){
            return $item;
        }

        $specialDataForm = $this->specialDataForm();

        $data = array_merge($item['content']['data'], $specialDataForm);
        $data['uri_action'] = $data['uri'];
        $data['action'] = 'update';

        $this->template['data']['title_tab'] = 'Редактировать: ' . $data['title'];

        return [
            'template' => $this->template,
            'content' => [
                'path' => self::VIEWS_PATH . '/item-form.php',
                'data' => $data,
            ],
        ];
    }

    public function update($id, $params){
        $sql = 'UPDATE news 
            SET name = "' . $params['name'] . '", 
                author_id = "' . $params['author_id'] . '", 
                category_id = "' . $params['category_id'] . '", 
                description = "' . $params['description'] . '", 
                updated_at = "' . date('Y-m-d H:i') . '" 
            WHERE id = ' . $id . ';';

        Database::query($sql);
    }

    public function delete($id){
        $sql = 'DELETE FROM news WHERE id = ' . $id . ';';
        Database::query($sql);
    }
}