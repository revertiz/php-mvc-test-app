<?php declare(strict_types = 1);


namespace Kodas\Controller;

use Kodas\Core\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $this->model('Client');
        $clients = $this->model->getAllUnservicedClients();
//nu jei kur DI containeri daryt tai cia

        $this->model('Specialist');
        $specialists = $this->model->getAllSpecialists();

        $this->view('clients' . DIRECTORY_SEPARATOR . 'clients', [$clients, $specialists]);
        $this->view->render();

        if (isset($_GET['sortbyid'])) {
            echo 'sort sort sort';
        }
    }

    public function register()
    {
        if (empty($_POST['user_name']) & empty($_POST['specialist_id'])) {
            $this->view('clients' . DIRECTORY_SEPARATOR . 'register');
            $this->view->render();
        } elseif (isset($_POST['user_name'], $_POST['specialist_id'])) {
            $username = $_POST['user_name'];
            $specialist = $_POST['specialist_id'];
            $this->model('Client');
            $this->model->registerClient($username, $specialist);
            $this->view('clients' . DIRECTORY_SEPARATOR . 'register', ['message' => 'sekmingai uzsiregistravote']);
            $this->view->render();
        } else {
            $this->view('clients' . DIRECTORY_SEPARATOR . 'register', ['message' => 'ivyko klaida, susisiekite telefonu']);
            $this->view->render();
        }

    }

    public function clientpage()
    {

        $this->model('Client');
        if (isset($_GET['id'])) {
            $client = $this->model->getClientById($_GET['id']);
        }
        if (isset($_POST['delete'])) {
            $this->model->deleteClientbyId($_GET['id']);
            $this->register();
            exit();
        }
        $this->view('clients' . DIRECTORY_SEPARATOR . 'clientpage', [
            'client' => $client
        ]);
        $this->view->render();

    }


}
