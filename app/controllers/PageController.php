<?php
namespace App\Controllers;

class PageController
{
    public function index ()
    {
        require __DIR__.'/../../dist/index.html';
    }
}