
<!--   Core JS Files   -->
<script src="{{ asset('template/assets/js/core/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('template/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('template/assets/js/core/bootstrap.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('template/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('template/assets/js/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('template/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ asset('template/assets/js/plugin/jsvectormap/world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Kaiadmin JS -->
<script src="{{ asset('template/assets/js/kaiadmin.min.js') }}"></script>

<script>
$(document).ready(function () {
$("#basic-datatables").DataTable({});

$("#multi-filter-select").DataTable({
  pageLength: 5,
  initComplete: function () {
    this.api()
      .columns()
      .every(function () {
        var column = this;
        var select = $(
          '<select class="form-select"><option value=""></option></select>'
        )
          .appendTo($(column.footer()).empty())
          .on("change", function () {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());

            column
              .search(val ? "^" + val + "$" : "", true, false)
              .draw();
          });

        column
          .data()
          .unique()
          .sort()
          .each(function (d, j) {
            select.append(
              '<option value="' + d + '">' + d + "</option>"
            );
          });
      });
  },
});

// Add Row
$("#add-row").DataTable({
  pageLength: 5,
  "language": {
    "search": "Search:",
    "lengthMenu": "Show _MENU_ entries",
    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
    "paginate": {
      "first": "First",
      "last": "Last",
      "next": "Next",
      "previous": "Previous"
    }
  }
});

// DataTables styling handled in head section for consistency

var action =
  '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

$("#addRowButton").click(function () {
  $("#add-row")
    .dataTable()
    .fnAddData([
      $("#addName").val(),
      $("#addPosition").val(),
      $("#addOffice").val(),
      action,
    ]);
  $("#addRowModal").modal("hide");
});
});
</script>

<!-- Summernote Editor -->
<script>
$(document).ready(function() {
  if ($('#summernote').length) {
    $('#summernote').summernote({
      placeholder: 'Masukkan deskripsi kendaraan...',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });
  }
});
</script>
</body>
</html>