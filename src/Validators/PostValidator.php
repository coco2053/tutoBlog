<?php
namespace App\Validators;

use App\Table\PostTable;

class PostValidator extends AbstractValidator
{

    public function __construct(array $data, PostTable $table, ?int $postId = null, array $categoriesIds)
    {
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule('subset', 'categories_ids',array_keys($categoriesIds));
        $this->validator->rule(function($field, $value) use($table, $postId) {
            return !$table->exists($field, $value, $postId);
        },['slug','name'], 'Cette valeur est déjà utilisée');
    }
}