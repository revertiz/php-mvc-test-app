<?php

namespace Kodas\Core;



class Controller
{
    protected $view;
    protected $model;

    public function view($viewName, $data = [])
    {
        $this->view = new View($viewName, $data);
        return $this->view;
    }

    public function model($modelName, $data = [])
    {

        $container = new Container();
        $container->set(
            'TimeManager',
            function() {
                return new \Kodas\Model\TimeManager();
            }
        )
            ->set(
                'Client',
                function(Container $container) {
                    return new \Kodas\Model\Client($container->get('TimeManager'));
                }

            )
            ->set(
                'Specialist',
                function(Container $container) {
                    return new \Kodas\Model\Specialist($container->get('TimeManager'));
                }
            );

        $modelName1 = '\Kodas\Model\\' . $modelName;
//        preg_replace('/(^[\"\']|[\"\']$)/', '', $modelName);
        if (class_exists($modelName1)) {
//            $this->model = $container->get($modelName);
            $this->model = new $modelName1;
        }
    }

}

