//actors only need to validate names
function actor_validate(form) {
	var retVal = "";

	retVal += validate_name(form.actName.value);

	if(retVal == '') {
		return true;
	}
	
	alert(retVal);
	return false;
}

//for adding a movie, needs to validate all fields
function movie_validate(form) {
	var retVal = "";

	retVal += validate_title(form.movieName.value);
	retVal += validate_name(form.movieGenre.value);
	retVal += validate_name(form.actName.value);
	retVal += validate_not_null(form.movieYear.value);
	retVal += validate_not_null(form.moviePrice.value);

	if(retVal == '') {
		return true;
	}
	alert(retVal);
	return false;
}

//for searching and deleting a movie, only needs to validate title
function movie_title_validate(form) {
	var retVal = "";

	retVal += validate_title(form.movieName.value);

	if(retVal == '') {
		return true;
	}
	alert(retVal);
	return false;
}

//for when strings need to be alphanumeric only
function validate_name(field) {
	if(field == "") {
		return "No text entered\n";
	} else if(/[^a-zA-Z ]/.test(field) == true) {
		return "Invalid characters found - only alphanumeric are allowed\n";
	} 
	return "";
}

function validate_title(field) {
	if(field == "") {
		return "No text entered\n";
	} else if (/[^a-zA-Z0-9_:\- ]/.test(field) == true) {
		return "Invalid characters found - only alphanumeric are allowed\n";
	}
	return "";
}

//for when variables can be anything, just not null or zero
function validate_not_null(field) {
	if(field == "" || field == null) {
		return "No value entered\n";
	}
	return "";
}

//for opening outer tabs, also closes all other tabs and subtabs
function openTab(evt, name) {
	var i, tabcontent, tablinks;

	tabcontent = document.getElementsByClassName("tabcontent");
	for(i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	tablinks = document.getElementsByClassName("tablinks");
	for(i = 0; i < tablinks.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" active","");
	}

	subtablinks = document.getElementsByClassName("subTablinks");
	for(i = 0; i < subtablinks.length; i++) {
		subtablinks[i].className = subtablinks[i].className.replace(" active","");
	}

	subtabcontent = document.getElementsByClassName("subTabContent");
	for(i = 0; i < subtabcontent.length; i++) {
		subtabcontent[i].style.display = "none";
	}

	document.getElementById(name).style.display = "block";
	evt.currentTarget.className += " active";
}

//for opening inner tabs, closes other subtabs first
function openSubTab(evt, name) {
	var i, subtabcontent, subtablinks;

	subtabcontent = document.getElementsByClassName("subTabContent");
	for(i = 0; i < subtabcontent.length; i++) {
		subtabcontent[i].style.display = "none";
	}

	subtablinks = document.getElementsByClassName("subTablinks");
	for(i = 0; i < subtablinks.length; i++) {
		subtablinks[i].className = subtablinks[i].className.replace(" active","");
	}

	document.getElementById(name).style.display = "block";
	evt.currentTarget.className += " active";
}

//makes sure all content is hidden when loading the site
//only called for onload on body
function loadup() {
	var i, tabcontent, tablinks;

	tabcontent = document.getElementsByClassName("tabcontent");
	for(i = 0; i < tabcontent.length; i++) {
		tabcontent[i].style.display = "none";
	}

	subtabcontent = document.getElementsByClassName("subTabContent");
	for(i = 0; i < subtabcontent.length; i++) {
		subtabcontent[i].style.display = "none";
	}
}