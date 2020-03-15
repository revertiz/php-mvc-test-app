<?php declare(strict_types = 1);


namespace Kodas\Controller;


use Kodas\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
//        $this->model('TimeManager');
//        $result = $this->model->getCountBySpecialist(1);

        $this->model('Client');
        $users = $this->model->getWaitTimes();

        $this->view('home/index');


        $this->view->render();
    }

}
