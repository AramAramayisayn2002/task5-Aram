<?php

class Posts extends Database
{
    public function __construct()
    {
        $this->tableName = 'Posts';
        parent::__construct(SERVER_HOST, DB_NAME, SERVER_USERNAME, SERVER_PASSWORD);
    }
}