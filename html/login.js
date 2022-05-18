function validation(e) {
    e.preventDefault();
	var input_text = document.querySelector("#exampleInputEmail1");
	var input_text3 = document.querySelector("#exampleInputPassword1");

	if (input_text.value.length <= 0  || input_text3.value.length <= 1) {
		return false;
	}
	else {
        e.target.submit();
		return true;
	}

}

var input_fields = document.querySelectorAll(".form-control");
var login_btn = document.querySelector("#login_btn");

input_fields.forEach(function (input_item) {
	input_item.addEventListener("input", function () {
		if (input_item.value.length > 2) {
			login_btn.disabled = false;
			login_btn.className = "btn enabled"
		}
	})
})