<?php


namespace Kodas\Core;


class View
{
    protected $viewFile;
    protected $viewData;
    protected $pageTitle;

    public function __construct($viewFile, $viewData)
    {
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
        $this->viewTitle = ucfirst((explode('/', $viewFile)[1]));
    }

    public function render()
    {
        if(file_exists(VIEW . $this->viewFile . '.php')) {
            include VIEW . $this->viewFile . '.php';
        }
    }

}
