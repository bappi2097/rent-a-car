@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.car-model-category.create') }}" class="btn btn-primary">Add Data</a>
    <div class="col-12 mt-3 bg-white rounded p-3">
        <div class="table-responsive">
            <table class="table table-striped m-b-0" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carModelCategories as $index => $carModelCategory)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $carModelCategory->carBrandCategory->name }}</td>
                            <td>{{ $carModelCategory->model }}</td>
                            <td class="with-btn" nowrap="">
                                <a href="{{ route('admin.car-model-category.edit', $carModelCategory->id) }}"
                                    class="btn btn-sm btn-primary width-60 m-r-2">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger width-60"
                                    onclick="event.preventDefault(); document.getElementById('language{{ $index }}').submit();">
                                    Delete
                                </a>
                                <form id="language{{ $index }}"
                                    action="{{ route('admin.car-model-category.destroy', $carModelCategory->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endpush
