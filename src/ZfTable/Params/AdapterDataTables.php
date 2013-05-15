<?php

namespace ZfTable\Params;

use ZfTable\Params\AbstractAdapter;
use ZfTable\Params\AdapterInterface;
use ZfTable\Table\Exception;

class AdapterDataTables extends AbstractAdapter implements AdapterInterface
{

    /**
     *
     * @var \ArrayObject | \Zend\Stdlib\ArrayObject
     */
    protected $object;

    /**
     *
     * @var int
     */
    protected $page;

    /**
     *
     * @var string
     */
    protected $order;

    /**
     *
     * @var string 
     */
    protected $column;

    /**
     * 
     * @var int
     */
    protected $itemCountPerPage;

    /**
     * Quick search
     * @var string
     */
    protected $quickSearch;

    const DEFAULT_PAGE = 1;
    const DEFAULT_ORDER = 'asc';
    const DEFAULT_ITEM_COUNT_PER_PAGE = 2;

    public function __construct($object, $options)
    {
        if ($object instanceof \ArrayObject) {
            $this->object = $object;
        } else if ($object instanceof \Zend\Stdlib\ArrayObject) {
            $this->object = $object;
        } else {
            throw new Exception\InvalidArgumentException('parameter must be instance of ArrayObject');
        }
        $this->setOptions($options);
        $this->init();
    }

    /**
     * Init method
     */
    private function init()
    {
        $array = $this->object->toArray();
        $this->page = (isset($array['zfTablePage'])) ? $array['zfTablePage'] : self::DEFAULT_PAGE;
        $this->column = (isset($array['zfTableColumn'])) ? $array['zfTableColumn'] : null;
        $this->order = (isset($array['zfTableOrder'])) ? $array['zfTableOrder'] : self::DEFAULT_ORDER;
        $this->itemCountPerPage = (isset($array['zfTableItemPerPage'])) ? $array['zfTableItemPerPage'] : $this->getOptions()->getDefaultItemCountPerPage();
        $this->quickSearch = (isset($array['zfTableQuickSearch'])) ? $array['zfTableQuickSearch'] : '';
    }

    /**
     * Get page
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set page
     * @param string $page
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * Get order
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set asc or desc ordering
     * @param order $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get column
     * @return string
     */
    public function getColumn()
    {
        return ($this->column == '') ? null : $this->column;
    }

    /**
     * 
     * @param string $column
     * @return \ZfTable\Params\AdapterArrayObject
     */
    public function setColumn($column)
    {
        $this->column = $column;
        return $this;
    }

    /**
     * Get item count per page
     * @return int
     */
    public function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    /**
     * 
     * @param type $itemCountPerPage
     */
    public function setItemCountPerPage($itemCountPerPage)
    {
        $this->itemCountPerPage = $itemCountPerPage;
    }

    /**
     * Return offset
     * @return int
     */
    public function getOffset()
    {
        return ($this->getPage() * $this->getItemCountPerPage()) - $this->getItemCountPerPage();
    }

    /**
     * Get quickserach string
     * @return string
     */
    public function getQuickSearch()
    {
        return $this->quickSearch;
    }

}
