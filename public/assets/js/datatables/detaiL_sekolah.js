"use strict";
// Class definition
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
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
            let id = $('#id');
            let id_sekolah = $('#sekolah');
            let nama_kelas = $('#nama1');
            let angkatan = $('#angkatan');

            id.val(response.kelas.id);
            nama_kelas.val(response.kelas.nama_kelas);
            angkatan.val(response.kelas.angkatan);

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
                    url: "delete/kelas/" + id,
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
        url: "admin/kelas/tambah",
        method:'POST',
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,  
        complete: function(_data){
            $('#KelasForm').modal('hide');
            location.reload();
        },
        data: (function (){
            let data = new FormData();
            data.append('nama_kelas' ,$('#nama').val());
            data.append('angkatan' ,$('#angkatan1').val());
            data.append('id_sekolah' ,$('#id_sekolah').val());
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
           data.append('id' ,$('#id').val());
           data.append('id_sekolah' ,$('#sekolah').val());
           data.append('nama' ,$('#nama1').val());
           data.append('angkatan' ,$('#angkatan').val());
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