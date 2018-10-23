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
            'date'   => '2017-02-11',
            'name'   => 'iphelper plugin',
            'desc'   => 'Provides automatic links to mstsc and subnetcalulators, by searching the wikitext.',
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
//       $this->Lexer->addSpecialPattern('[sS][wW][0-9]+[pP][0-9]+', $mode, 'plugin_iphelper'); // For example 'SW1613p8' 
//      $this->Lexer->addSpecialPattern('(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)', $mode, 'plugin_iphelper'); // For example 'SW1613p8'
        $this->Lexer->addSpecialPattern('\d{1,}\.\d{1,3}\.\d{1,3}\.[0-9]{1,3}[/][​]{0,1}\d{1,}', $mode, 'plugin_iphelper'); // For example 'SW1613p8'
        $this->Lexer->addSpecialPattern('\d{1,}\.\d{1,3}\.\d{1,3}\.\d{1,}', $mode, 'plugin_iphelper'); // IP Adresse wird bewusst falsch gesucht, damit z.B. 1234.5.6.7 nicht als IP 234.5.6.7 erkannt wird, denn ohne 1 würde es die Bedingung erfüllen. Der Gefundene Ausdruck wird weiter unten nochmal geprüft ob er genau eine IP Adresse ist
// $Lexer->addEntryPattern('<nowiki>','base','unformatted');
// https://www.dokuwiki.org/devel:parser 
    }

    /**
     * Read the information from the matched wiki text
     */
    public function handle($match, $state, $pos, &$handler){
        $stripped = substr($match, 0); // Remove initial 'SW'
        $splitted = preg_split("/[\:]/", $stripped); // Split '1613p8' into '1613' and '8'.
        list($ip, $type) = $splitted;
		if(preg_match("[\/]",$match)) { $type = "cidr" ;} else { $type = "ip";};
        return array($ip, $type);
    }

    /**
     * Generate HTML output
     */
    public function render($mode, &$renderer, $data) {
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
                if (preg_match("/^(?:(?:25[0-4]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?(\/(3[0-2]|[1-2][0-9]|[0-9])))$/",$ip)) { # der string wurde angepasst, damit subnetmasken nicht gefunden werden (am anfang 0-4 anstelle von 0-5
                    $subnetcalculator = $this->getConf('subnetcalculator');
                    $subnetcalculatortarget = $this->getConf('subnetcalculatortarget');
                    
                    $url = $subnetcalculator . $ip;
                    
                    $renderer->doc .= "" . "<span style=\"cursor: pointer\" onclick=\"var win = window.open('https://www.tunnelsup.com/subnet-calculator/?ip=" . $ip . "', '" . $subnetcalculatortarget . "');win.focus();\" title=\"SubnetCalculator öffnen\">".$ip."</span>";
                } else {
                    $renderer->doc .= "" . $ip . "";
                }
            }
            if ($type == "ip") {
                if (preg_match("/^(?:(?:25[0-4]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/",$ip)) { # der string wurde angepasst, damit subnetmasken nicht gefunden werden (am anfang 0-4 anstelle von 0-5
                    $renderer->doc .= "" . "<span class=\"iphelper\">" . $ip . "</span>";
                } else {
                    $renderer->doc .= "".$ip."";
                }
            } 
		} 
        return true;
    }
}

// vim:ts=4:sw=4:et:
