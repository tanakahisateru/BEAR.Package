<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Package\Module\Database\Dbal;

use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\View\ViewInterface;

/**
 * Paging query
 */
class Pager
{
    /**
     * @var \Doctrine\Dbal\Connection
     */
    protected $db;

    /**
     * Max per page
     *
     * @var int
     */
    protected $maxPerPage = 10;

    /**
     * Page key
     *
     * @var string
     */
    protected $pageKey = '_start';

    /**
     * View options
     *
     * @var array
     */
    protected $viewOptions = [
        'prev_message' => '&laquo;',
        'next_message' => '&raquo;'
    ];

    private $view;

    private $pager = [];

    private $currentPage;

    private $routeGenerator;

    /**
     * Constructor
     *
     * @param DriverConnection $db
     * @param Pagerfanta       $pagerfanta
     */
    public function __construct(DriverConnection $db, Pagerfanta $pagerfanta)
    {
        $this->db = $db;

        $currentPage = $this->currentPage ? : (isset($_GET[$this->pageKey]) ? $_GET[$this->pageKey] : 1);
        $this->firstResult = ($currentPage - 1) * $this->maxPerPage;
        $pagerfanta->setMaxPerPage($this->maxPerPage);
        $pagerfanta->setCurrentPage($currentPage, false, true);
        //view
        $this->pager = [
            'maxPerPage' => $this->maxPerPage,
            'current' => $currentPage,
            'total' => $pagerfanta->getNbResults(),
            'hasNext' => $pagerfanta->hasNextPage(),
            'hasPrevious' => $pagerfanta->hasPreviousPage(),
            'html' => $this->getHtml($pagerfanta)
        ];
    }

    /**
     * Return paging html
     *
     * @param \Pagerfanta\Pagerfanta $pagerfanta
     *
     * @return string
     */
    private function getHtml(Pagerfanta $pagerfanta)
    {
        $view = $this->view ? : new TwitterBootstrapView;
        $routeGenerator = $this->routeGenerator ? : function ($page) {
            return "?{$this->pageKey}={$page}";
        };
        $html = $view->render(
            $pagerfanta,
            $routeGenerator,
            $this->viewOptions
        );

        return $html;
    }

    /**
     * @param $maxPerPage
     *
     * @return Pager
     */
    public function setMaxPerPage($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;

        return $this;
    }

    /**
     * @param $pageKey
     *
     * @return Pager
     */
    public function setPageKey($pageKey)
    {
        $this->pageKey = $pageKey;

        return $this;
    }

    /**
     * @param $currentPage
     *
     * @return Pager
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @param \Pagerfanta\View\ViewInterface $view
     *
     * @return Pager
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param $routeGenerator
     *
     * @return Pager
     */
    public function setRouteGenerator(callable $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return Pager
     */
    public function setViewOption($key, $value)
    {
        $this->viewOptions[$key] = $value;

        return $this;
    }

    /**
     * Return pagered query result
     *
     * @param $query
     *
     * @return mixed
     */
    public function getPagerQuery($query)
    {
        $pagerQuery = $this->db->getDatabasePlatform()->modifyLimitQuery($query, $this->maxPerPage, $this->firstResult);

        return $pagerQuery;
    }
}
