// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'pdf'
        ]
  });
});
