@extends('layout.app')

@section('content')
<main id="main" class="main">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="pagetitle">
      <h1>Data Tables</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Data</li>
          <li class="breadcrumb-item active">Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
{{-- DataTable --}}
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
                
              <h5 class="card-title">Data barang</h5>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                Tambah Data
              </button>

              {{-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> --}}

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>Deskripsi.</th>
                    <th>Harga</th>
                    {{-- <th data-type="date" data-format="YYYY/DD/MM">Start Date</th> --}}
                    <th>Kategory</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Gambar</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <tbody>
                    @if($barang->isNotEmpty())
                    @foreach ($barang as $barang )
                    <tr>
                        <td>{{ $barang->name }}</td>
                        <td>{{ $barang ->description  }}</td>
                        <td>{{ $barang ->price  }}</td>
                        <td>{{ $barang ->category }}</td>
                        <td>{{ $barang->stock }}</td>
                        <td>{{ $barang ->status }}</td>
                        <td><img src="/assets/img/barang/{{ $barang->gambar }}" alt="Cover Image" style="width: 100px; height: auto;"></td>
                        <td>
                        <!-- Edit Button -->
                        <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editBarangModal" data-id="{{ $barang->id }}">
                            Edit
                        </button>
                        
                            
                            <form action="{{ route('delete.barang', $barang->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">Hapus</button>
                            </form>

                        </td>
                    </tr>  
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data barang</td>
                    </tr>
                @endif
                    </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Modal -->

          <!-- add Modal -->
        <div class="modal fade" id="tambahBarangModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="tambahBarangForm" method="POST" action="{{ route('store.barang') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <input type="text" class="form-control" id="category" name="category">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <div class="mb-3">
                                <label for="image_url" class="form-label">Gambar</label>
                                <input type="file" class="form-control" id="image_url" name="gambar">
                            </div>
                            
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="available">Tersedia</option>
                                    <option value="unavailable">Tidak Tersedia</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="tambahBarangForm" class="btn btn-danger">Tambah Data</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Modal -->

     <!-- Modal Edit Barang -->
     <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBarangForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Gunakan metode PUT untuk update -->
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="edit-name" value="{{ $barang->name }}" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit-description" name="description">{{ $barang->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit-price" class="form-label">Harga</label>
                            <input type="number" step="0.01" class="form-control" id="edit-price" value="{{ $barang->price }}" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-category" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="edit-category" value="{{ $barang->category }}" name="category">
                        </div>
                        <div class="mb-3">
                            <label for="edit-stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="edit-stock" value="{{ $barang->stock }}" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="edit-gambar" name="gambar">
                        </div>
                        <div class="mb-3">
                            <label for="edit-status" class="form-label">Status</label>
                            <select class="form-select" id="edit-status" name="status">
                                <option value="available">Tersedia</option>
                                <option value="unavailable">Tidak Tersedia</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="editBarangForm" class="btn btn-danger">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
</div>






    

</main><!-- End #main -->
        <script>

    </script>



@endsection