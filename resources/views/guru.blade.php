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
                        {{ $jumlah }} Guru </h5>
                    <!--end::Title-->

                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200">
                    </div>
                    <!--end::Separator-->

                    <!--begin::Search Form-->
                    <div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                             </span>
                    </div>
                    <!--end::Search Form-->

                    <div class="d-flex align-items-center">
                        <!--begin::Actions-->
                        <button type="button" class="btn btn-light-success font-weight-bolder mr-2" data-toggle="modal"
                            data-target="#exampleModal">
                            Import
                        </button>
                        <!--end::Actions-->
    
                        <!--begin::Button-->
                        <!--end::Button-->
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="exampleModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin::Form-->
                <form action="admin/import/guru" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        Gunakan template spreadsheet yang telah disediakan berikut untuk dapat menggunakan fitur import
                        data guru.
                        <div>
                            <a target="_blank"
                                href="https://docs.google.com/spreadsheets/d/1jGZJEipeYMk1kzdVQzV_1l1waZ6kJK1qKC5jpI6ralk/edit?usp=sharing"
                                class="btn btn-info btn-sm font-weight-bold mt-2 mb-10">Download Template</a>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" value="default.jpg" name="foto">
                            <label class="col-3">Sekolah</label>
                            <div class="col-9">
                                <select class="form-control form-control-solid" name="sekolah_id" id="import_sekolah">
                                    <option selected>Pilih:</option>
                                    @foreach ($sekolah as $s )
                                        <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">Kelas</label>
                            <div class="col-9">
                                <select class="form-control form-control-solid" name="kelas_id" id="import_kelas">
                                    <option selected>Pilih:</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-3">File</label>
                            <div class="col-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="file" accept=".csv,.xlsx">
                                    <label class="custom-file-label form-control form-control-solid">.csv atau
                                        .xlsx</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">Import</button>
                    </div>
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>

        <!-- Modal Update-->
        <div class="modal fade" id="editModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin::Form-->
                <form id="GuruForm_update" name="GuruForm_update" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Foto Guru</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="image-input image-input-outline" id="kt_image_4">
                                    <div class="image-input-wrapper" id="gambar" style="background-image: url(assets/media/users/default.jpg)"></div>
            
                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                        <input type="file" name="foto1" id="foto1" />
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
                                <input class="form-control" type="text" value="" id="nama1" name="nama1" placeholder="Masukan Nama Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="alamat1" name="alamat1" placeholder="Masukan Alamat Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Bank</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="bank1" name="bank1" placeholder="Masukan Alamat Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">No Rekening</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="rek" name="rek" placeholder="Masukan Alamat Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">No. Telepon</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="tlpn1" name="tlpn1" placeholder="Masukan Telepon Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="exampleSelect1">Sekolah</label>
                            <div class="col-10">
                                <select class="form-control" name="sekolah" id="sekolah">
                                    @foreach ($sekolah as $s )
                                            <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>                                        
                                    @endforeach                                    </select>
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
        <div class="modal fade" id="guruModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <!--begin::Form-->
                <form id="GuruForm" name="GuruForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label text-right">Foto Guru</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="image-input image-input-outline" id="kt_image_1">
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
                                <input class="form-control" type="text" value="" id="nama" name="nama" is-invalid placeholder="Masukan Nama Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="alamat" name="alamat" placeholder="Masukan Alamat Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">No. Telepon</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="tlpn" name="tlpn" placeholder="Masukan Telepon Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Bank</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="bank" name="bank" placeholder="Masukan Telepon Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Rekening</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="" id="rekening" name="rekening" placeholder="Masukan Telepon Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label" for="exampleSelect1">Sekolah</label>
                            <div class="col-10">
                                <select class="form-control" name="id_sekolah" id="id_sekolah">
                                    @foreach ($sekolah as $s )
                                            <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>                                        
                                    @endforeach                                    </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" type="email" id="email" name="email" placeholder="Email Guru"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-email-input" class="col-2 col-form-label">Password</label>
                            <div class="col-10">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password Guru"/>
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
                <div class="card card-custom gutter-b mb-7">

                    <div class="card-body">
                        <!--begin: Search Form-->
                        <!--begin::Search Form-->
                        <div class="row align-items-center">

                            <div class="col-md-3 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Sekolah:</label>
                                    <select class="form-control" id="search_sekolah">
                                        <option value="">Semua</option>
                                        @foreach ($sekolah as $s)
                                            <option value="{{ $s->nama_sekolah }}">{{ $s->nama_sekolah }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center my-2 my-md-0">
                                <div class="col-md-12 my-2 my-md-0">
                                    <div class="input-icon">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            id="kt_datatable_search_query" />
                                        <span><i class="flaticon2-search-1 text-muted"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end::Search Form-->
                    </div>
                </div>
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <!--begin: Selected Rows Group Action Form-->
                        <div class="mb-5 collapse" id="kt_datatable_group_action_form">
                            <div class="d-flex align-items-center">
                                <div class="font-weight-bold text-danger mr-3">
                                    Dipilih <span id="kt_datatable_selected_records">0</span> :
                                </div>

                                <button class="btn btn-sm btn-primary mr-2" type="button" data-toggle="modal"
                                    data-target="#kt_datatable_fetch_modal">Ubah Data</button>

                                <button class="btn btn-sm btn-danger mr-2" type="button" data-toggle="modal"
                                    data-target="#kt_datatable_fetch_modal2">Hapus Siswa</button>
                                    <div class="card-toolbar">
                                        <!--begin::Dropdown-->
                                        <div class="dropdown dropdown-inline mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="svg-icon svg-icon-md">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo13/dist/assets/media/svg/icons/Design/PenAndRuller.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
                                                        <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>Export</button>
                                            <!--begin::Dropdown Menu-->
                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                <!--begin::Navigation-->
                                                <ul class="navi flex-column navi-hover py-2">
                                                    <li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
                                                    <li class="navi-item">
                                                        <a href="javascript:void(0)" class="navi-link" id="excel">
                                                            <span class="navi-icon">
                                                                <i class="la la-file-excel-o"></i>
                                                            </span>
                                                            <span class="navi-text">Excel</span>
                                                        </a>
                                                    </li>
                                                    <li class="navi-item">
                                                        <a href="javascript:void(0)" class="navi-link" id="pdf">
                                                            <span class="navi-icon">
                                                                <i class="la la-file-pdf-o"></i>
                                                            </span>
                                                            <span class="navi-text">PDF</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <!--end::Navigation-->
                                            </div>
                                            <!--end::Dropdown Menu-->
                                        </div>
                                        <!--end::Dropdown-->
                                </div>
                            </div>
                        </div>
                        <!--end: Selected Rows Group Action Form-->

                        <div class="modal fade" id="kt_datatable_fetch_modal2" data-backdrop="static" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="admin/guru/hapus" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Hapus Guru</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul id="kt_datatable_fetch_display2" hidden></ul>
                                            Apakah Anda yakin untuk menghapus data guru?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-danger font-weight-bold"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger font-weight-bold">Hapus</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!--begin: Datatable-->
                        <!--begin::Card-->
								<div class="card card-custom gutter-b">
									<div class="card-header flex-wrap py-3">
										<div class="card-title">
											<h3 class="card-label">Data Guru
											<span class="d-block text-muted pt-2 font-size-sm">
                                                {{-- @foreach ($kategoris as $kategori)
                                                    {{$kategori->nama}} ({{$kategori->total}}
                                                @endforeach --}}
                                            </span></h3>
										</div>
										<div class="card-toolbar">
											<!--begin::Dropdown-->
											<div class="dropdown dropdown-inline mr-2">
												<button type="button" class="btn btn-light-primary font-weight-bolder dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="svg-icon svg-icon-md">
													<!--begin::Svg Icon | path:/metronic/theme/html/demo13/dist/assets/media/svg/icons/Design/PenAndRuller.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
															<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
														</g>
													</svg>
													<!--end::Svg Icon-->
												</span>Export</button>
												<!--begin::Dropdown Menu-->
												<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
													<!--begin::Navigation-->
													<ul class="navi flex-column navi-hover py-2">
														<li class="navi-header font-weight-bolder text-uppercase font-size-sm text-primary pb-2">Choose an option:</li>
														<li class="navi-item">
															<a href="/admin/guru/excel" class="navi-link" id="download">
																<span class="navi-icon">
																	<i class="la la-file-excel-o"></i>
																</span>
																<span class="navi-text">Excel</span>
															</a>
														</li>
														<li class="navi-item">
															<a href="/admin/guru/export" class="navi-link" >
																<span class="navi-icon">
																	<i class="la la-file-pdf-o"></i>
																</span>
																<span class="navi-text">PDF</span>
															</a>
														</li>
													</ul>
													<!--end::Navigation-->
												</div>
												<!--end::Dropdown Menu-->
											</div>
											<!--end::Dropdown-->
											<!--begin::Button-->
											<a href="javascript:void(0)"  onclick="$('#guruModal').modal('show')" class="btn btn-primary font-weight-bolder">
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
										<!--begin: Datatable-->
										<!--begin: Datatable-->
										<div class="datatable datatable-bordered datatable-head-custom " id="kt_datatable">
										</div>
										<!--end: Datatable-->
										<!--end: Datatable-->
									</div>
								</div>
								<!--end::Card-->
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection


@push('script')
    <script>
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('#import_sekolah').on('change', function(e) {
                var id_sekolah = e.target.value;
                $.ajax({
                    url: "admin/guru/kelas",
                    type: "POST",
                    data: {
                        id_sekolah: id_sekolah
                    },
                    success: function(data) {
                    data = data.kelas;
                    $('#import_kelas').empty();
                    if(data == ''){
                        $('#import_kelas').append('<option selected>belum ada kelas</option>');
                    } else {
                        $('#import_kelas').append('<option >Pilih :</option>');
                    }

                    for (let index = 0; index < data.length; ++index) {
                        const element = data[index];
                        $('#import_kelas').append('<option value="' + element.id +
                            '">' + element.nama_kelas + '</option>');
                    }
                }
                })
            });
        });
    </script>
    <!--begin::Page Scripts(used by this page)-->
    <script src="assets/js/datatables/guru.js?v=7.0.6"></script>
    <script src="assets/js/pages/crud/file-upload/image-input.js?v=7.0.6"></script>
    <!--begin::Page Scripts(used by this page)-->
    <!--end::Page Scripts-->
    <!--end::Page Scripts-->
@endpush 
