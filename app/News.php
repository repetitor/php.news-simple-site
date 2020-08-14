<?php

require_once 'Env.php';
require_once 'Helper.php';
require_once 'Database.php';


class News
{
    const URI = Env::URI . '?news';

    /**
     * @param array $params
     *
    i.g.: $params = [
        'category' => null,
        'page' => 2,
    ]
     *
     * @return array
     */
    public function getNewsListPagination($params = []){
        $categoryId = $params['category'] ?? null;
        $currentPage = $params['page'] ?? 1;
        $limitPerPage = Env::NEWS_LIMIT_PER_PAGE; // How many items to list per current page

        $startQueryPage = ($currentPage != 1) ? ($currentPage-1) : null;
        $finishQueryPage = $currentPage + 1;

        $offset = $startQueryPage ? (($startQueryPage - 1) * $limitPerPage) : 0; // How many items to skip

        // How many items to all query pages
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
            $item['created_at'] = Helper::fromUtcToLocalTime($item['created_at']);
            $item['updated_at'] = Helper::fromUtcToLocalTime($item['updated_at']);

            $item['uri'] = '?news&id=' . $item['id'];
            $item['id'] = $item['id'];
            $item['uri_edit'] = '?news&id=' . $item['id'] . '&edit';
//            $item['uri_delete'] = '?news&id=' . $item['id'] . '&action=delete';

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
            'uri_parent' => self::URI,
            'uri_create' => self::URI . '&create',
            'uriPrevPage' => $uriPrevPage,
            'uriNextPage' => $uriNextPage,
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

        $item = Database::query($sql)->fetch();

        $item['created_at'] = Helper::fromUtcToLocalTime($item['created_at']);
        $item['updated_at'] = Helper::fromUtcToLocalTime($item['updated_at']);
        $item['uri'] = self::URI . '&id=' . $id;
        $item['uri_edit'] = self::URI . '&id=' . $id . '&edit';
        $item['uri_parent'] = self::URI;
        $item['id'] = $id;

        return $item;
    }

    public function create($params){
        $statement = 'INSERT INTO news (`name`, `description`, `author_id`, `category_id`) VALUES (
            "' . $params['name'] . '",
            "' . $params['description'] . '",
            "' . $params['author_id'] . '",
            "' . $params['category_id'] . '"
        )';
//        $PDOStatement = Database::query($statement);
//        Database::insertGetLastId($statement);
        return Database::insertGetLastId($statement);

//        return $this->getNewsListPagination();
//        $date = date_create_from_format('Y-m-d H:i', time());
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

//        return Database::query($sql);
        Database::query($sql);
    }
}