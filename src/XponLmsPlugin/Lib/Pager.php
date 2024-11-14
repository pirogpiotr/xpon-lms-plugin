<?php


namespace XponLmsPlugin\Lib;

use InvalidArgumentException;

class Pager
{
    const DEFAULT_LIMIT = 50;
    const KEY_PAGE_NUMBER = 'page';

    /** @var int */
    protected $limit = self::DEFAULT_LIMIT;

    /** @var int Liczone od 1 */
    protected $page = 1;

    /** @var int */
    protected $total;

    /** @var string */
    protected $sort;

    /** @var string */
    protected $defaultSort;

    /** @var array */
    protected $queryParams = [];

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $page
     * @return Pager
     */
    public function setPageNumber($page)
    {
        if ($page < 1) {
            $page = 1;
        }
        // can't check upper range - $total is uknown at moment of settings $page

        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getPages()
    {
        return max(intval(ceil($this->getTotal() / $this->getLimit())), 1);
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     * @return static
     * @throws InvalidArgumentException
     */
    public function setLimit($limit)
    {
        if (!is_numeric($limit)) {
            throw new InvalidArgumentException(__METHOD__ .  " error !is_numeric('$limit')");
        }
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public function getTotal()
    {
        return $this->total;
    }
    /**
     * @param int $total
     * @return static
     */
    public function setTotal($total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return ($this->getPage() - 1) * $this->getLimit();
    }

    /**
     * @param bool $includeDefaultSort
     * @return string
     */
    public function getSort($includeDefaultSort = false)
    {
        $sort = $this->sort;

        if ($includeDefaultSort && $defaultSort = $this->getDefaultSort()) {
            $sort .= $sort ? ',' . $defaultSort : $defaultSort;
        }

        return $sort;
    }

    /**
     *
     * @param string $sort
     * @return static
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return bool false ASC, true DESC
     */
    public function getFirstDirection()
    {
        if (substr($this->getSort(), 0, 1) === '-') {
            return true;
        }
        return false;
    }

    public function setDefaultSort($sort)
    {
        $this->defaultSort = $sort;
        return $this;
    }

    public function getDefaultSort()
    {
        return $this->defaultSort;
    }

    public function initLinkGenerator(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * Zwraca link z usuniętymi $queryParams
     * @param array $queryParams
     * @return string
     * @smarty
     */
    public function getUrlWithoutParams(array $queryParams)
    {
        $queryParams = array_diff_key($this->queryParams, array_flip($queryParams));

        return '?' . http_build_query($queryParams);
    }

    /**
     * Zwraca link z parametrami zastąpionymi przez $queryParams
     * @param array $queryParams
     * @return string
     */
    public function getUrlWithParams(array $queryParams)
    {
        $queryParams = array_replace($this->queryParams, $queryParams);

        return '?' . http_build_query($queryParams);
    }

    /**
     * @param $pageNumber
     * @return string
     * @noinspection PhpUnused @smarty
     */
    public function getUrlForPageNumber($pageNumber)
    {
        if ($pageNumber < 1) {
            $pageNumber = 1;
        } elseif ($pageNumber > ($pages = $this->getPages())) {
            $pageNumber = $pages;
        }

        return $this->getUrlWithParams([self::KEY_PAGE_NUMBER => $pageNumber]);
    }

}
