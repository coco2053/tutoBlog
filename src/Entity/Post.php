<?php
namespace App\Entity;

use App\Helpers\Text;
use \DateTime;

class Post
{
    protected $id;
    protected $name;
    protected $slug;
    protected $content;
    protected $created_at;
    protected $categories = [];

    public function hydrate(array $formData)
    {

        foreach ($formData as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): ?self
    {
        $this->name = $name;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): ?self
    {
        $this->content = $content;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(e($this->content));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;
        return $this;
    }

    public function getExcerpt(int $limit = 60): ?string
    {
        if($this->content == null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, $limit)));
    }

    /**
     * @return Category[]
     */
    public function getCategories():array
    {
        return $this->categories;
    }

    public function setCategories(array $categories):self
    {
        $this->categories = $categories;
        return $this;
    }


    public function getCategoriesIds():array
    {
        $ids = [];
        foreach($this->categories as $category) {
            $ids[] = $category->getId();
        }
        return $ids;
    }


    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }
}