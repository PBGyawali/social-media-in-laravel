@include('config')
@include('minimal_header')
@include('sidebar')
<div class="col-sm-12  py-4">
    <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">
            <div class="container-fluid ">
                <div class="col-12 p-0">
                    <div class="d-flex flex-column" >
                        <span id="message"></span>
                        <!-- Tabs navs -->
                        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">Profile Settings</a>
                            </li>
                        </ul>
                        <!-- Tabs navs -->
                        <!-- Tabs content -->
                        <div class="tab-content" id="ex1-content">
                            @include('profile_settings')
                        </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('minimal_footer')
@include('footer')
@include('footer_script')
