</div> <!-- Close main-content -->

<!-- Modern Footer -->
<footer class="modern-footer">
    <div class="footer-content">
        <div class="footer-left">
            <p class="copyright">
                &copy; <?php echo date("Y"); ?>
                <strong>Ikris Pharma Network</strong>.
                All rights reserved.
            </p>
        </div>
        <div class="footer-right">
            <a href="<?php echo base_url(); ?>" target="_blank" class="footer-link">
                <i class="fas fa-globe"></i> Visit Website
            </a>
            <a href="<?php echo base_url('settings/Settings'); ?>" class="footer-link">
                <i class="fas fa-cog"></i> CMS
            </a>
            <span class="footer-version">
                <i class="fas fa-code-branch"></i> v2.0.0
            </span>
        </div>
    </div>
</footer>
</div> <!-- Close page wrapper if exists -->
</div> <!-- Close any wrapper div -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<style>
    /* Footer Styles */
    .modern-footer {
        background: white;
        border-top: 1px solid #e2e8f0;
        padding: 20px 25px;
        margin-left: var(--sidebar-width);
        transition: margin-left var(--transition-speed);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    }

    .modern-sidebar.collapsed~.main-content .modern-footer,
    .modern-sidebar.collapsed~.modern-footer {
        margin-left: var(--sidebar-collapsed-width);
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .copyright {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .copyright strong {
        color: var(--primary-color);
        font-weight: 600;
    }

    .footer-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .footer-link {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .footer-link:hover {
        color: var(--primary-color);
    }

    .footer-version {
        color: #94a3b8;
        font-size: 0.85rem;
        padding: 4px 12px;
        background: #f1f5f9;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Responsive Footer */
    @media (max-width: 768px) {
        .modern-footer {
            margin-left: 0 !important;
            padding: 15px;
        }

        .footer-content {
            flex-direction: column;
            text-align: center;
        }

        .footer-right {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>

<script>
    // Global initialization
    $(document).ready(function() {

        // Initialize all DataTables with modern styling
        if ($.fn.DataTable) {
            $('.display, .table-responsive table, #categoryTable, #newsTable, #medicinesTable, #medCategoryTable, #contactTable')
                .each(function() {
                    if (!$.fn.DataTable.isDataTable(this)) {
                        $(this).DataTable({
                            responsive: true,
                            pageLength: 10,
                            lengthMenu: [
                                [10, 25, 50, 100, -1],
                                [10, 25, 50, 100, "All"]
                            ],
                            order: [
                                [0, 'desc']
                            ],
                            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
                            language: {
                                search: "_INPUT_",
                                searchPlaceholder: "Search records...",
                                lengthMenu: "Show _MENU_ entries",
                                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                                infoEmpty: "No entries found",
                                infoFiltered: "(filtered from _MAX_ total entries)",
                                paginate: {
                                    first: '<i class="fas fa-angle-double-left"></i>',
                                    last: '<i class="fas fa-angle-double-right"></i>',
                                    next: '<i class="fas fa-angle-right"></i>',
                                    previous: '<i class="fas fa-angle-left"></i>'
                                }
                            }
                        });
                    }
                });
        }

        // Initialize Select2 with modern theme
        if ($.fn.select2) {
            $('.select2, select.form-control, select.form-select').not('.no-select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }

        // Initialize Summernote with modern configuration
        if ($.fn.summernote) {
            $('#summernote, #edit_summernote, .summernote').summernote({
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        // Form validation enhancement
        if ($.fn.validate) {
            $('form').each(function() {
                if (!$(this).data('validator')) {
                    $(this).validate({
                        errorClass: 'is-invalid',
                        validClass: 'is-valid',
                        errorElement: 'div',
                        errorPlacement: function(error, element) {
                            error.addClass('invalid-feedback');
                            if (element.parent('.input-group').length) {
                                error.insertAfter(element.parent());
                            } else {
                                error.insertAfter(element);
                            }
                        },
                        highlight: function(element) {
                            $(element).addClass('is-invalid').removeClass('is-valid');
                        },
                        unhighlight: function(element) {
                            $(element).removeClass('is-invalid').addClass('is-valid');
                        }
                    });
                }
            });
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.custom-alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);

        // Manual alert close
        $('.custom-close').on('click', function() {
            $(this).parent('.custom-alert').fadeOut('slow', function() {
                $(this).remove();
            });
        });

        // Confirm delete actions
        $('a[onclick*="confirm"], .delete-btn, .btn-danger[href*="delete"]').on('click', function(e) {
            if (!$(this).data('confirmed')) {
                e.preventDefault();
                const href = $(this).attr('href');
                const element = $(this);

                if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                    element.data('confirmed', true);
                    if (href) {
                        window.location.href = href;
                    } else {
                        element.trigger('click');
                    }
                }
            }
        });

        // Image preview functionality
        $('input[type="file"]').on('change', function() {
            const input = this;
            const preview = $(this).closest('.form-group').find(
                '.image-preview, #edit_current_image, #currentImagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview.length) {
                        preview.attr('src', e.target.result).show();
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        // Loading spinner on form submit
        $('form').on('submit', function(e) {
            if ($(this).valid && $(this).valid()) {
                $('#loadingSpinner').fadeIn();
            }
        });

        // Smooth scroll to top button
        const scrollBtn = $('<button>', {
            id: 'scrollToTop',
            class: 'scroll-to-top',
            html: '<i class="fas fa-arrow-up"></i>'
        }).appendTo('body');

        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                scrollBtn.fadeIn();
            } else {
                scrollBtn.fadeOut();
            }
        });

        scrollBtn.on('click', function() {
            $('html, body').animate({
                scrollTop: 0
            }, 600);
        });

        // Tooltip initialization
        $('[data-bs-toggle="tooltip"]').tooltip();

        // Popover initialization
        $('[data-bs-toggle="popover"]').popover();

        // Auto-resize textareas
        $('textarea').each(function() {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Number input formatting
        $('input[type="number"]').on('wheel', function(e) {
            $(this).blur();
        });

        // Prevent double form submission
        $('form').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span>Processing...'
            );
        });

        console.log('%cIkris Pharma Network Dashboard', 'color: #4361ee; font-size: 20px; font-weight: bold;');
        console.log('%cDashboard loaded successfully!', 'color: #06d6a0; font-size: 14px;');
    });
</script>

<style>
    /* Scroll to top button */
    .scroll-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        z-index: 999;
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        transition: all 0.3s;
    }

    .scroll-to-top:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(67, 97, 238, 0.5);
    }

    .scroll-to-top i {
        font-size: 1.2rem;
    }

    /* Enhanced form styles */
    .is-invalid {
        border-color: var(--danger-color) !important;
    }

    .is-valid {
        border-color: var(--success-color) !important;
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .valid-feedback {
        color: var(--success-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    /* DataTables custom styling */
    .dataTables_wrapper .dataTables_length select {
        padding: 5px 10px;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 8px 15px;
        border-radius: 20px;
        border: 2px solid #e2e8f0;
        margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--primary-color);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 12px;
        margin: 0 2px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white !important;
        border-color: var(--primary-color);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--primary-color);
        color: white !important;
        border-color: var(--primary-color);
    }

    /* Select2 custom styling */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 8px !important;
        border: 2px solid #e2e8f0 !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15) !important;
    }

    /* Summernote custom styling */
    .note-editor {
        border-radius: 8px;
        border: 2px solid #e2e8f0;
    }

    .note-editor.note-frame {
        border-color: var(--primary-color);
    }

    .note-toolbar {
        background: #f8f9fa;
        border-bottom: 1px solid #e2e8f0;
    }

    /* Print styles */
    @media print {

        .modern-sidebar,
        .modern-header,
        .modern-footer,
        .scroll-to-top,
        .btn,
        .dataTables_filter,
        .dataTables_length,
        .dataTables_paginate {
            display: none !important;
        }

        .main-content {
            margin-left: 0 !important;
            margin-top: 0 !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }
    }
</style>

</body>

</html>