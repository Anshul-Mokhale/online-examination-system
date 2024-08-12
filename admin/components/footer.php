<?php if (!($curPageName == 'login.php' || $curPageName == 'forgot_password.php')) { ?>
  <!-- partial:partials/_footer.html -->
  <footer class="footer">
    <div class="container-fluid d-flex justify-content-between">
      <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
        <?= date('Y') ?>
      </span>
    </div>
  </footer>
  <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
<?php }
if ($curPageName != 'add_bank_report_max_file.php' && $curPageName != 'add_bank_report_max.php') { ?>
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/todolist.js"></script>
  <script src="assets/js/jquery.inputmask.js" type="text/javascript"></script>
  <script src="assets/js/jquery.inputmask.extensions.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function () {
      $("[data-mask]").inputmask();
    });
  </script>
  <script src="assets/js/jszip.min.js"></script>
  <script type="text/javascript"
    src="https://cdn.datatables.net/v/dt/dt-1.13.1/b-2.3.2/b-html5-2.3.2/b-print-2.3.2/fc-4.2.1/fh-3.3.1/r-2.4.0/sc-2.0.7/sb-1.4.0/sp-2.1.0/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.11.5/api/sum().js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<?php } ?>
<script src="assets/js/main.js?v=<?= time(); ?>"></script>
<script src="https://unpkg.com/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/dselect.js"></script>
<!-- <script src="assets/js/pdfmake.min.js"></script> -->

<script type="text/javascript">
  $(document).ready(function () {
    <?php if ($curPageName == 'add_header_menu.php' || $curPageName == 'edit_header_menu.php') { ?>
      var select_box_element = document.querySelector('#menu_link');
      dselect(select_box_element, {
        search: true
      });
      var select_box_element = document.querySelector('#sub_menu_link');
      dselect(select_box_element, {
        search: true
      });
    <?php }
    if ($curPageName == 'add_footer_details.php' || $curPageName == 'edit_footer_details.php') { ?>
      var select_box_element = document.querySelector('#second_head_menu_link');
      dselect(select_box_element, {
        search: true
      });
      var select_box_element = document.querySelector('#third_head_menu_link');
      dselect(select_box_element, {
        search: true
      });
    <?php }
    if ($curPageName == 'add_about_section.php' || $curPageName == 'edit_about_section.php') { ?>
      var select_box_element = document.querySelector('#btn_link');
      dselect(select_box_element, {
        search: true
      });
    <?php } ?>
  });
</script>
<?php if ($curPageName == 'edit_category.php') { ?>
  <script>
    $(document).ready(function () {
      $("#checkedAll").change(function () {
        if (this.checked) {
          $(".checkSingle").each(function () {
            this.checked = true;
          })
        } else {
          $(".checkSingle").each(function () {
            this.checked = false;
          })
        }
      });

      $(".checkSingle").click(function () {
        if ($(this).is(":checked")) {
          var isAllChecked = 0;
          $(".checkSingle").each(function () {
            if (!this.checked)
              isAllChecked = 1;
          })
          if (isAllChecked == 0) { $("#checkedAll").prop("checked", true); }
        } else {
          $("#checkedAll").prop("checked", false);
        }
      });
    });
  </script>
<?php } ?>


<!-- End custom js for this page -->
</body>

</html>