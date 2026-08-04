</div>
<footer class="footer">
    <div class="footer-content">
        <span class="footer-links">
            <!-- <a href="<?php echo base_url(); ?>" target="_blank">
                <i class="fas fa-external-link-alt"></i> Visit Website
            </a> -->
        </span>
        <span class="copyright">
            &copy; <?php echo date("Y"); ?> <strong>Named Patient Medicine Portal</strong>. All rights reserved.
        </span>

    </div>
</footer>
</div>
</div>

<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo base_url(); ?>assets/js/sidebarmenu.js"></script>
<!--stickey kit -->
<script src="<?php echo base_url(); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo base_url(); ?>assets/js/custom.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<!--sparkline JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
<!--morris JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morrisjs/morris.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>

<script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<!-- Editable -->
<script src="<?php echo base_url(); ?>assets/plugins/jsgrid/db.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jsgrid/dist/jsgrid.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/multiselect/js/jquery.multi-select.js">
</script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<!-- start - This is for export functionality only -->
<script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/export/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/export/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/export/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/export/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<!-- Clock Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
<!-- Date range Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript">
</script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"
    type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/multiselect/js/jquery.multi-select.js">
</script>

<!-- CALENDAR -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/calendar/dist/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/calendar/dist/cal-init.js"></script>

<script type="text/javascript">
$(function() {
    $('.mydatetimepicker').datepicker({
        format: "mm-yyyy",
        viewMode: "years",
        minViewMode: "months"
    });
});
$(function() {
    $('.mydatetimepickerFull').datepicker({
        format: "yyyy-mm-dd"
    });
});
</script>

<script>
$(document).ready(function() {
    $('#myTable').DataTable();
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' +
                            group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
});

$(function() {
    $("#datepicker").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());
});

jQuery('.mydatepicker, #datepicker').datepicker();
jQuery('#datepicker-autoclose').datepicker({
    autoclose: true,
    todayHighlight: true
});

$('#example23').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});

$('#single-input').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    'default': 'now'
});

$('.clockpicker').clockpicker({
    donetext: 'Done',
}).find('input').change(function() {
    console.log(this.value);
});

$('#check-minutes').click(function(e) {
    e.stopPropagation();
    input.clockpicker('show').clockpicker('toggleView', 'minutes');
});

$(function() {
    $('#datetimepicker2').datetimepicker({
        language: 'en',
        pick12HourFormat: true
    });
});

$(".select2").select2();
</script>

<script type="text/javascript">
$('form').each(function() {
    $(this).validate({
        submitHandler: function(form) {
            var formval = form;
            var url = $(form).attr('action');

            var data = new FormData(formval);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function(response) {
                    console.log(response);
                    $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(
                        response);
                    $('form').trigger("reset");
                    window.setTimeout(function() {
                        location.reload()
                    }, 3000);
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });
});
</script>

<script src="<?php echo base_url(); ?>assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<style>
/* ========================================
           PHARMACEUTICAL FOOTER STYLING
        ======================================== */

.footer {
    background: var(--pharma-white);
    border-top: 1px solid var(--pharma-gray-200);
    padding: var(--space-4) var(--space-6);

    margin-top: var(--space-8);
    transition: margin-left var(--transition-slow);
}

.footer-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-4);
    font-size: var(--font-size-sm);
    color: var(--pharma-gray-600);
}

.footer-content .copyright {
    display: flex;
    align-items: center;
    gap: var(--space-2);
}

.footer-content .copyright strong {
    color: var(--pharma-gray-800);
    font-weight: 600;
}

.footer-links {
    display: flex;
    align-items: center;
    gap: var(--space-4);
}

.footer-links a {
    display: inline-flex;
    align-items: center;
    gap: var(--space-2);
    color: var(--pharma-primary);
    text-decoration: none;
    font-weight: 500;
    transition: all var(--transition-base);
}

.footer-links a:hover {
    color: var(--pharma-primary-dark);
}

.footer-links a i {
    font-size: 12px;
}

/* Page Wrapper */
.page-wrapper {
    margin-left: 260px;
    margin-top: 64px;
    min-height: calc(100vh - 64px);
    background: var(--pharma-gray-50);
    padding: var(--space-6);
    transition: all var(--transition-slow);
}

/* Main Wrapper */
#main-wrapper {
    position: relative;
    min-height: 100vh;
}

/* ========================================
           RESPONSIVE BEHAVIOR
        ======================================== */

@media (max-width: 768px) {
    .footer {
        margin-left: 0;
        padding: var(--space-4);
    }

    .footer-content {
        flex-direction: column;
        text-align: center;
        gap: var(--space-2);
    }

    .page-wrapper {
        margin-left: 0;
        padding: var(--space-4);
    }
}

/* ========================================
           GLOBAL UTILITIES
        ======================================== */

.text-center {
    text-align: center !important;
}

.text-right {
    text-align: right !important;
}

.d-flex {
    display: flex !important;
}

.align-items-center {
    align-items: center !important;
}

.justify-content-between {
    justify-content: space-between !important;
}

.justify-content-end {
    justify-content: flex-end !important;
}

.gap-2 {
    gap: var(--space-2) !important;
}

.gap-3 {
    gap: var(--space-3) !important;
}

.gap-4 {
    gap: var(--space-4) !important;
}

.mb-0 {
    margin-bottom: 0 !important;
}

.mb-2 {
    margin-bottom: var(--space-2) !important;
}

.mb-3 {
    margin-bottom: var(--space-3) !important;
}

.mb-4 {
    margin-bottom: var(--space-4) !important;
}

.mt-2 {
    margin-top: var(--space-2) !important;
}

.mt-3 {
    margin-top: var(--space-3) !important;
}

.mt-4 {
    margin-top: var(--space-4) !important;
}
</style>
</body>

</html>