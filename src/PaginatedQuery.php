<?php


namespace App;

use \PDO;

class PaginatedQuery
{
    protected $query;
    protected $queryCount;
    protected $pdo;
    protected $perPage;
    protected $count;
    protected $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?PDO $pdo = null,
        int $perPage = 12
    )
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    public function getItems(string $classMapping): array
    {
        if($this->items == null) {
            $currentPage = $this->getCurrentPage();
            $pages = $this->getPages();
            if($currentPage > $pages) {
                throw new \Exception('Cette page n\'existe pas');
            }
            $offset = $this->perPage * ($currentPage - 1);
            return $this->pdo->query(
                $this->query .
                "LIMIT {$this->perPage} OFFSET $offset")
                ->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items;
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage <= 1) return null;
        if($currentPage >2) $link .= "?page=" . ($currentPage -1);
            return <<<HTML
                <a href="{$link}" class="btn btn-primary">&laquo; Page Précedente</a>
HTML;
    }

    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($currentPage >= $pages) return null;
        $link .= "?page=" . ($currentPage +1);
        return <<<HTML
                <a href="{$link}" class="btn btn-primary ml-auto">Page suivante &raquo;</a>
HTML;
    }

    public function pagination(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($pages <= 1) {
            return '';
        }
        if($currentPage <= 1) {
            $linkPrev = '#';
            $statusPrev = ' disabled';
        } else {
            $linkPrev = $link ."?page=" . ($currentPage -1);
            $statusPrev = '';
        }
        if($currentPage >= $pages) {
            $linkNext = '#';
            $statusNext = ' disabled';
        } else {
            $linkNext = $link ."?page=" . ($currentPage +1);
            $statusNext = '';
        }
        $pageLinks = '';
        for($i=1; $i<=$pages; $i++) {
            $status = ($i == $currentPage) ? ' active' : '';
            $pageLinks .= '<li class="page-item' .$status.'"><a class="page-link" href="' . $link . '?page='. $i .'">'.$i.'</a></li>';
        }
        return <<<HTML
                 <ul class="pagination">
                  <li class="page-item{$statusPrev}"><a class="page-link" href="{$linkPrev}">Précedent</a></li>
                    {$pageLinks}
                  <li class="page-item{$statusNext}"><a class="page-link" href="{$linkNext}">Suivant</a></li>
                </ul> 
HTML;
    }

    private function getCurrentPage(): ?int
    {
        return URL::getPositiveInt('page', 1);
    }

    private function getPages():int
    {
        if($this->count == null){
            $this->count = (int)$this->pdo
                ->query($this->queryCount)
                ->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->perPage);
    }
}