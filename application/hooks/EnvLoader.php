<?php
class EnvLoader{
    
    function initialize() {

        $dotenv = Dotenv\Dotenv::createImmutable(FCPATH);
        $dotenv->load();
    }
}