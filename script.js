
function iphelper(value) {
	var boxalreadythere = document.getElementById("demo");
	if (boxalreadythere) {
			if (value == 'hide') {document.getElementById('demo').style.display = 'none';}
			if (value == 'show') {document.getElementById('demo').style.display = 'inline';}

	} else {
		var box = document.createElement('div');
		box.style.position = 'absolute';
		box.style.top = '0px';
		box.style.left = '0px';
		box.style.width = '90%';
		box.style.height = '90%';
		box.style.color = 'black';
		box.style.background = 'lightblue';
		box.style.padding = '20px';
		box.innerText = value;
		box.id = 'demo';
		document.body.appendChild(box);
		document.getElementById('demo').innerHTML =  value;

	}
}


