<?php

/**
 * Class Paginator manipulates page records
 */
class Paginator {

    public $limit;
    public $offset;
    public $previous;
    public $next;

    /**
     * Paginator constructor.
     * @param $page
     * @param $records_per_page
     *
     * calculates limit and offset based on page number
     */
    public function __construct($page, $records_per_page) {

        $this->limit = $records_per_page;

        //using the associative array in the accepted options argument, the default pg is set to 1 if input is non numeric
        $page = filter_var($page, FILTER_VALIDATE_INT, ["options" => ["default" => 1, "min_range" => 1]] );

        if ($page > 1) {
            $this->previous = $page - 1;
        }
        $this->next = $page + 1;

        //offset for sql option, where it skips starting point for next articles dependent on page num
        $this->offset = $records_per_page * ($page - 1);
    }
}