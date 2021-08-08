@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.user.company.car.create', $company->id) }}" class="btn btn-primary">Add
        Data</a>
    <div class="col-12 mt-3 bg-white rounded p-3">
        <div class="table-responsive">
            <table class="table table-striped m-b-0" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car No</th>
                        <th>Category</th>
                        <th>License</th>
                        <th>Image</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($company->cars as $index => $car)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $car->car_no }}</td>
                            <td>
                                {{ $car->carCategory->CarSizeCategory->size . ' Feet, ' . $car->carCategory->CarWeightCategory->weight . ' Ton, ' . $car->carCategory->CarModelCategory->CarBrandCategory->name . '-' . $car->carCategory->CarModelCategory->model }}
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->license) }}" class="img-rounded height-30">
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->image) }}" class="img-rounded height-30">
                            </td>
                            <td class="with-btn" nowrap="">
                                <a href="{{ route('admin.user.company.car.edit', [
    'company' => $company->id,
    'car' => $car->id,
]) }}"
                                    class="btn btn-sm btn-primary width-60 m-r-2">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger width-60"
                                    onclick="event.preventDefault(); document.getElementById('language{{ $index }}').submit();">
                                    Delete
                                </a>
                                <form id="language{{ $index }}"
                                    action="{{ route('admin.user.company.car.destroy', [
    'company' => $company->id,
    'car' => $car->id,
]) }}"
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
