<?php

/**
 * Class Paginator manipulates page records
 */
class Paginator {

    public $limit;
    public $offset;


    /**
     * Paginator constructor.
     * @param $page
     * @param $records_per_page
     *
     * calculates limit and offset based on page number
     */
    public function __construct($page, $records_per_page) {
        $this->limit = $records_per_page;
        $this->offset = $records_per_page * ($page - 1);
    }
}