@extends('layout.app')

{{-- @section('title', 'Siswa') --}}

@section('content')
    <div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">

                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                            {{ count($sekolah) }}  Sekolah 
                    </h5>
                    <!--end::Title-->

                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200">
                    </div>
                    <!--end::Separator-->

                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                            {{-- {{ $sekolah }} Orang </span> --}}
                    </div>
                    <!--end::Search Form-->
                </div>
                <!--end::Details-->

                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Actions-->
                    <a href="javascript:void(0)"  onclick="$('#sekolahModal').modal('show')" class="btn btn-primary font-weight-bolder">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo13/dist/assets/media/svg/icons/Design/Flatten.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24" />
                                    <circle fill="#000000" cx="9" cy="15" r="6" />
                                    <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>New Record</a>
                    <!--end::Button-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>

        <!-- Modal Update-->
        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header"> 
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <!--begin::Form-->
                    <form id="SekolahForm_update" name="SekolahForm_update" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label ">Foto Siswa</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="image-input image-input-outline" id="kt_image_1">
                                    <div class="image-input-wrapper" id="gambar" style="background-image: url(assets/media/users/blank.png)"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="foto1" id="foto1" accept=".png, .jpg, .jpeg"/>
                                        <input type="hidden" name="profile_avatar_remove"/>
                                    </label>

                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                                <span class="form-text text-muted">Allowed file types:  png, jpg, jpeg.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="nama1" name="nama1" placeholder="Masukan Nama Siswa"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Kepala Sekolah</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="kepala_sekolah1" name="kepala_sekolah1" is-invalid placeholder="Masukan Nama Kepala Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="email1" name="email1" is-invalid placeholder="Masukan Email Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">No Telepone</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="telp1" name="telp1" is-invalid placeholder="Masukan Telepone Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="alamat1" name="alamat1" placeholder="Masukan Nama Siswa"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary font-weight-bold">Save</button>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
{{-- end modal --}}

<!-- Modal-->
    <div class="modal fade" id="sekolahModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin::Form-->
                <form id="SekolahForm" name="SekolahForm" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label ">Logo</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="image-input image-input-outline" id="kt_image_4">
                                    <div class="image-input-wrapper" style="background-image: url(assets/media/users/default.jpg)"></div>
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="foto" id="foto" />
                                        <input type="hidden" name="profile_avatar_remove"/>
                                    </label>
                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="nama" name="nama" is-invalid placeholder="Masukan Nama Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Kepala Sekolah</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="kepala_sekolah" name="kepala_sekolah" is-invalid placeholder="Masukan Nama Kepala Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="email" name="email" is-invalid placeholder="Masukan Email Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">No Telepone</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="telp" name="telp" is-invalid placeholder="Masukan Telepone Sekolah"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="alamat" name="alamat" placeholder="Masukan Alamat Sekolah"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Batal</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary font-weight-bold">Save</button>
                    </div>
                </div>
            </form>
        <!--end::Form-->
        </div>
    </div>
{{-- end modal --}}

<!--begin::Entry-->
    <div class="container">
        <div class="row">
            @if (count($sekolah) == 0)
                Belum Ada Sekolah
            @endif

            @foreach ($sekolah as $s)
            @php
                $hitungSiswa = DB::table('siswas')
                    ->where('id_sekolah', $s->id)
                    ->get();
                $hitungKelas = DB::table('kelas')
                    ->where('id_sekolah', $s->id)
                    ->get();
                $hitungGuru = DB::table('gurus')
                    ->where('id_sekolah', $s->id)
                    ->get();
            @endphp
            <div class="col-lg-4 mt-5">
                <!--begin::Card-->
                <div class="card card-custom card-stretch">
                    <div class="card-header">
                        <div class="row mt-2">
                            <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                                <div class="symbol-label" style="background-image:url('assets/media/sekolah/{{ $s->logo }}')"></div>
                            </div>
                            <div class="ml-2">
                                <div class="font-weight-bolder font-size-h5 text-dark-75 ">
                                    {{ $s->nama_sekolah }}
                                </div>
                                <div class="text-muted">
                                    {{ $s->alamat }}
                                </div>
                            </div>
                            <a href="#"  data-toggle="modal" onclick="deleteEmployee({{ $s->id }})" data-original-title="Delete" class="btn btn-sm btn-clean btn-icon delete ml-5" id="kt_sweetalert_demo_8" title="Hapus">
                                <span class="svg-icon svg-icon-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                            <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </div>
                        <div class="my-2 row justify-content-between mx-15">
                            <div class="mx-3">
                                <div class="font-weight-bolder text-dark-75">Kelas</div>
                                <title class="btn btn-light-danger font-weight-bold mr-2">{{ count($hitungKelas) }}</title>
                            </div>
                            <div class="mx-3">
                                <div class="font-weight-bolder text-dark-75">Guru</div>
                                <title class="btn btn-light-success font-weight-bold mr-2">{{ count($hitungGuru) }}</title>
                            </div>
                            <div class="mx-3">
                                <div class="font-weight-bolder text-dark-75">Siswa</div>                                    
                                <title class="btn btn-light-primary font-weight-bold mr-2">{{ count($hitungSiswa) }}</title>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="#" data-toggle="modal" onclick="getData({{ $s->id }})" id="edit" class="btn btn-sm txt-light-primary btn-clean btn-icon editbtn card-label" title="Edit">
                                <span class="svg-icon svg-icon-md mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26px" height="26px" viewBox="0 0 22 22" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                        </g>
                                    </svg>
                                </span>EDIT
                            </a>
                            <div class="card-toolbar">
                                <a href="admin/sekolah/{{ $s->id }}" class="btn btn-light-primary font-weight-bold mr-2">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            <!--end::Card-->
            </div>
            @endforeach
        </div>
    </div>
<!--end::Entry-->
</div>
@endsection

@push('script')
    <script src="assets/js/datatables/sekolah.js?v=7.0.6"></script>
    <script src="assets/js/pages/crud/file-upload/image-input.js?v=7.0.6"></script>
@endpush 
