<?php $currentUrl = $_SERVER['REQUEST_URI']; ?>

<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg my-color">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Sidebar header -->
        <div class="sidebar-section">
            <div class="container-fluid d-flex flex-column">
                <button type="button" class="btn btn-flat-black btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none mt-3">
                    Toggle Sidebar
                </button>
            </div>
        </div>
        <!-- /sidebar header -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar nav-sidebar-admin" data-nav-type="accordion">

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide fw-bold">Navigation</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/home"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/home') ? 'active fw-bold' : '' ?>">
                        <i class="ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/competency"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/competency') ? 'active fw-bold' : '' ?>">
                        <i class="ph-lightbulb"></i>
                        <span>
                            Competency Management
                        </span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/accounts"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/accounts') ? 'active fw-bold' : '' ?>">
                        <i class="ph-users"></i>
                        <span>
                            User Accounts
                        </span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/messages"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/messages') ? 'active fw-bold' : '' ?>">
                        <i class="ph-chat"></i>
                        <span>
                            Messages
                        </span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/forgot_requests"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/forgot_requests') ? 'active fw-bold' : '' ?>">
                        <i class="ph-lock"></i>
                        <span>
                            Forgot Password Requests
                        </span>
                    </a>
                </li>

                <li class="nav-item mb-1">
                    <a href="/super_admin/ai"
                        class="nav-link nav-link-admin <?= ($currentUrl == '/super_admin/ai') ? 'active fw-bold' : '' ?>">
                        <i class="ph-robot"></i>
                        <span>
                            AI Automated Feedback Analysis
                        </span>
                    </a>
                </li>

                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide fw-bold">Settings</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                <li class="nav-item mb-1">
                    <a href="/logout" class="nav-link nav-link-admin">
                        <i class="ph ph-sign-out"></i>
                        <span>
                            Sign Out
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->