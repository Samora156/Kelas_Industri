"use strict";
// Class definition

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Get Data
function getData(id){
    let url = HOST_URL + '/admin/sekolah/edit/' + id;
    $.ajax({
        url: url,
        method: "POST",
        dataType: 'json',
        success: function(response){
            let _data_siswa = response['0'];
            let id = $('#id');
            let nam = $('#nama1');
            let logo = $('#gambar');
            let kepsek = $('#kepala_sekolah1');
            let email = $('#email1');
            let telp = $('#telp1');
            let alamat = $('#alamat1');

            id.val(response.sekolah.id);
            nam.val(response.sekolah.nama_sekolah);
            alamat.val(response.sekolah.alamat);
            kepsek.val(response.sekolah.kepala_sekolah);
            email.val(response.sekolah.email_sekolah);
            telp.val(response.sekolah.telp_sekolah);
            var user_img = 'background-image:url(\'assets/media/sekolah/' + response.sekolah.logo + '\')';
            logo.attr('style', user_img);

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
                    url: "/delete/sekolah/" + id,
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
            $('#SekolahForm').modal('hide');
            location.reload();
        },
        data: (function (){
            let data = new FormData();
            data.append('nama_sekolah' ,$('#nama').val());
            data.append('alamat' ,$('#alamat').val());
            data.append('kepala_sekolah' ,$('#kepala_sekolah').val());
            data.append('email_sekolah' ,$('#email').val());
            data.append('telp_sekolah' ,$('#telp').val());
            data.append('foto' ,$('#foto').get(0).files[0]);
            return data;
        })()
    });
    return false;
}

function sendData(){
    let url = 'update/sekolah' ;
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
            data.append('nama' ,$('#nama1').val());
            data.append('alamat' ,$('#alamat1').val());
            data.append('kepala_sekolah' ,$('#kepala_sekolah1').val());
            data.append('email' ,$('#email1').val());
            data.append('telp' ,$('#telp1').val());
            if ($('#foto1').get(0).files[0] !== undefined) {
                data.append ('foto' ,$('#foto1').get(0).files[0]);
            }
           return data;
        })()
    });
}

$(
    function(){
        $('#SekolahForm').on('submit',(e) => {
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
                    
        $('#SekolahForm_update').on('submit',(e) => {
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