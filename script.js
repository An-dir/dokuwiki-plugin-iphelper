/*global document: false */
/*jslint browser:true */
"use strict";
// Get the iphelper
var iphelper = document.getElementById("myiphelper");
var iphelpersubnetcalc = document.getElementById("calc");

// Get the <span> element that closes the iphelper
var span = document.getElementsByClassName("iphelperclose")[0];

// When the user clicks on <span> (x), close the iphelper
span.onclick = function () {
    iphelper.style.display = "none";
};

// When the user clicks anywhere outside of the iphelper, close it
window.onclick = function(event) {
    if (event.target == iphelper) {
        iphelper.style.display = "none";
    }
};






jQuery(".iphelper").click(function() {
iphelper.style.display = "block";
var iphelperaddress = jQuery(this).text();
document.getElementById("iphelperinput").value = iphelperaddress;
if (iphelperaddress.search("/") != -1) {
    iphelpersubnetcalc.style.display = "block";
	document.getElementById("iphelpersubnetcalcsubnetinput").value = "";
	document.getElementById("iphelpersubnetcalcinput").value = iphelperaddress;
	var iphelperaddressright = iphelperaddress.split("/")[1];
	if (iphelperaddressright == "1" || iphelperaddressright == "2" || iphelperaddressright == "3" || iphelperaddressright == "4" || iphelperaddressright == "5" || iphelperaddressright == "6" || iphelperaddressright == "7" || iphelperaddressright == "8" || iphelperaddressright == "9" || iphelperaddressright == "10" || iphelperaddressright == "11" || iphelperaddressright == "12" || iphelperaddressright == "13" || iphelperaddressright == "14" || iphelperaddressright == "15" || iphelperaddressright == "16" || iphelperaddressright == "17" || iphelperaddressright == "18" || iphelperaddressright == "19" || iphelperaddressright == "20" || iphelperaddressright == "21" || iphelperaddressright == "22" || iphelperaddressright == "23" || iphelperaddressright == "24" || iphelperaddressright == "25" || iphelperaddressright == "26" || iphelperaddressright == "26" || iphelperaddressright == "27" || iphelperaddressright == "28" || iphelperaddressright == "29" || iphelperaddressright == "30" || iphelperaddressright == "31" || iphelperaddressright == "32") {
	} else {document.getElementById("iphelpersubnetcalcsubnetinput").value = iphelperaddressright;
		document.getElementById("iphelpersubnetcalcinput").value = iphelperaddress.split("/")[0];
		console.log('CIDR in input address is out of range');
	}
    document.getElementById("iphelperbodyp").innerHTML = document.getElementById("iphelpertemplatemask").innerHTML.replace(/\%ip\%/g, iphelperaddress);
	ipChange();
} else {
    iphelpersubnetcalc.style.display = "none";
    document.getElementById("iphelperbodyp").innerHTML = document.getElementById("iphelpertemplate").innerHTML.replace(/\%ip\%/g, iphelperaddress);
}
});



jQuery( "#iphelperinput" ).keyup(function() {
var iphelperaddress = document.getElementById("iphelperinput").value;
if (iphelperaddress.search("/") != -1) {
    iphelpersubnetcalc.style.display = "block";
	document.getElementById("iphelpersubnetcalcsubnetinput").value = "";
	document.getElementById("iphelpersubnetcalcinput").value = iphelperaddress;
	var iphelperaddressright = iphelperaddress.split("/")[1];
	if (iphelperaddressright == "1" || iphelperaddressright == "2" || iphelperaddressright == "3" || iphelperaddressright == "4" || iphelperaddressright == "5" || iphelperaddressright == "6" || iphelperaddressright == "7" || iphelperaddressright == "8" || iphelperaddressright == "9" || iphelperaddressright == "10" || iphelperaddressright == "11" || iphelperaddressright == "12" || iphelperaddressright == "13" || iphelperaddressright == "14" || iphelperaddressright == "15" || iphelperaddressright == "16" || iphelperaddressright == "17" || iphelperaddressright == "18" || iphelperaddressright == "19" || iphelperaddressright == "20" || iphelperaddressright == "21" || iphelperaddressright == "22" || iphelperaddressright == "23" || iphelperaddressright == "24" || iphelperaddressright == "25" || iphelperaddressright == "26" || iphelperaddressright == "26" || iphelperaddressright == "27" || iphelperaddressright == "28" || iphelperaddressright == "29" || iphelperaddressright == "30" || iphelperaddressright == "31" || iphelperaddressright == "32") {
		} else {
			document.getElementById("iphelpersubnetcalcsubnetinput").value = iphelperaddressright;
			document.getElementById("iphelpersubnetcalcinput").value = iphelperaddress.split("/")[0];
	}
    document.getElementById("iphelperbodyp").innerHTML = document.getElementById("iphelpertemplatemask").innerHTML.replace(/\%ip\%/g, iphelperaddress);
	ipChange();
} else {
    iphelpersubnetcalc.style.display = "none";
    document.getElementById("iphelperbodyp").innerHTML = document.getElementById("iphelpertemplate").innerHTML.replace(/\%ip\%/g, iphelperaddress);
}});




