<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'Database.php';


class News
{
    const URI = '?news';

    public function test()
    {
        return Env::NEWS_LIMIT_PER_PAGE;
    }

    public static function getCategories()
    {
        return Database::query('SELECT * FROM categories ORDER BY id ASC');
    }

    /**
     * @param array $params
     *
    i.g.: $params = [
        'category' => null,
        'page' => 1,
        'hasPermissionChange' => false,
    ]
     *
     * @return array
     */
    public function getNewsListPagination($params = []){
        $categoryId = $params['category'] ?? null;
        $currentPage = $params['page'] ?? 1;
        $limitPerPage = Env::NEWS_LIMIT_PER_PAGE; // How many items to list per page

        if(isset($params['hasPermissionChange']) && $params['hasPermissionChange'] == true){
            $hasPermissionChange = true;
        } else {
            $hasPermissionChange = false;
        }

        $startQueryPage = ($currentPage != 1) ? ($currentPage-1) : null;
        $finishQueryPage = $currentPage + 1;

        $offset = $startQueryPage ? (($startQueryPage - 1) * $limitPerPage) : 0;

        $limit = $startQueryPage ? ($limitPerPage * 3) : ($limitPerPage * 2);

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

        if($categoryId){
            $sql .=' WHERE news.category_id = ' . $categoryId;
        }

        $sql .= ' ORDER BY news.id DESC LIMIT ' . $limit . ' OFFSET ' . $offset;

        $news = Database::query($sql);

        $newsUpdated = [];

        foreach ($news as $item){
            $item['title'] = Helper::trimText($item['title'], 30);
            $item['description'] = Helper::trimText($item['description'], 150);
            $item['uri'] = '?news&id=' . $item['id'];
            $item['uri_edit'] = '?news&id=' . $item['id'] . '&action=edit';
            $item['uri_delete'] = '?news&id=' . $item['id'] . '&action=delete';

            array_push($newsUpdated, $item);
        }

        if($startQueryPage){
            $newsPrevPage = array_slice($newsUpdated, 0, $limitPerPage);
            $newsCurrentPage = array_slice($newsUpdated, $limitPerPage, $limitPerPage);
            $newsNextPage = array_slice($newsUpdated, $limitPerPage * 2, $limitPerPage);
        } else {
            $newsPrevPage = [];
            $newsCurrentPage = array_slice($newsUpdated, 0, $limitPerPage);
            $newsNextPage = array_slice($newsUpdated, $limitPerPage, $limitPerPage);
        }

        $uri = self::URI;
        $uriPrevPage = count($newsPrevPage) ? ($uri . '&page=' . $startQueryPage) : null;
        $uriNextPage = count($newsNextPage) ? ($uri . '&page=' . $finishQueryPage) : null;

        if($categoryId){
            if($uriPrevPage){
                $uriPrevPage .= '&category=' . $categoryId;
            }
            if($uriNextPage){
                $uriNextPage .= '&category=' . $categoryId;
            }
        }

        return [
            'news' => $newsCurrentPage,
            'uri_create' => self::URI . '&action=create',
            'uriPrevPage' => $uriPrevPage,
            'uriNextPage' => $uriNextPage,
            'hasPermissionChange' => $hasPermissionChange,
        ];
    }

    public function getItem($id){
        $sql = 'SELECT 
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

        return Database::query($sql)->fetch();
    }

    public function create($params){
//        $sql = 'INSERT INTO news (`name`, `description`, `author_id`, `category_id`) VALUES (
//            "' . $params['name'] . '",
//            "' . $params['description'] . '",
//            "' . $params['author_id'] . '",
//            "' . $params['category_id'] . '",
//)';
        $statement = 'INSERT INTO news (`name`, `description`, `author_id`, `category_id`) VALUES (
            "' . $params['name'] . '",
            "' . $params['description'] . '",
            "' . $params['author_id'] . '",
            "' . $params['category_id'] . '"
)';
        $PDOStatement = Database::query($statement);

//        return $this->getNewsListPagination();
    }

    public function update($id, $params){
        $sql = 'UPDATE news 
            SET name = "' . $params['name'] . '", 
                author_id = "' . $params['author_id'] . '", 
                category_id = "' . $params['category_id'] . '", 
                description = "' . $params['description'] . '", 
                updated_at = "' . date('Y-m-d H:i') . '" 
            WHERE id = ' . $id . ';';

        return Database::query($sql);
    }

    public function delete($id){
        $sql = 'DELETE FROM news WHERE id = ' . $id . ';';

        return Database::query($sql);
    }
}