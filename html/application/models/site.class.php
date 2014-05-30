<?php
/**
 * A models file for the DND Helper that defines and handles functions related
 * to constructing generic HTML for the application views
 * @author 130680
 * @created 2014-05-25
 */
if(!class_exists('Site')) {

  class Site {

    /**
     * A function to build the doctype; head, including style and script entries; title;
     * body id; header, including navigation and sub-navigation entries
     * @param $page_id string - the body id of the page
     * @param $title string - the title of the page
     * @param $nav_entries array - array holding the nav entries for the page sub navigation
     * @return $html string - a HTML representation of the page head, title, body id, and header
     */
    public function buildHeader($page_id, $title, $nav_entries) {
      $nav = '';

      if((strtolower($page_id) != 'index') && (strtolower($page_id) != 'register') && (strtolower($page_id) != 'about')) {
	$nav = $this->buildNav($nav_entries);
      }

      $html = '';
      
      $html .= '<!DOCTYPE html>' . "\n";
      $html .= '<html lang="en">' . "\n";
      $html .= '  <head>' . "\n";
      $html .= '    <meta charset="UTF-8">' . "\n";
      $html .= '    <meta name="viewport" content="width=device-width, user-scalable=yes">' . "\n";
      $html .= '      <link rel="stylesheet" href="../../public/css/main.css"/>' . "\n";
      $html .= '      <link rel="stylesheet" href="../../public/css/' . $page_id . '.css"/>' . "\n";
      $html .= '      <link rel="stylesheet" href="../../public/css/navigation.css"/>' . "\n";
      $html .= '      <script type="text/javascript" src="../../public/js/' . $page_id . '.js"></script>' . "\n";
      $html .= '    <title>' . $title . '</title>' . "\n";
      $html .= '  </head>' . "\n";
      $html .= '  <body id="' . $page_id . '">' . "\n";
      
      if((strtolower($page_id) != 'index') && (strtolower($page_id) != 'register') && (strtolower($page_id) != 'about')) {
	$html .= '    <header>' . "\n";
	$html .= '      <div id="logged-user">' . "\n";
	$html .= '        <p>Logged in as <span>' . $_SESSION['username'] . '</span></p>' . "\n";
	$html .= '      </div> <!-- end #logged-user -->' . "\n";
	$html .= $nav;
	$html .= '    </header>' . "\n";
      }

      return $html;
    }

    /**
     * A function to build the navigation with sub-navigation
     * @param $entries array - assoc array holding the sub-navigation entries as path => label
     * @return $nav string - a HTML representation of the nav element
     */
    public function buildNav($entries) {
      $nav = '';
      
      $nav .= '      <nav>' . "\n";
      $nav .= '        <ul>' . "\n";
      $nav .= '          <li class="main-nav-entry"><a href="member.php"><img src="../../public/images/home_icon32px.jpg" alt="home icon"></a></li>' . "\n";
      $nav .= '          <li class="main-nav-entry"><a href="characters.php"><img src="../../public/images/npc_icon32px.jpg" alt="characters icon"></a></li>' . "\n";
      $nav .= '          <li class="main-nav-entry"><a href="gamemasters.php"><img src="../../public/images/gamemaster_icon32px.jpg" alt="gamemasters icon"></a></li>' . "\n";
      $nav .= '          <li id="sub-nav-init"><img src="../../public/images/menu_icon_32px.jpg" alt="sub nav icon"></li>' . "\n";
      $nav .= '        </ul>' . "\n";
      $nav .= '      </nav>' . "\n";
      $nav .= '      <div id="sub-nav-wrapper">' . "\n";
      $nav .= '        <ul>' . "\n";
      
      foreach($entries as $key => $val) {
	$nav .= '          <li><a href="' . $key . '">' . $val . '</a></li>' . "\n";
      }

      $nav .= '        </ul>' . "\n";
      $nav .= '      </div> <!-- end #sub-nav-wrapper -->' . "\n";

      return $nav;
    }

  }

}

?>