//Subnetcalc - written by Oscar Virot. All Rights reserved 2014
// https://google.com/+OscarVirot?rel=author 
// Source https://tools.virot.eu/ipcalc/

var cidrTosubnets = ["0.0.0.0", "128.0.0.0", "192.0.0.0", "224.0.0.0", "240.0.0.0", "248.0.0.0", "252.0.0.0", "254.0.0.0", "255.0.0.0", "255.128.0.0", "255.192.0.0", "255.224.0.0", "255.240.0.0", "255.248.0.0", "255.252.0.0", "255.254.0.0", "255.255.0.0", "255.255.128.0", "255.255.192.0", "255.255.224.0", "255.255.240.0", "255.255.248.0", "255.255.252.0", "255.255.254.0", "255.255.255.0", "255.255.255.128", "255.255.255.192", "255.255.255.224", "255.255.255.240", "255.255.255.248", "255.255.255.252", "255.255.255.254", "255.255.255.255"];
var ipPattern = "[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}";
var PatternAddr = "[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}";
var PatternSubnet = "[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}";
var PatternCidr = /10|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|1|2|3|4|5|6|7|8|9/;

turladdr=(document.URL).replace(/.*\/ipcalc\/(.*)\/.*/, '$1').replace(/#$/, '');
turlcidr=(document.URL).replace(/.*\/ipcalc\/.*\/(.*)/, '$1').replace(/#$/, '');
if (turladdr.match(PatternAddr) == turladdr && turlcidr.match(PatternCidr) == turlcidr)
  {
   tinSubnet = cidrTosubnets[(parseInt(turlcidr,10))];
   document.forms.input.in_address.value = turladdr;
   document.forms.input.in_subnet.value = tinSubnet;
   checkAndUpdate();
  }

function ipChange() {
  if (document.forms.input.in_address.value.indexOf('/') > -1)
    {
      var tcidr = (document.forms.input.in_address.value).substring(document.forms.input.in_address.value.indexOf('/') + 1);
      if (tcidr !== '' && isFinite(tcidr) && tcidr >= 0 && tcidr <= 32)
        {
          document.forms.input.in_subnet.value = cidrTosubnets[(parseInt(tcidr,10))];
//          document.getElementById('out_cidr').value = tcidr
//          document.getElementById('out_subnet').value = cidrTosubnets[tcidr]
        }
    }
  checkAndUpdate();
}

function subChange()
{
  if (document.forms.input.in_address.value.indexOf('/') > -1)
    {
      var address = (document.forms.input.in_address.value).substring(0,document.forms.input.in_address.value.indexOf('/'));
//Find the CIDR of the subnetmask
      var i;
      for (i = 0; i < cidrTosubnets.length; i++)
      {
        if (document.forms.input.in_subnet.value == cidrTosubnets[i]){var tcidr = i;}
      }
      if (tcidr !== '' && isFinite(tcidr) && tcidr >= 0 && tcidr <= 32)
      {
        document.forms.input.in_address.value = address+"/"+tcidr;
//      document.getElementById("out_cidr").innerHTML = tcidr
//      document.getElementById("out_subnet").innerHTML = cidrTosubnets[tcidr]
      }
    }
  checkAndUpdate();
}
function checkAndUpdate()
{
  if (checkValid())
  {
    UpdateOutput();
  }
  else
  {
    InvalidateOutput();
  }
}
function checkValid() {
//validate CIDR range
  if (document.forms.input.in_address.value.indexOf('/') > -1)
  {
    var tcidr = (document.forms.input.in_address.value).substring(document.forms.input.in_address.value.indexOf('/') + 1);
    if (tcidr === '' || isNaN(tcidr) || tcidr <= 0 || tcidr > 32
)
    {
      console.log('CIDR in input address is out of range');
      return false;
    }
  }
//validate address
  if (document.forms.input.in_address.value.indexOf('/') > -1)
  {
    var taddress = (document.forms.input.in_address.value).substring(0,document.forms.input.in_address.value.indexOf('/'));
  }
  else
  {
    var taddress = document.forms.input.in_address.value;
  }
 //format
  if (taddress.match(ipPattern) != taddress)
  {
    console.log('IP Address not formated x.x.x.x -> xxx.xxx.xxx.xxx');
    return false;
  }
 //nothing over 255
  var tbytes = taddress.split(".");
  var i;
    for (i = 0; i <= 3; i++)
    {
      if (tbytes[i]>=256)
      {
        console.log('IP address octect is larger than 255');
        return false;
      }
    }
//validate subnet
 //format
  if (document.forms.input.in_subnet.value.match(ipPattern) != document.forms.input.in_subnet.value)
  {
    console.log('Subnetmask not formated x.x.x.x -> xxx.xxx.xxx.xxx');
    return false;
  }
 //bit ordering
  for (i = 0; i < cidrTosubnets.length; i++)
  {
    if (document.forms.input.in_subnet.value == cidrTosubnets[i]){var tcidr = i;}
  }
  if (tcidr === '' || isNaN(tcidr))
  {
    console.log('Subnetmask improper ordering, not in order');
    return false;
  }
  return true;
}
function InvalidateOutput()
{
  document.getElementById("out_address").innerHTML = '';
  document.getElementById("out_subnet").innerHTML = '';
  document.getElementById("out_cidr").innerHTML = '';
  document.getElementById("out_netaddr").innerHTML = '';
  document.getElementById("out_bcast").innerHTML = '';
  document.getElementById("out_firstusable").innerHTML = '';
  document.getElementById("out_lastusable").innerHTML = '';
  document.getElementById("out_amountaddresses").innerHTML = '';
  document.getElementById("out_ptraddr").innerHTML = '';
  document.getElementById("is_valid").innerHTML = '<center>INVALID</center>';
  document.getElementById("is_valid").style.display = 'block';
  document.getElementById("is_valid").style.backgroundColor = "red";
}

function UpdateOutput()
{
// Update Valid text
  document.getElementById("is_valid").style.display = 'none';
  document.getElementById("is_valid").innerHTML = 'VALID VALID VALID VALID VALID';
  document.getElementById("is_valid").style.backgroundColor = "green";
// Locate Address
  if (document.forms.input.in_address.value.indexOf('/') > -1)
    {
      var taddress = (document.forms.input.in_address.value).substring(0,document.forms.input.in_address.value.indexOf('/'));
    }
  else
    {
      var taddress = document.forms.input.in_address.value;
    }
//Do subnet calc
  var i;
    for (i = 0; i < cidrTosubnets.length; i++)
    {
      if (document.forms.input.in_subnet.value == cidrTosubnets[i]){var tcidr = i;}
    }
//Calculate Network & Broadcast addresses
  var tabytes = taddress.split(".");
  var tsbytes = document.forms.input.in_subnet.value.split(".");
 //Network address
  var tnaddr = (tabytes[0] & tsbytes[0]) + "." + (tabytes[1] & tsbytes[1]) + "." + (tabytes[2] & tsbytes[2]) + "." + (tabytes[3] & tsbytes[3]);
 //Broadcast address
  var tbaddr = ((tabytes[0] & tsbytes[0]) | (255 ^ tsbytes[0])) + "." + ((tabytes[1] & tsbytes[1]) | (255 ^ tsbytes[1])) + "." + ((tabytes[2] & tsbytes[2]) | (255 ^ tsbytes[2])) + "." + ((tabytes[3] & tsbytes[3]) | (255 ^ tsbytes[3]));
 //Reverse PTR
  var tptraddr = (tabytes[3] + '.' + tabytes[2] + '.' + tabytes[1] + '.' + tabytes[0] + '.in-addr.arpa');
if (tcidr == 32)
{
 //gw1 address
  var tgw1 = tnaddr;
 //gw2 address
  var tgw2 = tnaddr;
 // Count usable addresses
 tusable = 1;
}
if (tcidr != 32)
{
 //gw1 address
  var tgw1 = (tabytes[0] & tsbytes[0]) + "." + (tabytes[1] & tsbytes[1]) + "." + (tabytes[2] & tsbytes[2]) + "." + ((tabytes[3] & tsbytes[3])+1);
 //gw2 address
  var tgw2 = ((tabytes[0] & tsbytes[0]) | (255 ^ tsbytes[0])) + "." + ((tabytes[1] & tsbytes[1]) | (255 ^ tsbytes[1])) + "." + ((tabytes[2] & tsbytes[2]) | (255 ^ tsbytes[2])) + "." + (((tabytes[3] & tsbytes[3]) | (255 ^ tsbytes[3]))-1);
 // Count usable addresses
 tusable = (Math.pow(2, (32-tcidr)))-2;
}

//Do real outputing
  document.getElementById("out_address").innerHTML = taddress;
  document.getElementById("out_subnet").innerHTML = document.forms.input.in_subnet.value;
  document.getElementById("out_cidr").innerHTML = tcidr;
  document.getElementById("out_netaddr").innerHTML = tnaddr;
  document.getElementById("out_bcast").innerHTML = tbaddr;
  document.getElementById("out_firstusable").innerHTML = tgw1;
  document.getElementById("out_lastusable").innerHTML = tgw2;
  document.getElementById("out_amountaddresses").innerHTML = tusable;
  document.getElementById("out_ptraddr").innerHTML = tptraddr;

}

function changeSection(Section)
{
  document.getElementById("static").className = 'hiddensection';
  document.getElementById("calc").className = 'hiddensection';
  document.getElementById("calcSelector").className = 'sectionselector';
  document.getElementById("staticSelector").className = 'sectionselector';

  if (Section=="calc")
  {
    document.getElementById("calc").className = 'section';
    document.getElementById("calcSelector").className = 'sectionselectoractive';
  }
  if (Section=="static")
  {
    document.getElementById("static").className = 'section';
    document.getElementById("staticSelector").className = 'sectionselectoractive';
  }
  if (Section=="IPv6Static")
  {
    document.getElementById("IPv6Static").className = 'hiddensection';
    document.getElementById("IPv6StaticSelector").className = 'sectionselector';
  }
}
