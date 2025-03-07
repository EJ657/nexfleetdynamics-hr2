$("#showPassword").click(function(){
    if($(this).hasClass("ph-eye")){
        $(this).removeClass("ph-eye");
        $(this).addClass("ph-eye-slash");
        $("#user_password").attr("type", "password");
    } else {
        $(this).removeClass("ph-eye-slash");
        $(this).addClass("ph-eye");
        $("#user_password").attr("type", "text");
    }
});

function checkRequest() {
    $.ajax({
        url: '/checkRequest',
        method: 'GET',
        success: function(data) {
            console.log(data.status);
            if (data.status === 'Approved') {
                swalInit.fire({
                    title: 'Success',
                    text: "Logged in Successfully",
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location = `/student/home`;
                });
            } else if (data.status === 'Rejected') {
                swalInit.fire({
                    title: 'Rejected',
                    text: "Your request has been rejected by the teacher.",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                setTimeout(checkRequest, 1000);
            }
        },
        error: function(error) {
            console.log("Error: ", error);
            setTimeout(checkRequest, 1000);
        }
    });
}

$("#login-form").submit(function(e) {
    e.preventDefault();

    var formData = {
        user_email: $("#user_username").val(),
        user_password: $("#user_password").val()
    };

    swalInit.fire({
        text: 'Please wait...',
        allowOutsideClick: false,
        showConfirmButton: false,
    });

    $.ajax({
        url: '/login',
        method: 'POST',
        data: formData,
        success: function(data) {
            data = JSON.parse(data);
            if (data.success === 'false') {
                swalInit.close();
                swalInit.fire({
                    title: 'Failed!',
                    text: data.message,
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else if (data.success === 'true') {
                swalInit.close();
                swalInit.fire({
                    title: 'Success',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location = `/${data.user_role}/home`;
                });
            } else if (data.status === 'Not Approved') {
                swalInit.close();
                swalInit.fire({
                    title: 'Failed',
                    text: "Your account needs confirmation from the teacher.",
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                swalInit.close();
                swalInit.fire({
                    title: 'Please wait..',
                    text: data.message,
                    icon: 'info',
                    showConfirmButton: false
                });
                checkRequest();
            }
        },
        error: function(error) {
            swalInit.close();
            swalInit.fire({
                title: 'Error',
                text: 'There is error occurred. Please contact the administrator.',
                icon: 'error'
            });
            console.log("Error: ", error);
        }
    });

});