<?php declare(strict_types=1);

namespace engine\libs;

/**
 * Class Pagination
 *
 * @author sergey
 */
class Pagination 
{
    /**
     * Current page
     * 
     * @var int 
     */
    public $currentPage;
    /**
     * Count items on one page
     * 
     * @var int
     */
    public $perpage;
    /**
     * All items
     * 
     * @var int 
     */
    public $total;
    /**
     * Count all pages
     * 
     * @var int
     */
    public $countPages;
    /**
     * Uri
     * 
     * @var string
     */
    public $uri;
    
    /**
     * Constructor pagination
     * 
     * @param int $page
     * @param int $perpage
     * @param int $total
     */
    public function __construct(int $page, int $perpage, int $total)
    {
        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }
    
    /**
     * Return html
     * 
     * @return string
     */
    public function __toString(): string
    {
        return $this->getHtml();
    }

    /**
     * build html view pagination
     * 
     * @return string
     */
    public function getHtml(): string
    {
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startpage = null; // ссылка В НАЧАЛО
        $endpage = null; // ссылка В КОНЕЦ
        $page2left = null; // вторая страница слева
        $page1left = null; // первая страница слева
        $page2right = null; // вторая страница справа
        $page1right = null; // первая страница справа

        if( $this->currentPage > 1 ){
            $back = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage - 1). "'>&lt;</a></li>";
        }

        if( $this->currentPage < $this->countPages ){
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>&gt;</a></li>";
        }

        if( $this->currentPage > 3 ){
            $startpage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }
        if( $this->currentPage < ($this->countPages - 2) ){
            $endpage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }
        if( $this->currentPage - 2 > 0 ){
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-2). "'>" .($this->currentPage - 2). "</a></li>";
        }
        if( $this->currentPage - 1 > 0 ){
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage-1). "'>" .($this->currentPage-1). "</a></li>";
        }
        if( $this->currentPage + 1 <= $this->countPages ){
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 1). "'>" .($this->currentPage+1). "</a></li>";
        }
        if( $this->currentPage + 2 <= $this->countPages ){
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" .($this->currentPage + 2). "'>" .($this->currentPage + 2). "</a></li>";
        }

        return '<ul class="pagination">' . $startpage.$back.$page2left.$page1left.'<li class="active"><a>'.$this->currentPage.'</a></li>'.$page1right.$page2right.$forward.$endpage . '</ul>';
    }
    
    /**
     * Get count page
     * 
     * @return int
     */
    public function getCountPages(): int
    {
        return (int)ceil($this->total / $this->perpage) ?: 1;
    }
    
    /**
     * Get current page
     * 
     * @param int $page
     * @return int
     */
    public function getCurrentPage(int $page): int
    {
        if(!$page || $page < 1) $page = 1;
        if($page > $this->countPages) $page = $this->countPages;
        return $page;
    }
    
    /**
     * Get start position for LIMIT 0, 1
     * 
     * @return int
     */
    public function getStart(): int
    {
        return ($this->currentPage - 1) * $this->perpage;
    }
    
    /**
     * Get query string params
     * 
     * @return string
     */
    public function getParams(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';
        
        if (isset($url[1]) && $url[1] != '') {
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
        return $uri;
    }
}
