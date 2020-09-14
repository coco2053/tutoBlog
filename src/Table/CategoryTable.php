<?php


namespace App\Table;

use App\Entity\Category;
use App\PaginatedQuery;
use \PDO;

final class CategoryTable extends Table
{
    protected $table = "category";
    protected $class = Category::class;

    public function hydratePosts(array $posts):void
    {
        $postById = [];
        foreach($posts as $post) {
            $post->setCategories([]);
            $postById[$post->getId()] = $post;
        }
        $categories = $this->pdo->query('SELECT c.*, pc.post_id
             FROM post_category pc
             JOIN category c ON c.id = pc.category_id
             WHERE pc.post_id IN (' . implode(',', array_keys($postById)) .')'
        )->fetchAll(PDO::FETCH_CLASS, $this->class);

        foreach($categories as $category) {
            $postById[$category->getPostId()]->addCategory($category);
        }
    }

    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * 
            FROM {$this->table}
            ORDER BY id DESC ",
            "SELECT COUNT(id) FROM {$this->table}",
            $this->pdo
        );
        $categories = $paginatedQuery->getItems(Category::class);

        return [$categories, $paginatedQuery];
    }


    public function list():array
    {
        $categories = $this->all();
        $results = [];
        foreach($categories as $category) {
            $results[$category->getId()] = $category->getName();
        }
        return $results;
    }
}