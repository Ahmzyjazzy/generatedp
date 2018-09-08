
/* global variables */
const button = document.querySelector(".create-dp");
const fileInput = document.querySelector("#file");
const preview = document.querySelector("img");
const changebtn = document.querySelector(".change");
const deletebtn = document.querySelector(".delete");
const fileInpbtn = document.querySelector(".fileinput-button");

/* create dp btn */
button.addEventListener("click", function(){

	let formData = new FormData();
	let file = document.querySelector('input[type=file]').files[0];
	let isValid = validateInp(file);

	if(!isValid) return false;

	formData.append('username', 'abc123');
	formData.append("avatar", file);
	formData.append("timestamp", new Date().getTime());

	console.log(formData);

	processInput(formData, data => console.log(JSON.stringify(data)));
});

/* file input */
fileInput.addEventListener("change", function(e){

	let file = document.querySelector('input[type=file]').files[0];
	let isValid = validateInp(file);

	if(!isValid) return false;

	let reader  = new FileReader();

	reader.onloadend = function () {
		preview.src = reader.result;
	}

	if (file) {
		reader.readAsDataURL(file);
	} else {
	    preview.src = "";
	}

	fileInpbtn.style.display = "none";
	changebtn.style.display = "inline-block";
	deletebtn.style.display = "inline-block";

});

/* change image btn */
changebtn.addEventListener("click", function(){
	fileInput.click();
})

/* remove image btn */
deletebtn.addEventListener("click", function(){
	let file = document.querySelector('input[type=file]').files[0];
	file.value = null;
	fileInpbtn.style.display = "inline-block";
	changebtn.style.display = "none";
	deletebtn.style.display = "none";
	preview.src = "src/img/noimage.png"
})

function processInput(formData,cb){
	let xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function() {
	    if (xhr.readyState == XMLHttpRequest.DONE) {
	        cb(xhr.responseText);
	    }
	}
	xhr.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
	       cb(xhr.responseText);
	    }
	}
	xhr.open("POST", "auth/upload.php");
	xhr.send(formData);
}

function validateInp(file){

	console.log('check valid input....');
	let filetype = file.type;
	let match = ["image/jpeg", "image/png", "imgae/jpg"];

	if(!match.includes(filetype)) {
		alert("Please select a valid image");
		this.files[0].value = null;
		return false;
	}

	return true;
}

document.addEventListener("DOMContentLoaded", function(event) {
	console.log("DOM fully loaded and parsed");
});	

