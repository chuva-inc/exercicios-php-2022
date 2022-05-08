<?php

namespace Galoa\ExerciciosPhp2022\WebScrapping;

/**
 * Does the scrapping of a webpage.
 */
class Scrapper {

  /**
   * Loads paper information from the HTML and creates a XLSX file.
   */
  public function scrap(\DOMDocument $dom): void {
    $links = $dom->getElementsByTagName('a');
    $i = 0;
    print "----------------------------------------------------------------------------------------------------------------\n";
    foreach ($links as $link) {
      $i++;
      if ($link->getElementsByTagName('h4')->length != 0) {
        $title = $link->getElementsByTagName('h4')->item(0)->nodeValue; 
        $divs = $link->getElementsByTagName('div');
        foreach ($divs as $div) {
          if ($div->getAttribute('class') == 'volume-info') {$id = $div->nodeValue;}
          if ($div->getAttribute('class') == 'tags mr-sm') {$type = $div->nodeValue;}
          if ($div->getAttribute('class') == 'authors') {
            $authors = [];
            foreach ($div->getElementsByTagName('span') as $author) {
              $authors[] = [preg_replace('/;*/', '', $author->nodeValue), $author->getAttribute('title')];
            }
          }
        }
        print "Artigo $i\n";
        print "ID: $id\n";
        print "Título: $title\n";
        print "Tipo: $type\n";
        print "Autores - ".count($authors)." \n";
        foreach ($authors as $author) {
          print "    Nome: $author[0]\n";
          print "    Instituição: $author[1]\n";
        }
        print "----------------------------------------------------------------------------------------------------------------\n";
      }
    }
    // print $dom->saveHTML();
  }

}
