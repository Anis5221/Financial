@extends('layouts.app')
@section('content')
<div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <div class="alert-icon contrast-alert">
                    <i class="fa fa-check"></i>
                </div>
                <div class="alert-message">
                    <span><strong>Success!</strong> {{session('success')}} </span>
                </div>
            </div>
        @endif
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Income Category</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#categoryAdd">Add Category</a>
    </div>

    {{--  model for categories --}}


    <div class="modal fade modelCategory" id="categoryAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLabel">Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                  <form action="{{route('category.store')}}" method='POST'>
                        @csrf
                    <div class="form-group">
                        <label for="modalTitle">Title:</label>
                        <input required type="text" id="modalTitle" class="form-control " name="title" placeholder='Enter Category Title...'>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" >Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>




    {{-- table sectio here.... --}}

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $key=>$category)
                        <tr>

                            <td>{{ $key + 1}}</td>
                            <td id="title{{$category->id }}">{{$category->title}}</td>
                            <td>
                                <a type="button" data-toggle="modal" data-target="#categoryAdd{{$category->id}}"
                                    style="color: #1D8348;"
                                    >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a type="button" style="color:#922B21;" onclick="deleteCategory({{ $category->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <form id="delete-form-{{ $category->id }}" action="{{route('category.destroy',$category->id)}}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>

                        <div class="modal fade" id="categoryAdd{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Income Category</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="{{route('category.update', $category->id)}}" method='POST'>
                                            @csrf
                                            @method('PUT')
                                        <div class="form-group">
                                            <label for="modalTitle">Title:</label>
                                            <input type="text" id="modalTitle" class="form-control" value="{{!empty($category) ? $category->title : ''}}" name="title" placeholder='Enter Category Title...'>
                                        </div>

                                        <input type="hidden" id="modalCategoryId">


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" >Update</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach


                    </tbody>
                </table>

                                        {{-- Pagination --}}
                                <div class="d-flex justify-content-center">
                                    {!! $categories->links() !!}
                                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">
   function deleteCategory(id){

        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You want to delete this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
        event.preventDefault();
        document.getElementById('delete-form-'+id).submit();
        } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
        swalWithBootstrapButtons.fire(
        'Cancelled',
        'Your imaginary file is safe :)',
        'error'
        )
        }
        })

}
</script>

@endpush



