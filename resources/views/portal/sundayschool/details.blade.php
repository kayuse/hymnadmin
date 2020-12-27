@extends('portal.layout.layout_content')
@section('headers')
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
@endsection
@section('body')
    <div class="header pb-6 d-flex align-items-center"
         style="min-height: 500px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
            <div class="row">
                <div class="col-lg-12 col-md-10 pb-2">
                    <h1 class="display-2 text-white">{{$topic->topic}}</h1>
                    <p class="text-white mt-0 mb-5">{{$topic->aim}} <br/> <i>{{$topic->bible_text}}</i></p>

                    <a href="{{route('portal.sundayschool.upload.get',['id'=>$topic->id])}}" class="btn btn-neutral">Upload
                        Podcast</a>
                    <a href="{{route('portal.sundayschool.topic.edit.get',['id'=>$topic->id])}}"
                       class="btn btn-primary">Edit
                        Sunday School</a>
                </div>
                <div class="col-lg-12 col-md-10 pt-2">
                    @if($topic->podcast != null)
                        <a class="badge badge-info" target="_blank"
                           href="{{route('portal.download',['file'=>base64_encode($topic->podcast->media)])}}"> <i
                                class="ni ni-cloud-download-95"></i> Podcast </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col-xl-12 order-xl-12">
                <div class="card card-profile">

                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">

                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-sm btn-info  mr-4 ml-4">Introductions</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center">
                            <div>
                                <i class="ni education_hat mr-2"></i> {!! $topic->introduction !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-12 order-xl-12">
                <div class="card card-profile">

                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">

                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-center">
                            <a href="#" class="btn btn-sm btn-primary  mr-4 ml-4">Content</a>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center">
                            <div>
                                <i class="ni education_hat mr-2"></i> {!! $topic->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Footer -->

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#hymns_table').DataTable({
                pageLength: 100,
                bPaginate: false,
            });
        });
    </script>
@endsection
