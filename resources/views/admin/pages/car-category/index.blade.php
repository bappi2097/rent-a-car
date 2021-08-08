@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.car-category.create') }}" class="btn btn-primary">Add Data</a>
    <div class="col-12 mt-3 bg-white rounded p-3">
        <div class="table-responsive">
            <table class="table table-striped m-b-0" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car</th>
                        <th>Model</th>
                        <th>Size</th>
                        <th>Weight</th>
                        <th>Covered</th>
                        <th>Description</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carCategories as $index => $carCategory)
                        <tr>
                            <td class="with-img">
                                <img src="{{ asset($carCategory->image ?: 'images/car.png') }}"
                                    class="img-rounded height-30">
                            </td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $carCategory->carModelCategory->carBrandCategory->name }}
                                {{ $carCategory->carModelCategory->model }}</td>
                            <td>{{ $carCategory->carSizeCategory->size }}</td>
                            <td> {{ $carCategory->carWeightCategory->weight }}</td>
                            <td> {{ $carCategory->carCoveredCategory->name }}</td>
                            <td>{{ $carCategory->description }}</td>
                            <td class="with-btn" nowrap="">
                                <a href="{{ route('admin.car-category.edit', $carCategory->id) }}"
                                    class="btn btn-sm btn-primary width-60 m-r-2">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger width-60"
                                    onclick="event.preventDefault(); document.getElementById('language{{ $index }}').submit();">
                                    Delete
                                </a>
                                <form id="language{{ $index }}"
                                    action="{{ route('admin.car-category.destroy', $carCategory->id) }}" method="POST"
                                    style="display: none;">
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
