<?php
/**
 * Default settings for the iphelper plugin 
 *
 * @author An-dir <1.c-j@gmx.de>
 */

$conf['subnetcalculatortarget']    = '_blank';
$conf['subnetcalculator']    = 'https://www.tunnelsup.com/subnet-calculator/?ip=%ip%';
$conf['tool1urltarget']    = '_self';
$conf['tool1name']    = 'RDP starten (erfordert Windows mit Anpassungen)';
$conf['tool1url']    = 'rdp:%ip%';
$conf['tool2urltarget']    = '_blank';
$conf['tool2name']    = 'https://%ip%:4444';
$conf['tool2url']    = 'https://%ip%:4444';
$conf['tool3urltarget']    = '_self';
$conf['tool3name']    = 'Ping (erfordert Windows mit Anpassungen)';
$conf['tool3url']    = 'ping:%ip%';
$conf['tool4urltarget']    = '_blank';
$conf['tool4name']    = 'Ping (Ping.eu)';
$conf['tool4url']    = 'http://ping.eu/ping/?host=%ip%';
$conf['tool5urltarget']    = '_blank';
$conf['tool5name']    = 'Robtex IP Lookup';
$conf['tool5url']    = 'https://www.robtex.com/ip-lookup/%ip%';
$conf['tool6urltarget']    = '_blank';
$conf['tool6name']    = 'Google Search';
$conf['tool6url']    = 'https://www.google.de/?q=%ip%';
$conf['tool7urltarget']    = '_blank';
$conf['tool7name']    = 'http://%ip%';
$conf['tool7url']    = 'http://%ip%';
$conf['tool8urltarget']    = '_blank';
$conf['tool8name']    = 'https://%ip%';
$conf['tool8url']    = 'https://%ip%';
$conf['tool9urltarget']    = '_blank';
$conf['tool9name']    = 'ftp://%ip%';
$conf['tool9url']    = 'ftp://%ip%';
$conf['tool10urltarget']    = '_blank';
$conf['tool10name']    = 'ssh://%ip% (erfordert Windows mit Anpassungen)';
$conf['tool10url']    = 'ssh://%ip%';
$conf['rawtools']    = '<a href="https://whois.domaintools.com/%ip%" target="_blank">whois.domaintools.com/%ip%</a><br>
<a href="https://www.shodan.io/search?query=%ip%" target="_blank">https://www.shodan.io/search?query=%ip%</a><br>

<a href="https://mxtoolbox.com/SuperTool.aspx?action=blacklist%3a%ip%&run=toolpage" target="_blank">https://mxtoolbox.com/SuperTool.aspx?action=blacklist%3a%ip%&run=toolpage</a><br>
';
