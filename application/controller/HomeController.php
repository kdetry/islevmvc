<?php

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $document = new Document();
        $document->setTitle('Hello Title');
        $document->setDescription('This is Hello description');

        $headerController = new HeaderController();
        $header = $headerController->getHeader();

        $data = array(
            'header' => $header,
            'content' => 'Hello HomeController !'
        );

        $response = new Response();
        $response->setOutput($response->view('homeView.php', $data));
        $response->output();
    }
}