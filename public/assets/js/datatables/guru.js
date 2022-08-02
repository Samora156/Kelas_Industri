"use strict";
// Class definition

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var KTDatatableJsonRemoteDemo = function () {
    // Private functions

    var demo = function () {
        var datatable = $('#kt_datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'remote',
                source: HOST_URL + '/admin/guru/data',
                pageSize: 10,
            },

            // layout definition 
            layout: {
                scroll: false,
                footer: false
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#kt_datatable_search_query'),
                key: 'generalSearch'
            },

            // columns definition
            columns: [{
                field: 'id',
                title: '#',
                sortable: false,
                width: 20,
                selector: {
                    class: ''
                },
                textAlign: 'center',
            }, {
                field: 'nama_guru',
                title: 'Guru',
                width: 250,
                template: function (data) {
                    var _number = KTUtil.getRandomInt(1, 14);
                    var user_img = 'background-image:url(\'assets/media/guru/' + data.foto + '\')';                
    
                    var output = '';
                    output = '<div class="d-flex align-items-center">\
                            <div class="symbol symbol-40 flex-shrink-0">\
                                <div class="symbol-label" style="' + user_img + '"></div>\
                            </div>\
                            <div class="ml-2">\
                                <a href="admin/siswa/profil" class="text-dark-75 font-weight-bold line-height-sm text-hover-primary">' + data.nama_guru + '</a>\
                                <br>\
                                <a href="amdin/sekolah/' + data.id_sekolah + '" class="font-size-sm text-dark-50 text-hover-primary">' + data.nama_sekolah + '</a>\
                            </div>\
                        </div>';
    
                    return output;
                },
            }, {
                field: 'alamat',
                title: 'Alamat',
            }, {
                field: 'tlpn',
                title: 'No.Telepon',
            }, {
                field: '',
                title: 'Aksi',
                sortable: false,
                width: 125,
                overflow: 'visible',
                textAlign: 'left',
                autoHide: false,
                template: function (data) {
                    return '\
                        <a href="#" data-toggle="modal" onclick="getData(' + data.id + ')" id="edit" class="btn btn-sm btn-clean btn-icon mr-2 editbtn" title="Edit">\
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
                        <a href="#"  data-toggle="modal" onclick="deleteEmployee(' + data.id + ')" data-original-title="Delete" class="btn btn-sm btn-clean btn-icon delete " id="kt_sweetalert_demo_8" title="Hapus">\
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
            }]
        });

        $('#search_sekolah').on('change', function (e) {
            datatable.search($(this).val().toLowerCase(), 'nama_sekolah');
        });
        $('#search_ajaran').on('change', function (e) {
            datatable.search($(this).val().toLowerCase(), 'tahun_ajaran');
        });
        $('#search_angkatan').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'angkatan');
        });
        $('#search_kelas').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'id_kelas');
        });

        $('#search_sekolah, #search_ajaran, #search_angkatan, #search_kelas').selectpicker();

        datatable.on(
            'datatable-on-check datatable-on-uncheck',
            function (e) {
                var checkedNodes = datatable.rows('.datatable-row-active').nodes();
                var count = checkedNodes.length;
                $('#kt_datatable_selected_records').html(count);
                if (count > 0) {
                    $('#kt_datatable_group_action_form').collapse('show');
                } else {
                    $('#kt_datatable_group_action_form').collapse('hide');
                }
            });

            $(document).ready(function() {
                $('#pdf').on('click', function() {
                    let ids = [];

                    $.each(datatable.rows('.datatable-row-active').
                    nodes().find('.checkbox > [type="checkbox"]'), (i, e) => {
                         ids.push($(e).val());   
                        console.log(ids.push($(e).val()));
                    });
                    $.ajax({
                        url: '/admin/guru/coba',
                        type: "POST",
                        data: {
                            id_guru: ids
                        },
                        success: function(data) {
                            data = data.kelas;
                        }
                    })
                });
            });

            // export pilih excel
            $('#excel').on('click', function() {
                let ids = [];
                //Empty out the box first
                $.each(datatable.rows('.datatable-row-active').
                nodes().find('.checkbox > [type="checkbox"]'), (i, e) => {
                     ids.push($(e).val());
                });

                var c = document.createDocumentFragment();

                var link = document.createElement("a");

                link.setAttribute('method', 'GET');
                link.setAttribute('href', 'http://127.0.0.1:8000/admin/guru/pilih_excel/id_guru=' + ids);

                c.appendChild(link);

                link.dispatchEvent(
                    new MouseEvent('click', {
                      bubbles: true,
                      cancelable: true,
                      view: window
                    })
                  );
            });

            $('#kt_datatable_fetch_modal2').on('show.bs.modal', function(e) {
                var ids = datatable.rows('.datatable-row-active').
                nodes().
                find('.checkbox > [type="checkbox"]').
                map(function(i, chk) {
                    return $(chk).val();
                });
                console.log(ids);
                var c = document.createDocumentFragment();
                for (var i = 0; i < ids.length; i++) {
                    var li = document.createElement('input');
                    li.setAttribute('name', 'ids[]');
                    li.setAttribute('value', ids[i]);
                    li.innerHTML = 'Selected record ID: ' + ids[i];
                    c.appendChild(li);
                }
                $('#kt_datatable_fetch_display2').append(c);
            }).on('hide.bs.modal', function(e) {
                $('#kt_datatable_fetch_display2').empty();
            });
    };
    
    return {
        // public functions
        init: function () {
            demo();
        }
    };
}();

