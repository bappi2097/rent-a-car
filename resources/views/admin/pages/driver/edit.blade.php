@extends('admin.layout.app')
@section('content')
    <a href="{{ route('admin.user.driver.index') }}" class="btn btn-white"> &lt; Back</a>
    <div class="bg-white p-20 col-12 m-t-30">
        <form action="{{ route('admin.user.driver.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <fieldset>
                <legend class="m-b-15">Edit Driver</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="John Doe"
                                value="{{ $user->name }}">
                            @error('name')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="john.doe@mail.com"
                                value="{{ $user->email }}">
                            @error('email')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile_no">Mobile No</label>
                            <input type="text" class="form-control" name="mobile_no" id="mobile_no"
                                placeholder="+97XXXXXXXX" value="{{ $user->mobile_no }}">
                            @error('mobile_no')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" id="address"
                                placeholder="24/B Baker Street" value="{{ $user->driver ? $user->driver->address : '' }}">
                            @error('address')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <img id="user-image" style="width: 180px; height: 180px;"
                        src="{{ asset(!empty($user->driver) && !empty($user->driver->image) ? $user->driver->image : 'images/admin.png') }}"
                        alt="your image" /><br>
                    <input type='file' name="image" id="user-image-btn" style="display: none;" onchange="readURL(this);"
                        accept="image/*" />
                    <input type="button" class="btn btn-outline-secondary" style="width: 180px;" value="Update Image"
                        onclick="document.getElementById('user-image-btn').click();" />
                    @error('image')
                        <span class="text-red">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <img id="license-image"
                                src="{{ asset($user->driver && !empty($user->driver->license) ? $user->driver->license : 'images/id-card.png') }}"
                                alt="your license" width="175" height="100" /><br>
                            <input type='file' name="license" id="user-license-btn" style="display: none;"
                                onchange="readLicenseURL(this);" accept="images/*" />
                            <input type="button" style="width: 175px;" class="btn btn-outline-secondary"
                                value="Update License" onclick="document.getElementById('user-license-btn').click();" />
                            @error('license')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <img id="nid-image"
                                src="{{ asset(!empty($user->driver->nid) ? $user->driver->nid : 'images/id-card.png') }}"
                                alt="your nid" width="175" height="100" /><br>
                            <input type='file' name="nid" id="user-nid-btn" style="display: none;"
                                onchange="readNIDURL(this);" accept="images/*" />
                            <input type="button" style="width: 175px;" class="btn btn-outline-secondary" value="Update Nid"
                                onclick="document.getElementById('user-nid-btn').click();" />
                            @error('nid')
                                <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary m-r-5">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Cancel</a>
            </fieldset>
        </form>
    </div>
    <div class="bg-white p-20 col-12 m-t-30">
        <form action="{{ route('admin.user.driver.change-password', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <fieldset>
                <legend class="m-b-15">Change Password</legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="*******">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="*******">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary m-r-5">Update</button>
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-default">Cancel</a>
            </fieldset>
        </form>
    </div>
@endsection

@push('script')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#user-image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readNIDURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#nid-image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function readLicenseURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#license-image')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
