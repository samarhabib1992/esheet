@extends('admin.layouts.master')

@section('title', 'Blog Post')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="align-items-center justify-content-between mb-4">
        <div class="row mt-5">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800 bold ">Blog</h1>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.blog.create')}}" class="btn btn-primary  float-right">Add Blog Post <i class="fas fa-plus-circle ml-2"></i></a>
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
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Author Name</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $row)
                                    <tr>
                                        <td> {{ $row->title ?? '' }} </td>
                                        <td> {{ $row->slug ?? '' }} </td>
                                        <td> {{ $row->author_name?? '' }} </td>
                                        <td> {{ $row->category->name ?? '' }} </td>
                                        <td> {{ $row->created_at->format('d M, Y')?? '' }} </td>
                                        <td>
                                            <a href="{{ route('admin.blog.edit', $row->id) }}" class="text-gray-600" href=""><i class="fa fa-edit"></i></a>
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
        confirmDelete('user', id,"{{route('admin.users.delete')}}");
    });
</script>
@endpush
