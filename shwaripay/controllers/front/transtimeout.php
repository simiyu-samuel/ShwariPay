<?php

class ShwaripayTransresultModuleFrontController extends ModuleFrontController
{
    public function postProcess()
    {
        $rawData = file_get_contents('php://input');

        $data = json_decode($rawData, true);
        print_r($data);
    }
}