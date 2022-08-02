@extends('layout.detail') 

{{-- @section('title', 'Siswa') --}}

@section('content')
    <div class="content  d-flex flex-column flex-column-fluid" id=kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
            <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">

                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                        Siswa </h5>
                    <!--end::Title-->

                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200">
                    </div>
                    <!--end::Separator-->

                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                            Guru </span>
                    </div>
                    <!--end::Search Form-->
                </div>

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
                    <form id="KelasForm_update" name="KelasForm_update" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" id="id">
                            @foreach ($sekolah as $se)
                                <input type="hidden" name="sekolah" id="sekolah" value="{{ $se->id }}">
                            @endforeach
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="nama1" name="nama1" placeholder="Masukan Nama Siswa"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="exampleSelect1">Tahun Ajaran</label>
                                <div class="col-10">
                                    <select class="form-control" name="angkatan" id="angkatan">
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
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
        <div class="modal fade" id="kelasModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <!--begin::Form-->
                    <form id="KelasForm" name="KelasForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @foreach ($sekolah as $se)
                        <input type="hidden" name="id_sekolah" id="id_sekolah" value="{{ $se->id }}">
                    @endforeach
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Nama</label>
                                <div class="col-10">
                                    <input class="form-control" type="text" value="" id="nama" name="nama" placeholder="Masukan Nama Guru"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label" for="exampleSelect1">Tahun Ajaran</label>
                                <div class="col-10">
                                    <select class="form-control" name="angkatan1" id="angkatan1">
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
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

        <!--end::Subheader-->

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container ">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <!--begin: Selected Rows Group Action Form-->
                        <div class="mb-5 collapse" id="kt_datatable_group_action_form">
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-danger mr-3">
                                    Dipilih <span id="kt_datatable_selected_records">0</span> :
                                </div>

                                <div class="dropdown mr-2">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        data-toggle="dropdown">
                                        Ubah Angkatan
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-sm">
                                        <ul class="nav nav-hover flex-column">
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <span class="nav-text">10</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <span class="nav-text">11</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link">
                                                    <span class="nav-text">12</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-danger mr-2" type="button" id="kt_datatable_delete_all">
                                    Hapus Semua
                                </button>
                            </div>
                        </div>
                        <!--end: Selected Rows Group Action Form-->

                        <!--begin: Datatable-->
                        <!--begin::Card-->
                        @foreach ($sekolah as $s)
                            
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="row">
                                        <div class="symbol symbol-60  symbol-xl-130">
                                            <div class="symbol-label" style="background-image:url('assets/media/sekolah/{{ $s->logo }}')"></div>
                                        </div>
                                        <div class="col">
                                            <h3 class="card-label">
                                                {{ $s->nama_sekolah }}
                                            </h3>
                                            <div class="d-flex flex-grow-1 align-items-center mt-1 fs-6 rounded text-md">
                                                <div class="mr-4 flex-shrink-0 text-center" style="width: 10px;">
                                                    <i class="icon-md far fa-user"></i>
                                                </div>
                                                <div class="text-muted font-size-h6">
                                                    {{ $s->kepala_sekolah }}				 
                                                </div>
                                            </div>
                                            <div class="d-flex flex-grow-1 align-items-center mt-1 fs-6 rounded text-md">
                                                <div class="mr-4 flex-shrink-0 text-center" style="width: 10px;">
                                                    <i class="fa fa-envelope-open-text"></i>
                                                </div>
                                                <div class="text-muted font-size-h6 font-size-h6">
                                                    {{ $s->email_sekolah }}				 
                                                </div>
                                            </div>
                                            <div class="d-flex flex-grow-1 align-items-center mt-1 fs-6 rounded text-md">
                                                <div class="mr-4 flex-shrink-0 text-center" style="width: 10px;">
                                                    <i class="fa la-phone"></i>
                                                </div>
                                                <div class="text-muted font-size-h6 font-size-h6">
                                                    {{ $s->telp_sekolah }}				 
                                                </div>
                                            </div>
                                            <div class="d-flex flex-grow-1 align-items-center mt-1 fs-6 rounded text-md">
                                                <div class="mr-4 flex-shrink-0 text-center" style="width: 10px;">
                                                    <i class="fa flaticon-placeholder-2"></i>
                                                </div>
                                                <div class="text-muted font-size-h6 font-size-h6">
                                                    {{ $s->alamat }}				 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--begin::Items-->
                            <div class="d-flex align-items-center flex-wrap mt-8">

                            <!--begin::Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon2-user-outline-symbol display-4 text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Guru</span>
                                        <span class="font-weight-bolder font-size-h5">
                                        <span class="text-dark-50 font-weight-bold"></span>{{count($guru)}}</span>
                                    </div>
                                </div>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon2-user-outline-symbol display-4 text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Siswa</span>
                                        <span class="font-weight-bolder font-size-h5">
                                        <span class="text-dark-50 font-weight-bold"></span>{{ count($siswa) }}</span>
                                    </div>
                                </div>
                                <!--end::Item-->

                                <!--begin::Item-->
                                <div class="d-flex align-items-center flex-lg-fill mr-5 mb-2">
                                    <span class="mr-4">
                                        <i class="flaticon2-schedule display-4 text-muted font-weight-bold"></i>
                                    </span>
                                    <div class="d-flex flex-column text-dark-75">
                                        <span class="font-weight-bolder font-size-sm">Kelas</span>
                                        <span class="font-weight-bolder font-size-h5">
                                        <span class="text-dark-50 font-weight-bold"></span>{{ count($kelas) }}</span>
                                    </div>
                                </div>
                                <!--end::Item-->
                            </div>
                        <!--begin::Items-->
                        </div>
                    </div>
                    @endforeach
			        <!--end::Card-->
                    </div>
                </div>
                <!--end::Card-->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-custom card-stretch">
                            <div class="card-header flex-wrap py-3">
                                <div class="card-title">
                                    <h3 class="card-label">Data Siswa 
                                    <span class="d-block text-muted pt-2 font-size-sm">
                                        {{-- @foreach ($kategoris as $kategori)
                                            {{$kategori->nama}} ({{$kategori->total}}
                                        @endforeach --}}
                                    </span></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">                                    
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Kelas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $s)
                                            <tr>
                                                <td><div class="d-flex align-items-center">
                                                    <div class="symbol symbol-40 flex-shrink-0">
                                                        <div class="symbol-label" style="background-image:url('assets/media/siswa/{{ $s->foto }}')"></div>
                                                    </div>
                                                    <div class="ml-2">
                                                        <a href="admin/siswa/profil" class="text-dark-75 font-weight-bold line-height-sm text-hover-primary">{{ $s->nama }}</a>
                                                    </div>
                                                </div></td>
                                                <td>{{ $s->tahun_ajaran }}</td>
                                                <td>{{ $s->nama_kelas }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                          
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-custom card-stretch">
                            <div class="card-header flex-wrap py-3">
                                <div class="card-title">
                                    <h3 class="card-label">Data Guru
                                    <span class="d-block text-muted pt-2 font-size-sm">
                                        {{-- @foreach ($kategoris as $kategori)
                                            {{$kategori->nama}} ({{$kategori->total}}
                                        @endforeach --}}
                                    </span></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_2">                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Bank</th>
                                            <th>No Rekening</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($guru as $g)
                                            <tr>
                                                <td>{{ $g->nama_guru }}</td>
                                                <td>{{ $g->bank }}</td>
                                                <td>{{ $g->rekening }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach ($sekolah as $s)
                                
                <div class="card card-custom mt-5">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Data Kelas 
                            <span class="d-block text-muted pt-2 font-size-sm">
                                {{-- @foreach ($kategoris as $kategori)
                                    {{$kategori->nama}} ({{$kategori->total}}
                                @endforeach --}}
                            </span></h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <a href="javascript:void(0)"  onclick="$('#kelasModal').modal('show')" class="btn btn-primary font-weight-bolder">
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
                    </div>
                    <div class="card-body">
                        <!--begin::Items-->
                        <table class="table table-separate table-head-custom table-checkable text-center" id="kt_datatable_2">                                    
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama </th>
                                    <th>Angkatan</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($kelas as $k)
                                    @foreach ($sekolah as $sek)
                                        @php
                                        $hitungSiswa = DB::table('siswas')
                                        ->where('id_kelas', $k->id)
                                        ->where('id_sekolah', $sek->id)
                                        ->get();
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $k->nama_kelas }}</td>
                                        <td>{{ $k->angkatan }}</td>
                                        <td>{{ count($hitungSiswa) }}</td>
                                        <td><a href="#" data-toggle="modal" onclick="getData({{ $k->id }})" id="edit" class="btn btn-sm btn-clean btn-icon mr-2 editbtn" title="Edit">
                                            <span class="svg-icon svg-icon-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"/>
                                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                        <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                        <a href="#"  data-toggle="modal" onclick="deleteEmployee({{ $k->id }})" data-original-title="Delete" class="btn btn-sm btn-clean btn-icon delete " id="kt_sweetalert_demo_8" title="Hapus">
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
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                     <!--begin::Items-->
                    </div>
                </div>
            @endforeach
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection


@push('script')
    <!--begin::Page Scripts(used by this page)-->
    <script src="assets/js/pages/crud/file-upload/image-input.js?v=7.0.6"></script>
    <script src="assets/js/datatables/detail_sekolah.js?v=7.0.6"></script>
    <!--end::Page Scripts-->
@endpush 