jQuery(document).ready(function () {
    KTDatatableJsonRemoteDemo.init();
});

// var KTDatatableRecordSelectionDemo = function () {
//     // Private functions

//     var options = {
//         // datasource definition
//         data: {
//             type: 'remote',
//             source: {
//                 read: {
//                     url: HOST_URL + '/admin/guru/data',
//                 },
//             },
//             pageSize: 10,
//             serverPaging: true,
//             serverFiltering: true,
//             serverSorting: true,
//         },

//         // layout definition
//         layout: {
//             scroll: false, // enable/disable datatable scroll both horizontal and
//             footer: false // display/hide footer
//         },

//         // column sorting
//         sortable: true,

//         pagination: true,

//         // columns definition
//         columns: [{
//             field: 'id',
//             title: '#',
//             sortable: false,
//             width: 20,
//             selector: {
//                 class: ''
//             },
//             textAlign: 'center',
//         }, {
//             field: 'nama_guru',
//             title: 'Guru',
//             width: 250,
//             template: function (data) {
//                 var _number = KTUtil.getRandomInt(1, 14);
//                 var user_img = 'background-image:url(\'assets/media/guru/' + data.foto + '\')';                

//                 var output = '';
//                 output = '<div class="d-flex align-items-center">\
//                         <div class="symbol symbol-40 flex-shrink-0">\
//                             <div class="symbol-label" style="' + user_img + '"></div>\
//                         </div>\
//                         <div class="ml-2">\
//                             <a href="admin/siswa/profil" class="text-dark-75 font-weight-bold line-height-sm text-hover-primary">' + data.nama_guru + '</a>\
//                             <br>\
//                             <a href="amdin/sekolah/' + data.id_sekolah + '" class="font-size-sm text-dark-50 text-hover-primary">' + data.nama_sekolah + '</a>\
//                         </div>\
//                     </div>';

//                 return output;
//             },
//         }, {
//             field: 'alamat',
//             title: 'Alamat',
//         }, {
//             field: 'tlpn',
//             title: 'No.Telepon',
//         }, {
//             field: '',
//             title: 'Aksi',
//             sortable: false,
//             width: 125,
//             overflow: 'visible',
//             textAlign: 'left',
//             autoHide: false,
//             template: function (data) {
//                 return '\
//                     <a href="#" data-toggle="modal" onclick="getData(' + data.id + ')" id="edit" class="btn btn-sm btn-clean btn-icon mr-2 editbtn" title="Edit">\
//                         <span class="svg-icon svg-icon-md">\
//                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
//                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
//                                     <rect x="0" y="0" width="24" height="24"/>\
//                                     <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
//                                     <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
//                                 </g>\
//                             </svg>\
//                         </span>\
//                     </a>\
//                     <a href="#"  data-toggle="modal" onclick="deleteEmployee(' + data.id + ')" data-original-title="Delete" class="btn btn-sm btn-clean btn-icon delete " id="kt_sweetalert_demo_8" title="Hapus">\
//                         <span class="svg-icon svg-icon-md">\
//                             <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
//                                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
//                                     <rect x="0" y="0" width="24" height="24"/>\
//                                     <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
//                                     <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
//                                 </g>\
//                             </svg>\
//                         </span>\
//                     </a>\
//     ';
//             },
//             // data-id="' + data.id +'"
//             // onclick ="deleteData(' + data.id + ')"
//         }],
//     };

