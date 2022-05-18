function validation(e) {
    e.preventDefault();
    var input_text = document.querySelector("#exampleInputEmail1");
    var input_text2 = document.querySelector("#exampleInputname1");
    var input_text3 = document.querySelector("#exampleInputname2");
    var input_text4 = document.querySelector("#exampleInputPassword1");

    if (input_text.value.length <= 0 || input_text2.value.length <= 0 || input_text3.value.length <= 0 || input_text4.value.length <= 0) {
        return false;
    }
    else {
        e.target.submit();
        return true;
    }

}

var input_fields = document.querySelectorAll(".form-control");
var signup_btn = document.querySelector("#signup_btn");

var shouldDisabled = false;
input_fields.forEach(function (input_item) {
    input_item.addEventListener("input", function () {

        shouldDisabled = false;

        input_fields.forEach(function (inp_item) {
            if (inp_item.value.length < 2) {
                shouldDisabled = true;
            }
        })

        if (shouldDisabled) {
            signup_btn.disabled = true;
            signup_btn.classList.remove("enabled");
            signup_btn.classList.add("disabled");
        }
        else {
            signup_btn.disabled = false;
            signup_btn.classList.add("enabled");
            signup_btn.classList.remove("disabled");
        }

    })
})