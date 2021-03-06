@extends('index')

@section('contentheader_title','Master Produk')

@section('customcss')
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/datatables/jquery.dataTables.min.css') }}">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.css" rel="stylesheet">
@endsection

@section('content')
<!-- Default box -->
    <div class="box box-primary">
        <div class="box-body">
        
             <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            
            <div>
                <button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modal-insert">
                    <span class="fa fa-plus"></span> Tambah Data
                </button>
            </div>

            <br>

           <div class="table">
               <table class="table table-striped table-hover table-responsive" id="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th class="text-center nosort">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $result)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ ucfirst($result->product) }}</td>
                            <td>Rp. {{ number_format($result->price,0,'.','.') }}</td>
                            <td>{{ $result->stock }}</td>
                            <td>{!! str_limit($result->description,25,' ...') !!}</td>
                            <td>
                                <a href="{{ route('product.show', $result->id) }}" class="btn btn-primary btn-xs">
                                    <span class="fa fa-external-link"></span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    {!! $products->links() !!}
                </div>
            </div>
            <!-- Modal insert-->
            <div id="modal-insert" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Tambah Data</h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('products.store') }}" method="post" class="form" enctype="multipart/form-data">

                                @csrf

                                <div class="form-group">
                                    <label for="">Nama Produk <span class="label-required">*</span></label>
                                    <input type="text" name="product" class="form-control input-sm" placeholder="Nama Produk..." required maxlength="60" value="{{ old('product') }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Harga <span class="label-required">*</span></label>
                                    <input type="number" name="price" class="form-control input-sm" placeholder="Harga Produk..." required min="0" max="9999999999" value="{{ old('price') }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Stok <span class="label-required">*</span></label>
                                    <input type="number" name="stock" class="form-control input-sm" placeholder="Stok Produk..." required min="0" max="9999999999" value="{{ old('stock') }}">
                                </div>

                                <div class="form-group">
                                    <label for="">Gambar</label>
                                    <input type="file" name="images[]" id="images" class="form-control input-sm" multiple accept="images/*">
                                </div>

                                <div class="form-group">
                                    <label for="">Deskripsi</label>
                                    <textarea id="summernote" class="summernote form-control" name="description">{{ old('description') }}</textarea>
                                </div>

                                <hr>
                                <input type="submit" value="Simpan" class="btn btn-success btn-md">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
<!-- /.box -->
@endsection
@section('customscript')
    <script type="text/javascript" src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $('#summernote').summernote();
        });
    </script>
@endsection