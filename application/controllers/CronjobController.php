<?php

class CronjobController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $articleDb  = new Application_Model_DbTable_Articles();
        $movieDb    = new Application_Model_DbTable_Movies();
        $gameDb     = new Application_Model_DbTable_Games();

        $articleId  = $articleDb->getOnlyId();
        $movieId    = $movieDb->getOnlyId();
        $gameId     = $gameDb->getOnlyId();

        $fp = fopen("./sitemap.xml", "w+");

        $xml_structure = '<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<url>
  <loc>http://force-leads.com/</loc>
</url>
<url>
  <loc>http://force-leads.com/movie</loc>
</url>
<url>
  <loc>http://force-leads.com/games</loc>
</url>' . chr(13).chr(10);

        $text = fwrite($fp, $xml_structure);

        foreach ($articleId as $id) {
            $array[] = $id;
            $counter = count($array);
        }

        $pages = ceil($counter / 5);

        for ($i = 0; $i < $pages; $i++){

            $page = $i + 1;

            $xml_structure = '<url>
  <loc>http://force-leads.com/page/' . $page .'</loc>
</url>';

            $text = fwrite($fp, $xml_structure .chr(13).chr(10));
        }

        foreach ($articleId as $id) {
            $xml_structure = '<url>
  <loc>http://force-leads.com/article/id/' . $id['id'] .'</loc>
</url>';
            $text = fwrite($fp, $xml_structure .chr(13).chr(10));
        }

        $text = fwrite($fp, '</urlset>');

        if ($text) echo '<div class="help-block alert-success">File sitemap.xml was successfully generated.</div>';
        else echo '<div class="help-block alert-danger">File sitemap.xml was not generated, <b>error</b>.</div>';
        fclose($fp);

    }

}

