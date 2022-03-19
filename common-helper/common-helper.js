

/* @ Scroll Validator */

function scroll_validator(validate) {

    if (typeof validate === "object") {

        for (let item of validate) {

            /* Check Global State */
            if (scroll_resp === false) break;

            // Destructure Object.
            let { selector, name, rules, errclass} = item;
             
            for (let rule in rules) {

                hide_errors(errclass);

                /* Required Validation */
                if (rule.trim() === "required") {
                    var scroll_resp = scroll_required(selector, name);
                    if (scroll_resp === false) break;
                }

                if (rule.trim() === "maxlength") {
                    let maxlen = rules.maxlength;
                    console.log(maxlen);
                    var scroll_resp = scroll_maxlength(selector, name, maxlen);
                    if (scroll_resp === false) break;
                }

            }
        }
    }
}


/* @ Send Ajax Request */

function send_ajax(url, formId) {
    $.ajax({
        url: url,
        type: "post",
        data: $(formId).serialize(),

        success(data) {
            let response = JSON.parse(data);

            if (response.status == "success") {
                $("#btnSubmit").attr("disabled", true);
                $("#mail_success").html(
                    '<span class="fa fa-check"></span> Your form has been successfully submitted! You will receive a confirmation email'
                ).show();

                scroll_elem("#mail_success", 150, 32);

                setTimeout(() => {
                    location.reload();
                }, 3000);

            } else {
                $("#mail_error")
                    .html(`<span class="fa fa-times-circle"></span> ${response.status}`)
                    .show();
                scroll_elem("#mail_error", 150, 32);
            }
        },
        error(err) {
            alert("Something Went Wrong, Please Try Again");
        },
    });
}

/* @ Scroll Element Function */
function scroll_elem(element, heightD = 230, heightM = 32) {
    if ($(window).width() >= 1200) {
        $("html,body").animate(
            {
                scrollTop: $(element).offset().top - heightD,
            },
            800
        );
    } else {
        $("html,body").animate(
            {
                scrollTop: $(element).offset().top - heightM,
            },
            800
        );
    }
}

/*
@ Hide All Errors
*/

function hide_errors(classname) {
    if ($(classname)) {
      $(classname).remove();
    }
}


/* 
@ Rules for Scroll Validator
*/

// Scroll-Required

function scroll_required(selector, name) {
  let value = $(selector).val().trim();
  let errorClass = selector.replace("#", "").trim();

  if (value == "") {
    scroll_elem(selector);
    $(selector).after(
      `<span id="error-${errorClass}" class='text-danger'>Please Enter ${name}</span>`
    );
    return false;
  }
}

// Scroll-Minlength

function scroll_minlength(selector, name, len) {
  let value = $(selector).val().trim();
  let errorClass = selector.replace("#", "").trim();

  if (value.length < len) {
    scroll_elem(selector);
    $(selector).after(
      `<span id="error-${errorClass}" class='text-danger'>${name} Length Should be 8</span>`
    );
    return false;
  }
}


// Scroll-Maxlength

function scroll_maxlength(selector, name, len) {
  let value = $(selector).val().trim();
  let errorClass = selector.replace("#", "").trim();

  if (value.length > len) {
    scroll_elem(selector);
    $(selector).after(
      `<span id="error-${errorClass}" class='text-danger'>${name} Length Should be Less than ${len}</span>`
    );
    return false;
  }
}

