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
                    $subnetcalculator = $this->getConf('subnetcalculator');
                    $tool1name = $this->getConf('tool1name');
                    $tool2name = $this->getConf('tool2name');
                    $tool3name = $this->getConf('tool3name');
                    $tool4name = $this->getConf('tool4name');
                    $tool5name = $this->getConf('tool5name');
                    $tool6name = $this->getConf('tool6name');
                    $tool7name = $this->getConf('tool7name');
                    $tool8name = $this->getConf('tool8name');
                    $tool9name = $this->getConf('tool9name');
                    $tool10name = $this->getConf('tool10name');
                    

                    if (strlen($tool1name) > 1) {$tool1url = $this->getConf('tool1url');$tool1urltarget = $this->getConf('tool1urltarget');$tool1url = str_ireplace("%ip%", $ip, $tool1url, $tool1replacecount); $tool1html = "<a href=\"". $tool1url ."\" target=\"". $tool1urltarget ."\">" . $tool1name . "</a><br>";}
                    if (strlen($tool2name) > 1) {$tool2url = $this->getConf('tool2url');$tool2urltarget = $this->getConf('tool2urltarget');$tool2url = str_ireplace("%ip%", $ip, $tool2url, $tool2replacecount); $tool2html = "<a href=\"". $tool2url ."\" target=\"". $tool2urltarget ."\">" . $tool2name . "</a><br>";}
                    if (strlen($tool3name) > 1) {$tool3url = $this->getConf('tool3url');$tool3urltarget = $this->getConf('tool3urltarget');$tool3url = str_ireplace("%ip%", $ip, $tool3url, $tool3replacecount); $tool3html = "<a href=\"". $tool3url ."\" target=\"". $tool3urltarget ."\">" . $tool3name . "</a><br>";}
                    if (strlen($tool4name) > 1) {$tool4url = $this->getConf('tool4url');$tool4urltarget = $this->getConf('tool4urltarget');$tool4url = str_ireplace("%ip%", $ip, $tool4url, $tool4replacecount); $tool4html = "<a href=\"". $tool4url ."\" target=\"". $tool4urltarget ."\">" . $tool4name . "</a><br>";}
                    if (strlen($tool5name) > 1) {$tool5url = $this->getConf('tool5url');$tool5urltarget = $this->getConf('tool5urltarget');$tool5url = str_ireplace("%ip%", $ip, $tool5url, $tool5replacecount); $tool5html = "<a href=\"". $tool5url ."\" target=\"". $tool5urltarget ."\">" . $tool5name . "</a><br>";}
                    if (strlen($tool6name) > 1) {$tool6url = $this->getConf('tool6url');$tool6urltarget = $this->getConf('tool6urltarget');$tool6url = str_ireplace("%ip%", $ip, $tool6url, $tool6replacecount); $tool6html = "<a href=\"". $tool6url ."\" target=\"". $tool6urltarget ."\">" . $tool6name . "</a><br>";}
                    if (strlen($tool7name) > 1) {$tool7url = $this->getConf('tool7url');$tool7urltarget = $this->getConf('tool7urltarget');$tool7url = str_ireplace("%ip%", $ip, $tool7url, $tool7replacecount); $tool7html = "<a href=\"". $tool7url ."\" target=\"". $tool7urltarget ."\">" . $tool7name . "</a><br>";}
                    if (strlen($tool8name) > 1) {$tool8url = $this->getConf('tool8url');$tool8urltarget = $this->getConf('tool8urltarget');$tool8url = str_ireplace("%ip%", $ip, $tool8url, $tool8replacecount); $tool8html = "<a href=\"". $tool8url ."\" target=\"". $tool8urltarget ."\">" . $tool8name . "</a><br>";}
                    if (strlen($tool9name) > 1) {$tool9url = $this->getConf('tool9url');$tool9urltarget = $this->getConf('tool9urltarget');$tool9url = str_ireplace("%ip%", $ip, $tool9url, $tool9replacecount); $tool9html = "<a href=\"". $tool9url ."\" target=\"". $tool9urltarget ."\">" . $tool9name . "</a><br>";}
                    if (strlen($tool10name) > 1) {$tool10url = $this->getConf('tool10url');$tool10urltarget = $this->getConf('tool10urltarget');$tool10url = str_ireplace("%ip%", $ip, $tool10url, $tool10replacecount); $tool10html = "<a href=\"". $tool10url ."\" target=\"". $tool10urltarget ."\">" . $tool10name . "</a><br>";}
                    $url = "rdp:" . $ip;
    //				$renderer->doc .= "" . "<div class=\"dropdown\"> <span style=\"cursor: pointer\" onclick=\"var win = window.open('" . $url . "', '_blank');win.focus();\" title=\"RDP öffnen\"><div class=\"dropdown\">  <span>" . $ip . "</span>  <div class=\"dropdown-content\" style =\"display: none;\">    <p>RDP</p>    <p>RDP (Console)</p>    <p>PING</p>    <p>Ping (Extern)</p>  </div></div></span></div>";
                    $renderer->doc .= "" . "<span class=\"tooltip\">" . $ip . "<span class=\"tooltiptext\"><b>IP/Netzwerk Werkzeuge</b><br><i>(%ip% = " . $ip . ")</i><br>" . $tool1html . $tool2html . $tool3html . $tool4html . $tool5html . $tool6html . $tool7html . $tool8html . $tool9html . $tool10html . "</span></span>";
                } else {
                    $renderer->doc .= "".$ip."";
                }
            } 
		} 
        return true;
    }
}

// vim:ts=4:sw=4:et:
