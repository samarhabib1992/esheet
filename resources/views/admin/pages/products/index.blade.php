@extends('admin.layouts.master')

@section('title', 'Products')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="align-items-center justify-content-between mb-4">
        <div class="row mt-5">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800 bold ">Products List</h1>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.products.create')}}" class="btn btn-primary  float-right">Add Product <i class="fas fa-plus-circle ml-2"></i></a>
            </div>
        </div>
    </div>
    <!-- Content Row -->
    <div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
             <div class="card-body">
                @if(isset($result) && $result->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Category</th>
                                    <th>Topic</th>
                                    <th>Price</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $row)
                                    <tr>
                                        <td> {{ $row->name ?? '' }} </td>
                                        <td> {{ $row->productType->name ?? '' }} </td> 
                                        <td> {{ $row->category->name ?? '' }} </td>
                                        <td> {{ $row->topic->name ?? '' }} </td>
                                        <td> {{ $row->price ?? '' }} </td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $row->id) }}" class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
                                            <a data-id="{{ $row->id ?? 0 }}" class="common-trash text-gray-600 ml-3" href="javascript:void(0);"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                          </tbody>
                        </table>
                        @include('partials._pagination', ['paginator' => $result])
                    </div>
                @else
                    @include('partials._no_record')
                @endif
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('.common-trash').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        confirmDelete('category', id,"{{route('admin.products.delete')}}");
    });
</script>
@endpush
