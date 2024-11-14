<?php


namespace XponLmsPlugin\Controller\Page;


use InvalidArgumentException;
use RuntimeException;
use SmartyException;
use xajaxResponse;
use XponLmsPlugin\Controller\AbstractController;
use XponLmsPlugin\Exception\KeyNotSetException;
use XponLmsPlugin\Lib\Page;
use XponLmsPlugin\Lib\Pager;
use XponLmsPlugin\Lib\XponApiHelper;
use XponLmsPlugin\XponLmsPlugin;

abstract class AbstractPageController extends AbstractController
{
    /** @var Page */
    protected $page;

    /**
     * AbstractPageController constructor.
     * @param XponLmsPlugin $xponLmsPlugin
     * @param Page $page
     * @throws InvalidArgumentException
     */
    public function __construct(XponLmsPlugin $xponLmsPlugin, Page $page)
    {
        parent::__construct($xponLmsPlugin);

        $this->setPage($page);
    }

    /**
     * @return Page
     * @throws KeyNotSetException
     */
    public function getPage()
    {
        if ($this->page === null) {
            throw new KeyNotSetException("page === null");
        }

        return $this->page;
    }

    /**
     * @param Page $page
     * @return static
     */
    public function setPage(Page $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @retun void
     * @throws RuntimeException
     * @throws SmartyException
     * @throws KeyNotSetException
     */
    public function show()
    {
        $page = $this->getPage();

        $this->userShow();

        if (!$page->getTemplate()) {
            throw new RuntimeException("page display error - template file missing");
        }

        $page->display();
    }

    /**
     * @return Pager
     * @throws KeyNotSetException
     */
    protected function createAndSetPagerFromQuery()
    {
        $pager = new Pager();

        if (array_key_exists(XponApiHelper::KEY_SORT, $_GET)) {
            $pager->setSort($_GET[XponApiHelper::KEY_SORT]);
        }

        $pager->initLinkGenerator($_GET);

        if (array_key_exists(Pager::KEY_PAGE_NUMBER, $_GET)) {
            $pager->setPageNumber(intval($_GET[Pager::KEY_PAGE_NUMBER]));
        }

        $this->getPage()->setPager($pager);

        return $pager;
    }

    /**
     * @return void
     */
    public function userRegisterXajax()
    {
    }

    /**
     * @return void
     */
    abstract protected function userShow();
}
