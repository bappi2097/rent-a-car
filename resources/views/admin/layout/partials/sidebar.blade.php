<div id="sidebar" class="sidebar">
    <div data-scrollbar="true" data-height="100%">
        <ul class="nav">
            <li class="nav-profile">
                <a href="javascript:;" data-toggle="nav-profile">
                    <div class="cover with-shadow"></div>
                    <div class="image">
                        <img src="{{ asset(!empty(auth()->user()->admin) && !empty(auth()->user()->admin->image) ? auth()->user()->admin->image : 'assets/img/user/user-13.jpg') }}"
                            alt="" />
                    </div>
                    <div class="info">
                        {{-- <b class="caret pull-right"></b> --}}
                        {{ auth()->user()->name }}
                    </div>
                </a>
            </li>
            {{-- <li>
                <ul class="nav nav-profile">
                    <li>
                        <a href="javascript:;"><i class="fa fa-cog"></i> Settings</a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a>
                    </li>
                    <li>
                        <a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a>
                    </li>
                </ul>
            </li> --}}
        </ul>

        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li class="has-sub {{ active('admin.dashboard') }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-th-large"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-header">User Category</li>
            <li class="has-sub {{ set_active('admin/user*') }}">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-lg fa-fw m-r-10 fa-user"></i>
                    <span>Users</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active('admin.user.admins.index') }}">
                        <a href="{{ route('admin.user.admins.index') }}">Admin</a>
                    </li>
                    <li class="{{ active('admin.user.customer.index') }}">
                        <a href="{{ route('admin.user.customer.index') }}">Customer</a>
                    </li>
                    <li class="{{ active('admin.user.driver.index') }}">
                        <a href="{{ route('admin.user.driver.index') }}">Driver</a>
                    </li>
                </ul>
            </li>
            <li class="nav-header">Car</li>
            <li class="has-sub {{ set_active('admin/car-*') }}">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-lg fa-fw m-r-10 fa-list"></i>
                    <span>Car Category</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active('admin.car-category.index') }}">
                        <a href="{{ route('admin.car-category.index') }}">Category List</a>
                    </li>

                    <li class="{{ active('admin.car-brand-category.index') }}">
                        <a href="{{ route('admin.car-brand-category.index') }}">Car Brand</a>
                    </li>
                    <li class="{{ active('admin.car-model-category.index') }}">
                        <a href="{{ route('admin.car-model-category.index') }}">Car Model</a>
                    </li>
                </ul>
            </li>
            <li class="has-sub {{ set_active('admin/cars*') }}">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-lg fa-fw m-r-10 fa-car"></i>
                    <span>Car</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active('admin.cars.index') }}">
                        <a href="{{ route('admin.cars.index') }}">Car</a>
                    </li>
                </ul>
            </li>
            {{-- <li class="nav-header">Language</li>
            <li class="{{ active('admin.language.index') }}">
                <a href="{{ route('admin.language.index') }}">
                    <i class="fas fa-lg fa-fw m-r-10 fa-american-sign-language-interpreting"></i>
                    <span>Languages</span>
                </a>
            </li> --}}
            {{-- <li class="nav-header">Blog</li>
            <li class="has-sub {{ set_active('admin/blog*') }}">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fab fa-lg fa-fw m-r-10 fa-blogger-b"></i>
                    <span>Blog</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active('admin.blog-category.index') }}">
                        <a href="{{ route('admin.blog-category.index') }}">Category</a>
                    </li>
                    <li class="{{ active('admin.blog.index') }}">
                        <a href="{{ route('admin.blog.index') }}">Blog</a>
                    </li>
                </ul>
            </li> --}}
            <li class="has-sub {{ set_active('admin/setting*') }}">
                <a href="javascript:;">
                    <b class="caret"></b>
                    <i class="fas fa-cog fa-fw"></i>
                    <span>Setting</span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ active('admin.setting.slider.index') }}">
                        <a href="{{ route('admin.setting.slider.index') }}">Header Slider</a>
                    </li>
                    {{-- <li class="{{ active('admin.setting.client.index') }}">
                        <a href="{{ route('admin.setting.client.index') }}">Client</a>
                    </li> --}}
                </ul>
            </li>
            {{-- <li class="has-sub {{ active('admin.contact.index') }}">
                <a href="{{ route('admin.contact.index') }}">
                    <i class="fa fa-th-large"></i>
                    <span>Mail</span>
                </a>
            </li> --}}
            <li>
                <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
