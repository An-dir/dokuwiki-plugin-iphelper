<?php
/**
 * iphelper Plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     An-Dir <1.c-j@gmx.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'action.php');

class action_plugin_iphelper extends DokuWiki_Action_Plugin {

    function register(Doku_Event_Handler $controller) {
        $controller->register_hook('TPL_CONTENT_DISPLAY', 'BEFORE', $this, 'handle_content_display', array());
    }

    function handle_content_display(&$event, $param) {
		
		            $subnetcalculator = $this->getConf('subnetcalculator');
		            $subnetcalculatortarget = $this->getConf('subnetcalculatortarget');
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
                    $rawtools = $this->getConf('rawtools');
                    
		
                    if (strlen($tool1name) > 1) {$tool1url = $this->getConf('tool1url');$tool1urltarget = $this->getConf('tool1urltarget'); $tool1html = "<a href=\"". $tool1url ."\" target=\"". $tool1urltarget ."\">" . $tool1name . "</a><br>";}
                    if (strlen($tool2name) > 1) {$tool2url = $this->getConf('tool2url');$tool2urltarget = $this->getConf('tool2urltarget'); $tool2html = "<a href=\"". $tool2url ."\" target=\"". $tool2urltarget ."\">" . $tool2name . "</a><br>";}
                    if (strlen($tool3name) > 1) {$tool3url = $this->getConf('tool3url');$tool3urltarget = $this->getConf('tool3urltarget'); $tool3html = "<a href=\"". $tool3url ."\" target=\"". $tool3urltarget ."\">" . $tool3name . "</a><br>";}
                    if (strlen($tool4name) > 1) {$tool4url = $this->getConf('tool4url');$tool4urltarget = $this->getConf('tool4urltarget'); $tool4html = "<a href=\"". $tool4url ."\" target=\"". $tool4urltarget ."\">" . $tool4name . "</a><br>";}
                    if (strlen($tool5name) > 1) {$tool5url = $this->getConf('tool5url');$tool5urltarget = $this->getConf('tool5urltarget'); $tool5html = "<a href=\"". $tool5url ."\" target=\"". $tool5urltarget ."\">" . $tool5name . "</a><br>";}
                    if (strlen($tool6name) > 1) {$tool6url = $this->getConf('tool6url');$tool6urltarget = $this->getConf('tool6urltarget'); $tool6html = "<a href=\"". $tool6url ."\" target=\"". $tool6urltarget ."\">" . $tool6name . "</a><br>";}
                    if (strlen($tool7name) > 1) {$tool7url = $this->getConf('tool7url');$tool7urltarget = $this->getConf('tool7urltarget'); $tool7html = "<a href=\"". $tool7url ."\" target=\"". $tool7urltarget ."\">" . $tool7name . "</a><br>";}
                    if (strlen($tool8name) > 1) {$tool8url = $this->getConf('tool8url');$tool8urltarget = $this->getConf('tool8urltarget'); $tool8html = "<a href=\"". $tool8url ."\" target=\"". $tool8urltarget ."\">" . $tool8name . "</a><br>";}
                    if (strlen($tool9name) > 1) {$tool9url = $this->getConf('tool9url');$tool9urltarget = $this->getConf('tool9urltarget'); $tool9html = "<a href=\"". $tool9url ."\" target=\"". $tool9urltarget ."\">" . $tool9name . "</a><br>";}
                    if (strlen($tool10name) > 1) {$tool10url = $this->getConf('tool10url');$tool10urltarget = $this->getConf('tool10urltarget'); $tool10html = "<a href=\"". $tool10url ."\" target=\"". $tool10urltarget ."\">" . $tool10name . "</a><br>";} 
					
                    $iphelperbase = "" . $tool1html . $tool2html . $tool3html . $tool4html . $tool5html . $tool6html . $tool7html . $tool8html . $tool9html . $tool10html . $rawtools;


		
		
            $event->data .= <<<TEXT
<!-- The iphelper Template -->
<div style="display: none;" id="iphelpertemplate">$iphelperbase</div>
<div style="display: none;" id="iphelpertemplatemask"><a href="$subnetcalculator" target="$subnetcalculatortarget">Start SubnetCalc ($subnetcalculator)</a></div>
<!-- The iphelper -->
<div id="myiphelper" class="myiphelper">

  <!-- iphelper content -->
  <div class="iphelper-content">
    <div class="iphelper-header" style="font-size: 28px;">
      <span class="iphelperclose">&times;</span>
      iphelper toolbox <input type="text" id="iphelperinput"></input>
    </div>
    <div class="iphelper-body">
      <p id="iphelperbodyp">you see this when javscript or css is not working correct</p>
	  <p id="iphelpersubnetcalc">
																				
<div class="section" id="calc">
<div class="input" style="display:none;">
<h2>Input</h2>
<form name="input" action="post">
IP-Address:<input type="text" id="iphelpersubnetcalcinput" name="in_address" value="127.0.0.1" onkeyup="ipChange()" />
Subnet:<input type="text" id="iphelpersubnetcalcsubnetinput" name="in_subnet" value="255.0.0.0" onkeyup="subChange()" />
</form>
</div>
<div class="output">
<div id='is_valid' class='is_valid' style="background-color:#E6E6FA">Untested</div>
<form name="output" action="post">
IP Address:
<span id="out_address"></span><br>
First usable:
<span id="out_firstusable"></span><br>
Subnet:
<span id="out_subnet"></span><br>
Last usable:
<span id="out_lastusable"></span><br>
CIDR:
<span id="out_cidr"></span><br>
Amount of usable:
<span id="out_amountaddresses"></span><br>
Network address:
<span id="out_netaddr"></span><br>
Reverse address:
<span id="out_ptraddr"></span><br>
Broadcast address:
<span id="out_bcast"></span><br>
</form>
</div>
</div>

</p>
    </div>
    <div class="iphelper-footer">
      <h3 id="iphelperfooter">&nbsp;</h3>
    </div>
  </div>

</div>

TEXT;
    }

}
