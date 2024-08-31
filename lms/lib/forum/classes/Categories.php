<?php
require_once 'Topics.php';
class Categories extends Topics
{
    protected $db;
    protected $table_name = "community_post_categories";
    protected $lastError;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
