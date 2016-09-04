<?php

class HeaderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHeader()
    {
        $document = new Document;
        $data['meta_title'] = $document->getTitle();
        $data['meta_description'] = $document->getDescription();

        $response = new Response();
        $header = $response->view('headerView.php', $data);
        return $header;
    }
}