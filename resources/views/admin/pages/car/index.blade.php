@extends('admin.layout.app')
@section('content')
    <div class="col-12 mt-3 bg-white rounded p-3">
        <div class="table-responsive">
            <table class="table table-striped m-b-0" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Car No</th>
                        <th>User Type</th>
                        <th>Category</th>
                        <th>License</th>
                        <th>Image</th>
                        <th>Valid</th>
                        <th width="1%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $index => $car)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $car->car_no }}</td>
                            @if ($car->isCompany())
                                <td>Company</td>
                            @else
                                <td>Driver</td>
                            @endif
                            <td>
                                {{ $car->carCategory->CarSizeCategory->size . ' Feet, ' . $car->carCategory->CarWeightCategory->weight . ' Ton, ' . $car->carCategory->CarModelCategory->CarBrandCategory->name . '-' . $car->carCategory->CarModelCategory->model }}
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->license) }}" class="img-rounded height-40">
                            </td>
                            <td class="with-img">
                                <img src="{{ asset($car->image) }}" class="img-rounded height-40">
                            </td>
                            <td>
                                <span
                                    class="badge badge-{{ carValid($car->is_valid)[1] }} text-uppercase">{{ carValid($car->is_valid)[0] }}</span>
                            </td>
                            <td class="with-btn" nowrap="">
                                @if ($car->is_valid != 1)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success width-60"
                                        onclick="event.preventDefault(); document.getElementById('accept{{ $index }}').submit();">
                                        <i class="fas fa-lg fa-fw m-r-10 fa-check"></i>
                                    </a>
                                    <form id="accept{{ $index }}"
                                        action="{{ route('admin.cars.accept', ['car' => $car->id]) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                                @if ($car->is_valid != 2)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary width-60"
                                        onclick="event.preventDefault(); document.getElementById('reject{{ $index }}').submit();">
                                        <i class="fas fa-lg fa-fw m-r-10 fa-times"></i>
                                    </a>
                                    <form id="reject{{ $index }}"
                                        action="{{ route('admin.cars.reject', ['car' => $car->id]) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                                <a href="{{ route('admin.cars.user', $car->id) }}"
                                    class="btn btn-sm btn-light width-60 m-r-2">
                                    <i class="fas fa-lg fa-fw m-r-10 fa-user"></i>
                                </a>
                                <a href="{{ route('admin.cars.edit', $car->id) }}"
                                    class="btn btn-sm btn-primary width-60 m-r-2">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger width-60"
                                    onclick="event.preventDefault(); document.getElementById('language{{ $index }}').submit();">
                                    Delete
                                </a>
                                <form id="language{{ $index }}"
                                    action="{{ route('admin.cars.destroy', ['car' => $car->id]) }}" method="POST"
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
