// ========================================
// SURAT MASUK - JAVASCRIPT
// ========================================

$(document).ready(function () {
    // Initialize DataTables
    var table = $('#suratMasukTable').DataTable({
        responsive: true,
        // "scrollX": true,
        "autoWidth": false, // Biarkan CSS mengatur lebar
        "dom": 'Bfrtip',
        "buttons": [{
            extend: 'excel',
            text: '<i class="fas fa-file-excel"></i> Excel',
            className: 'dt-button',
            exportOptions: {
                columns: ':not(.no-export)'
            }
        },
        {
            extend: 'pdf',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            className: 'dt-button',
            orientation: 'landscape',
            pageSize: 'A4',
            download: 'open',
            title: 'Laporan Surat Masuk',
            exportOptions: {
                columns: ':not(.no-export)'
            },
            customize: function (doc) {
                // Add Logo and Header Text
                if (typeof logoBase64 !== 'undefined') {
                    // Create the header container
                    var header = {
                        columns: [
                            {
                                image: logoBase64,
                                width: 50,
                                alignment: 'right'
                            },
                            {
                                text: [
                                    { text: 'PEMERINTAH KOTA BANJARMASIN\n', fontSize: 12, bold: true, margin: [0, 0, 0, 2] },
                                    { text: 'DINAS PENGENDALIAN PENDUDUK KELUARGA\n', fontSize: 14, bold: true },
                                    { text: 'BERENCANA DAN PEMBERDAYAAN MASYARAKAT', fontSize: 14, bold: true }
                                ],
                                alignment: 'center',
                                margin: [15, 0, 0, 0]
                            }
                        ],
                        margin: [0, 10, 0, 5]
                    };

                    // Create the line separator
                    var line = {
                        canvas: [{ type: 'line', x1: 0, y1: 0, x2: 770, y2: 0, lineWidth: 3 }],
                        margin: [0, 0, 0, 10],
                        alignment: 'center'
                    };

                    // Insert both
                    doc.content.splice(0, 0, line);
                    doc.content.splice(0, 0, header);
                }

                // Styling
                doc.defaultStyle.fontSize = 10;
                doc.styles.tableHeader.fontSize = 11;
                doc.styles.tableHeader.alignment = 'center';
                doc.styles.tableHeader.fillColor = '#3b82f6'; // Blue header
                doc.styles.tableHeader.color = '#ffffff';

                doc.styles.tableBodyOdd.alignment = 'center';
                doc.styles.tableBodyEven.alignment = 'center';

                // Layout columns & Borders
                var tableNode;
                for (var i = 0; i < doc.content.length; i++) {
                    if (doc.content[i].table) {
                        tableNode = doc.content[i];
                        break;
                    }
                }

                if (tableNode) {
                    // Widen table columns - give priority to Alamat (3) and Perihal (6)
                    // Indices: 0: No, 1: Agenda, 2: Tgl Terima, 3: Alamat, 4: Tgl Surat, 5: No Surat, 6: Perihal
                    tableNode.table.widths = ['4%', '7%', '9%', '*', '9%', '12%', '*', '12%'];

                    // Add all borders
                    tableNode.layout = {
                        hLineWidth: function (i, node) { return 1; },
                        vLineWidth: function (i, node) { return 1; },
                        hLineColor: function (i, node) { return '#d1d5db'; },
                        vLineColor: function (i, node) { return '#d1d5db'; },
                        paddingLeft: function (i, node) { return 8; },
                        paddingRight: function (i, node) { return 8; },
                        paddingTop: function (i, node) { return 8; },
                        paddingBottom: function (i, node) { return 8; }
                    };
                }

                // Add Filter Period or Auto Date Range
                var dari = $('#filterDari').val();
                var sampai = $('#filterSampai').val();
                var periodeText = '';
                function fmt(d) { return d.split('-').reverse().join('/'); }

                if (dari && sampai) {
                    periodeText = 'Periode: ' + fmt(dari) + ' s/d ' + fmt(sampai);
                } else if (dari) {
                    periodeText = 'Periode: Dari ' + fmt(dari);
                } else if (sampai) {
                    periodeText = 'Periode: Sampai ' + fmt(sampai);
                } else {
                    // Auto-calculate from visible data if no filter
                    var dates = [];
                    // Column 2 is Tanggal Terima
                    table.column(2, { search: 'applied' }).data().each(function (val) {
                        // Cleanup HTML if any, though usually pure text in data()
                        var dateStr = val.replace(/<[^>]+>/g, '').trim();
                        if (dateStr) dates.push(dateStr);
                    });

                    if (dates.length > 0) {
                        dates.sort(function (a, b) {
                            var da = a.split('/').reverse().join('-');
                            var db = b.split('/').reverse().join('-');
                            return da < db ? -1 : (da > db ? 1 : 0);
                        });
                        // Use first and last date from the sorted list
                        var minDate = dates[0];
                        var maxDate = dates[dates.length - 1];
                        periodeText = 'Arsip dari tanggal ' + minDate + ' sampai tanggal ' + maxDate;
                    }
                }

                if (periodeText) {
                    doc.content.splice(1, 0, {
                        text: periodeText,
                        alignment: 'center',
                        margin: [0, 0, 0, 15],
                        fontSize: 11,
                        italics: true
                    });
                }

                // Add Total Count
                var rowCount = tableNode ? (tableNode.table.body.length - 1) : 0;
                doc.content.push({
                    text: 'Total Arsip: ' + rowCount,
                    margin: [0, 20, 0, 0],
                    fontSize: 11,
                    bold: true
                });
            }
        }
        ],
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "pageLength": 10,
        "order": [
            [0, 'asc']
        ]
    });

    // Custom Filtering Function
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'suratMasukTable') return true;

        // Status Filter logic has been removed


        // Date Filter (Column index 2 - Tanggal Terima)
        var dari = $('#filterDari').val();
        var sampai = $('#filterSampai').val();

        // Get data-date attribute from the cell
        var row = $(table.row(dataIndex).node());
        var dateVal = row.find('td:eq(2)').attr('data-date');

        if (!dari && !sampai) return true;
        if (!dateVal) return false;
        if (dari && dateVal < dari) return false;
        if (sampai && dateVal > sampai) return false;

        return true;
    });

    // Event Listeners for Filters
    $('#btnFilter').on('click', function () {
        table.draw();
    });

    $('#btnReset').on('click', function () {
        $('#filterDari').val('');
        $('#filterSampai').val('');
        table.draw();
    });
});

// Delete confirmation using SweetAlert2
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data surat masuk ini akan dihapus permanen beserta filenya!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'proses-surat-masuk.php?action=delete&id=' + id;
        }
    });
}