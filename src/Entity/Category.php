<?php


namespace App\Entity;


class Category
{
    protected $id;
    protected $slug;
    protected $name;
    protected $post_id;
    protected $post;

    public function hydrate(array $formData)
    {

        foreach ($formData as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId():?int
    {
        return $this->id;
    }

    public function setId(int $id):self
    {
        $this->id = $id;
        return $this;
    }

    public function getSlug():?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getName():?string
    {
        return $this->name;
    }

    public function setName(string $name):self
    {
        $this->name = $name;
        return $this;
    }

    public function getPostId():?int
    {
        return $this->post_id;
    }

    public function setPost(Post $post):void
    {
        $this->post = $post;
    }

    public function __toString()
    {
        return $this->getName();
    }

}