//     // console.log();

//     // basic demo
//     var localSelectorDemo = function () {
//         // enable extension
//         options.extensions = {
//             // boolean or object (extension options)
//             checkbox: true,
//         };

//         options.search = {
//             input: $('#kt_datatable_search_query'),
//             // key: 'generalSearch'
//         };

//         var datatable = $('#kt_datatable').KTDatatable(options);

//         $('#search_sekolah').on('change', function (e) {
//             datatable.search($(this).val().toLowerCase(), 'nama_sekolah');
//         });
//         $('#kt_datatable_search_ajaran').on('change', function () {
//             datatable.search($(this).val().toLowerCase(), 'Sekolah');
//         });
//         $('#kt_datatable_search_angkatan').on('change', function () {
//             datatable.search($(this).val().toLowerCase(), 'angkatan');
//         });
//         $('#kt_datatable_search_kelas').on('change', function () {
//             datatable.search($(this).val().toLowerCase(), 'Sekolah');
//         });

//         $('#kt_datatable_search_sekolah, #kt_datatable_search_ajaran, #kt_datatable_search_angkatan, #kt_datatable_search_kelas').selectpicker();

//         datatable.on(
//             'datatable-on-check datatable-on-uncheck',
//             function (_e) {
//                 var checkedNodes = datatable.rows('.datatable-row-active').nodes();
//                 var count = checkedNodes.length;
//                 $('#kt_datatable_selected_records').html(count);
//                 if (count > 0) {
//                     $('#kt_datatable_group_action_form').collapse('show');
//                 } else {
//                     $('#kt_datatable_group_action_form').collapse('hide');
//                 }
//             });
//     };

//     return {
//         // public functions
//         init: function () {
//             localSelectorDemo();
//         },
//     };
// }();

jQuery(document).ready(function () {
    KTDatatableRecordSelectionDemo.init();
});

// Get Data
function getData(id){
    let url = HOST_URL + '/admin/guru/edit/' + id;
    $.ajax({
        url: url,
        method: "POST",
        dataType: 'json',
        success: function(response){
            let _data_siswa = response['0'];
            let id = $('#id');
            let nam = $('#nama1');
            let alamat = $('#alamat1');
            let tlpn = $('#tlpn1');
            let em = $('#email1');
            let bank = $('#bank1');
            let rek = $('#rek');
            let pass = $('#password1');
            let foto = $('#gambar');
            let sek = $('#sekolah');

            id.val(response.guru.id);
            nam.val(response.guru.nama_guru);
            alamat.val(response.guru.alamat);
            tlpn.val(response.guru.tlpn);
            em.val(response.guru.email);
            bank.val(response.guru.bank);
            rek.val(response.guru.rekening);
            pass.val(response.guru.password);
            sek.val(response.guru.id_sekolah);
            var user_img = 'background-image:url(\'assets/media/guru/' + response.guru.foto + '\')';
            foto.attr('style', user_img);

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
                    url: "/delete/guru/" + id,
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
            $('#GuruForm').modal('hide');
            // location.reload();
        },
        data: (function (){
            let data = new FormData();
            data.append('nama_guru' ,$('#nama').val());
            data.append('alamat' ,$('#alamat').val());
            data.append('tlpn' ,$('#tlpn').val());
            data.append('bank' ,$('#bank').val());
            data.append('rekening' ,$('#rekening').val());
            data.append('email' ,$('#email').val());
            data.append('id_sekolah' ,$('#id_sekolah').val());
            data.append('password' ,$('#password').val());
            data.append('foto' ,$('#foto').get(0).files[0]);
            return data;
        })()
    });
    return false;
}

function sendData(){
    let url = 'update/guru' ;
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
            data.append('id' ,$('#id').val());
            data.append('nama_guru' ,$('#nama1').val());
            data.append('alamat' ,$('#alamat1').val());
            data.append('tlpn' ,$('#tlpn1').val());
            data.append('bank' ,$('#bank1').val());
            data.append('rek' ,$('#rek').val());
            data.append('sekolah' ,$('#sekolah').val());
            if ($('#foto1').get(0).files[0] !== undefined) {
                data.append ('foto' ,$('#foto1').get(0).files[0]);
            }
           return data;
        })()
    });
}

$(
    function(){
        $('#GuruForm').on('submit',(e) => {
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
                    
        $('#GuruForm_update').on('submit',(e) => {
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