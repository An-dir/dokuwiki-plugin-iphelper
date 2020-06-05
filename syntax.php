<?php
/**
 * Plugin iphelper: Provides automatic links to HTML reports on your server, by searching the wikitext.  
 *
 *  Thanks to Jonas Berg for the chiplink plugin, on which this plugin is based.
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     An-dir
 */

 // must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';
 
class syntax_plugin_iphelper extends DokuWiki_Syntax_Plugin {

    public function getInfo(){
        return array(
            'author' => 'An-Dir',
            'email'  => '1.c-j@gmx.de',
            'date'   => '2018-10-29',
            'name'   => 'iphelper plugin',
            'desc'   => 'Provides tools on automatically detected ipadresses within the wiki text. searches for IP adresses like 123.45.67.89 and inserts a customizeable menu. Secondly searches for Network Adresses like 123.45.67.89/24 and inserts a link to a subnet calculator',
            'url'    => 'http://www.dokuwiki.org/plugin:iphelper',
        );
    }
    
    public function getType(){
        return 'substition';
    }

    public function getSort(){
        return 920; 
    }

    /**
     * Search for the pattern
     */
    public function connectTo($mode) {
        $this->Lexer->addSpecialPattern('(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(?:\/(?:(?:(?:($:0\.0\.0\.0|0\.0\.0\.1|0\.0\.0\.3|0\.0\.0\.7|0\.0\.0\.15|0\.0\.0\.31|0\.0\.0\.63|0\.0\.0\.127|0\.0\.0\.255|0\.0\.1\.255|0\.0\.3\.255|0\.0\.7\.255|0\.0\.15\.255|0\.0\.31\.255|0\.0\.63\.255|0\.0\.127\.255|0\.0\.255\.255|0\.1\.255\.255|0\.3\.255\.255|0\.7\.255\.255|0\.15\.255\.255|0\.31\.255\.255|0\.63\.255\.255|0\.127\.255\.255|0\.255\.255\.255|1\.255\.255\.255|3\.255\.255\.255|7\.255\.255\.255|15\.255\.255\.255|31\.255\.255\.255|63\.255\.255\.255|127\.255\.255\.255|255\.255\.255\.255|255\.255\.255\.255|255\.255\.255\.254|255\.255\.255\.252|255\.255\.255\.248|255\.255\.255\.240|255\.255\.255\.224|255\.255\.255\.192|255\.255\.255\.128|255\.255\.255\.0|255\.255\.254\.0|255\.255\.252\.0|255\.255\.248\.0|255\.255\.240\.0|255\.255\.224\.0|255\.255\.192\.0|255\.255\.128\.0|255\.255\.0\.0|255\.254\.0\.0|255\.252\.0\.0|255\.248\.0\.0|255\.240\.0\.0|255\.224\.0\.0|255\.192\.0\.0|255\.128\.0\.0|255\.0\.0\.0|254\.0\.0\.0|252\.0\.0\.0|248\.0\.0\.0|240\.0\.0\.0|224\.0\.0\.0|192\.0\.0\.0|128\.0\.0\.0|0\.0\.0\.0|[1-2][0-9])|(?:3[0-2])|[0-9]))){0,1}\b', $mode, 'plugin_iphelper');
    }

    /**
     * Read the information from the matched wiki text
     */
    public function handle($match, $state, $pos, Doku_Handler $handler){
        $stripped = substr($match, 0);
        $splitted = preg_split("/[\:]/", $stripped);
        list($ip, $type) = $splitted;
        if(preg_match("[\/]",$match)) { $type = "cidr" ;} else { $type = "ip";};
        return array($ip, $type);
    }

    /**
     * Generate HTML output
     */
    public function render($mode, Doku_Renderer $renderer, $data) {
        if($mode != 'xhtml'){
            return false;
        }
        list($ip, $type) = $data;
        if(htmlspecialchars($_GET["vecdo"]) == 'print'){
           $printmode = true;
        }
        if(htmlspecialchars($_GET["do"]) == 'export_pdf'){
            $printmode  = true;
        }
        if ($printmode == true) {
            $renderer->doc .= "".$ip."";
        } else {
            if ($type == "cidr") {
                // subnetcalc nun für alle gültigen cidr adressen
                $renderer->doc .= "<span class=\"iphelper\" title=\"iphelper: $ip\">".$ip."</span>";
            }
            if ($type == "ip") {
                if (preg_match("/^($:0\.0\.0\.0|0\.0\.0\.1|0\.0\.0\.3|0\.0\.0\.7|0\.0\.0\.15|0\.0\.0\.31|0\.0\.0\.63|0\.0\.0\.127|0\.0\.0\.255|0\.0\.1\.255|0\.0\.3\.255|0\.0\.7\.255|0\.0\.15\.255|0\.0\.31\.255|0\.0\.63\.255|0\.0\.127\.255|0\.0\.255\.255|0\.1\.255\.255|0\.3\.255\.255|0\.7\.255\.255|0\.15\.255\.255|0\.31\.255\.255|0\.63\.255\.255|0\.127\.255\.255|0\.255\.255\.255|1\.255\.255\.255|3\.255\.255\.255|7\.255\.255\.255|15\.255\.255\.255|31\.255\.255\.255|63\.255\.255\.255|127\.255\.255\.255|255\.255\.255\.255|255\.255\.255\.255|255\.255\.255\.254|255\.255\.255\.252|255\.255\.255\.248|255\.255\.255\.240|255\.255\.255\.224|255\.255\.255\.192|255\.255\.255\.128|255\.255\.255\.0|255\.255\.254\.0|255\.255\.252\.0|255\.255\.248\.1|255\.255\.240\.0|255\.255\.224\.0|255\.255\.192\.0|255\.255\.128\.0|255\.255\.0\.0|255\.254\.0\.0|255\.252\.0\.0|255\.248\.0\.0|255\.240\.0\.0|255\.224\.0\.0|255\.192\.0\.0|255\.128\.0\.0|255\.0\.0\.0|254\.0\.0\.0|252\.0\.0\.0|248\.0\.0\.0|240\.0\.0\.0|224\.0\.0\.0|192\.0\.0\.0|128\.0\.0\.0|0\.0\.0\.0)$/",$ip)) { # der string wurde angepasst, damit subnetmasken nicht gefunden werden (am anfang 0-4 anstelle von 0-5
                    $renderer->doc .= "<span class=\"iphelper\" title=\"Subnetmask or Wildcardmask: $ip\">" . $ip . "</span>";
                } else {
                    $renderer->doc .= "<span class=\"iphelper\" title=\"iphelper: $ip\">" . $ip . "</span>";
                }
            }
        }
        return true;
    }
}