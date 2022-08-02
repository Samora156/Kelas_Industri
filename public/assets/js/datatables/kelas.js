"use strict";
// Class definition

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var KTDatatableRecordSelectionDemo = function () {
    // Private functions

    var jumlah = {
        data: {
            type: 'remote',
            source: {
                read: {
                    url: HOST_URL + '/admin/kelas/jumlah',
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        columns :[{
            field: 'isi',
            title: 'jumlah',                
    }]
    }

    console.log(jumlah.columns);

    var options = {
        // datasource definition
        data: {
            type: 'remote',
            source: {
                read: {
                    url: HOST_URL + '/admin/kelas/data',
                },
            },
            pageSize: 10,
            serverPaging: true,
            serverFiltering: true,
            serverSorting: true,
        },

        // layout definition
        layout: {
            scroll: false, // enable/disable datatable scroll both horizontal and
            footer: false // display/hide footer
        },

        // column sorting
        sortable: true,

        pagination: true,

        // columns definition
        columns: [
            {
                field: 'nama_kelas',
                title: 'Kelas',
                sortable: false,
                width: 125,
                overflow: 'visible',
                textAlign: 'left',
                autoHide: false,
                template: function (jumlah) {
                    console.log(jumlah.length);
                    return jumlah.nama_kelas;
                }
            },{
                field: 'isi',
                title: 'jumlah',
                sortable: false,
                width: 125,
                overflow: 'visible',
                textAlign: 'left',
                autoHide: false,
                template: function () {
                    var jumlah = {
                        data: {
                            type: 'remote',
                            source: {
                                read: {
                                    url: HOST_URL + '/admin/kelas/data/jumlah',
                                },
                            },
                            pageSize: 10,
                            serverPaging: true,
                            serverFiltering: true,
                            serverSorting: true,
                        }
                    }
                    console.log(jumlah);
                    // return jumlah.data[0];
                }
            },{
            field: '',
            title: 'Aksi',
            sortable: false,
            width: 125,
            overflow: 'visible',
            textAlign: 'left',
            autoHide: false,
            template: function (data) {
                // console.log(data.nama_kelas);
                return '\
                    <a href="#" data-toggle="modal" onclick="getData(' + data.nama_kelas + ')" id="edit" class="btn btn-sm btn-clean btn-icon mr-2 editbtn" title="Edit">\
                        <span class="svg-icon svg-icon-md">\
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                    <rect x="0" y="0" width="24" height="24"/>\
                                    <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                                    <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                </g>\
                            </svg>\
                        </span>\
                    </a>\
                    <a href="#"  data-toggle="modal" onclick="deleteEmployee(' + data.nama_kelas + ')" data-original-title="Delete" class="btn btn-sm btn-clean btn-icon delete " id="kt_sweetalert_demo_8" title="Hapus">\
                        <span class="svg-icon svg-icon-md">\
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                    <rect x="0" y="0" width="24" height="24"/>\
                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
                                </g>\
                            </svg>\
                        </span>\
                    </a>\
                ';
            },
            // data-id="' + data.id +'"
        },
    ]
        
    };

    // basic demo
    var localSelectorDemo = function () {
        // enable extension
        options.extensions = {
            // boolean or object (extension options)
            checkbox: true,
        };

        options.search = {
            input: $('#kt_datatable_search_query'),
            // key: 'generalSearch'
        };

        var datatable = $('#kt_datatable').KTDatatable(options);

        $('#kt_datatable_search_sekolah').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Sekolah');
        });
        $('#kt_datatable_search_ajaran').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Sekolah');
        });
        $('#kt_datatable_search_angkatan').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'angkatan');
        });
        $('#kt_datatable_search_kelas').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Sekolah');
        });

        $('#kt_datatable_search_sekolah, #kt_datatable_search_ajaran, #kt_datatable_search_angkatan, #kt_datatable_search_kelas').selectpicker();

        datatable.on(
            'datatable-on-check datatable-on-uncheck',
            function (_e) {
                var checkedNodes = datatable.rows('.datatable-row-active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_records').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            });
    };

    return {
        // public functions
        init: function () {
            localSelectorDemo();
        },
    };
}();

jQuery(document).ready(function () {
    KTDatatableRecordSelectionDemo.init();
});

// Get Data
function getData(nama_kelas){
    let url = HOST_URL + '/admin/kelas/edit/' + nama_kelas;
    $.ajax({
        url: url,
        method: "POST",
        dataType: 'json',
        success: function(response){
            let _data_siswa = response['0'];
            let nama_kelas = $('#nama1');

            nama_kelas.val(response.kelas.nama_kelas);

            $('#editModal').modal('show');
        },
    });
}

// delete function
function deleteEmployee(id) {

    Swal.fire({
        title: "Are you sure?",
        text: "You wont be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "/delete-student/" + id,
                    dataType: "json",
                    success: function () {
                        location.reload();
                    }
                });
            }
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            Swal.fire(
                "Cancelled",
                "Your imaginary file is safe :)",
                "error"
            )
        }
    });
    return false;
}

// Add Data
function addData(){
    $.ajax({
        url: "",
        method:'POST',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,  
        complete: function(_data){
            $('#KelasForm').modal('hide');
            // location.reload();
        },
        data: (function (){
            let data = new FormData();
            data.append('nama_kelas' ,$('#nama').val());
            return data;
        })()
    });
    return false;
}

function sendData(){
    let url = 'update/kelas' ;
    $.ajax({
        url : url,
        method:'POST',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        complete: function(_data){
            $('#editModal').modal('hide');
            location.reload();
        },
        data: (function () {
           let data = new FormData();
           data.append('nama' ,$('#nama1').val());
           return data;
        })()
    });
}

$(
    function(){
        $('#KelasForm').on('submit',(e) => {
            e.stopPropagation();
            e.preventDefault();
                Swal.fire({
                    title: 'Anda Yakin Untuk Menambah Data?',
                    text: "Anda Masih Bisa Mengubahnya?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        addData();
                    }
                })
        });

        $('#KelasForm_update').on('submit',(e) => {
            e.preventDefault();
            e.stopPropagation();
                Swal.fire({
                    title: 'Anda Yakin Untuk Mengubah Data?',
                    text: "Anda Masih Dapat Mengubah Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        sendData();
                    }
                })
        });
    }
)