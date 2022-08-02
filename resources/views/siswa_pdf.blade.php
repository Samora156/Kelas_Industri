<!DOCTYPE html>
<html>
<head>
	<title>Data Siswa</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Sekolah</th>
				<th>Kelas</th>
				<th>Emial</th>
				{{-- <th>Pekerjaan</th> --}}
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($cetak as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->nama}}</td>
				<td>{{$p->nama_sekolah}}</td>
				<td>{{$p->nama_kelas}}</td>
				<td>{{$p->email}}</td>
				{{-- <td>{{$p->pekerjaan}}</td> --}}
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>