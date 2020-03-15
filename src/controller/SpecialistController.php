<?php declare(strict_types = 1);


namespace Kodas\Controller;

use Kodas\Core\Controller;

class SpecialistController extends Controller
{
    public function index()
    {
        $this->model('Client');
        $clients = $this->model->getAllUnservicedClients();

        $this->model('Specialist');
        $specialists = $this->model->getAllSpecialists();

        $this->view('specialists' . DIRECTORY_SEPARATOR . 'specialistpage', [$specialists, $clients]);
        $this->view->render();

        if (isset($_POST['id'], $_POST['specialist_id'])) {
            $id = $_POST['id'];
            $specialistId = $_POST['specialist_id'];
            $this->model->serviceClientById($id, $specialistId);
        }
        if (isset($_GET['sortbyid'])) {
            echo 'sort sort sort';
        }
    }


}
