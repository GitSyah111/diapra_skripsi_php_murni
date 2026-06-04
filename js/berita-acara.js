$(document).ready(function() {
    // Inisialisasi DataTable
    var table = $('#beritaAcaraTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
        },
        dom: '<"top"fB>rt<"bottom"lip><"clear">',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn-secondary',
                exportOptions: {
                    columns: ':not(.no-export)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn-secondary',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: ':not(.no-export)'
                },
                customize: function (doc) {
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 11;
                    
                    if (typeof logoBase64 !== 'undefined') {
                        doc.content.splice(0, 0, {
                            alignment: 'center',
                            image: logoBase64,
                            width: 50,
                            margin: [0, 0, 0, 10]
                        });
                    }
                    
                    doc.content.splice(1, 0, {
                        text: 'DAFTAR BERITA ACARA',
                        style: 'header',
                        alignment: 'center',
                        margin: [0, 0, 0, 20]
                    });
                }
            }
        ],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        pageLength: 10,
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        order: [[ 1, 'asc' ]]
    });

    // Menambahkan nomor urut otomatis
    table.on('order.dt search.dt', function () {
        let i = 1;
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();

});

// Fungsi Konfirmasi Hapus
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data berita acara ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Logika untuk mengirim POST delete
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'proses-berita-acara.php';
            
            let actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';
            form.appendChild(actionInput);

            let idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            form.appendChild(idInput);

            document.body.appendChild(form);
            form.submit();
        }
    })
}
