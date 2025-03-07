<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-dark border-opacity-10 my-0 py-0 header-color">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list custom-color"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="/admin/home" class="d-inline-flex align-items-center">
                <img src="/public/assets/images/logo-web.png" alt="" style="height: 40px">
            </a>
            <div class="d-sm-inline-block ms-3 text-uppercase" style="color: #00446b">
                <p class="mb-0 fw-bold">NextFleet</p>
            </div>
            <!-- <button type="button" class="d-lg-block navbar-toggler rounded-pill sidebar-control sidebar-main-resize d-none ms-auto">
                <i class="ph-list"></i>
            </button> -->
        </div>

        <ul class="nav flex-row"></ul>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <img src="/public/assets/images/user.png" class="w-32px h-32px rounded-pill" alt="">
                    <span id="adminName1" class="d-none d-lg-inline-block mx-lg-2 text-capitalize" style="color: #00446b">Hi, Super Administrator</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <!-- <button href="#" data-bs-toggle="modal" data-bs-target="#profileModal" class="dropdown-item">
                        <i class="ph-lock me-2"></i>
                        Profile
                    </button> -->
                    <div class="dropdown-divider"></div>
                    <a href="/logout" class="dropdown-item">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>

<!-- <div id="profileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="ph-user me-2"></i>
                    Profile
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="profileForm">
                <div class="modal-body">
                    <div id="profileErrors"></div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Admin Name</label>
                            <input type="text" class="form-control" name="admin_name" id="admin_name" placeholder="Admin Name" value="<?= $_SESSION['admin_name'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control" name="user_username" id="profile_user_username" placeholder="Username" value="<?= $_SESSION['user_username'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="user_password" id="profile_user_password" placeholder="******" value="" autocomplete="new-password">
                                <div class="input-group-text">
                                    <i class="ph-eye-slash showProfilePassword"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".showProfilePassword").click(function() {
        if ($(this).hasClass("ph-eye")) {
            $(this).removeClass("ph-eye");
            $(this).addClass("ph-eye-slash");
            $("#profile_user_password").attr("type", "password");
        } else {
            $(this).removeClass("ph-eye-slash");
            $(this).addClass("ph-eye");
            $("#profile_user_password").attr("type", "text");
        }
    });

    $("#profileForm").submit(function(e) {
        e.preventDefault();

        var formData = "";
        formData += 'admin_name=' + encodeURIComponent($('#admin_name').val());
        formData += '&user_username=' + encodeURIComponent($('#profile_user_username').val());
        formData += '&user_password=' + encodeURIComponent($('#profile_user_password').val());

        var password = $("#profile_user_password").val();
        var errors = [];

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;"'|<>,.?/\\-])[A-Za-z\d!@#$%^&*()_+{}\[\]:;"'|<>,.?/\\-]{8,}$/;

        if (!passwordRegex.test(password) && password !== "") {
            errors.push("Password must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one number, and one special character.");
        }

        if (errors.length > 0) {
            var errorHtml = '<div class="alert alert-danger"><ul>';
            errors.forEach(function(error) {
                errorHtml += '<li>' + error + '</li>';
            });
            errorHtml += '</ul></div>';
            $("#profileErrors").html(errorHtml);
            return;
        }

        swalInit.fire({
            text: 'Please wait...',
            allowOutsideClick: false,
            showConfirmButton: false,
        });

        $.ajax({
            url: '/admin/updateProfile',
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
                        location.reload();
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
</script> -->