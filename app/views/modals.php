<div id="forgotPasswordModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ph-lock me-2"></i>
                    Forgot Password
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="forgotPasswordForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="forgotEmail" name="user_email" placeholder="example@email.com" required />
                            <div class="invalid-feedback">Please enter a valid email address!</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" name="forgot_reason" placeholder="State your reason and include the new password that you want" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary mt-2">
                        <i class="ph-check me-1"></i>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#forgotPasswordForm").submit(function(e) {
        e.preventDefault();

        var email = $("#forgotEmail").val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            $(".invalid-feedback").show();
            return;
        } else {
            $(".invalid-feedback").hide();
        }

        var formData = $(this).serialize();

        swalInit.fire({
            text: 'Please wait...',
            allowOutsideClick: false,
            showConfirmButton: false,
        });

        $.ajax({
            url: '/forgotPassword',
            method: 'POST',
            data: formData,
            success: function(data) {
                data = JSON.parse(data);
                swalInit.close();
                if (data.success === 'true') {
                    $('#forgotPasswordModal').modal('hide');
                    swalInit.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    swalInit.fire({
                        title: 'Failed!',
                        text: data.message,
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            },
            error: function(error) {
                swalInit.close();
                swalInit.fire({
                    title: 'Error',
                    text: 'There is an error occurred. Please contact the administrator.',
                    icon: 'error'
                });
                console.log("Error: ", error);
            }
        });
    });
</script>