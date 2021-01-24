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
                <div class="col-lg-12 col-md-10">
                    <h1 class="display-2 text-white">{{$topic->title}}</h1>
                    <p class="text-white mt-0 mb-5">{{$topic->aim}} <br/> <i>{{$topic->bible_text}}</i></p>

                    <a href="{{route('portal.hymns.edit.get',['id'=>$topic->id])}}" class="btn btn-primary">Edit
                        Hymn</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="col-xl-12 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit Sunday School </h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" class="btn btn-sm btn-primary">Settings</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('portal.sundayschool.topic.edit.post',['id'=>$topic->id])}}">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Details</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Title</label>
                                        <input type="text" id="input-username" class="form-control" name="topic" required
                                               placeholder="Topic" value="{{$topic->topic}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Aim</label>
                                        <input type="text" id="input-email" class="form-control" name="aim" required
                                               placeholder="Aim" value="{{$topic->aim}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Number</label>
                                        <input type="number" id="input-first-name" class="form-control" name="number" required
                                               placeholder="Number" value="{{$topic->number}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Extra</label>
                                        <input type="text" id="input-username" class="form-control" name="bible_text" required
                                               placeholder="Bible Text" value="{{$topic->bible_text}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Category</label>
                                        <input type="text" id="input-username" class="form-control" name="category" required
                                               placeholder="Category" value="{{$topic->category}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr class="my-4"/>
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Introduction</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Introduction</label>
                                        <textarea name="introduction" id="introduction" style="height: 200px;"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr class="my-4"/>
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">Content</h6>

                        <div class="pl-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Content</label>
                                <textarea name="content" id="content"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" style="float: right !important;">
                                    <a href="{{route('portal.hymns.details',['id'=>$topic->id])}}"
                                       class="btn btn-danger">Cancel</a>
                                    <input type="submit" class="btn btn-primary"
                                           value="Submit">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Footer -->

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.1.0/classic/ckeditor.js"></script>
    <script>

        var introduction = `{!! $topic->escapedIntroduction() !!}`;
        var content = `{!! $topic->escapedContent() !!}`;
        ClassicEditor
            .create(document.querySelector('#introduction')).then(editor => {
            editor.setData(introduction)
        }).catch(error => {
            console.error(error);
        });
        ClassicEditor
            .create(document.querySelector('#content')).then(editor => {
            editor.ui.view.editable.element.style.height = '700px';
            editor.setData(content)
        }).catch(error => {
            console.error(error);
        });


    </script>
@endsection

@section('styles')
    <style>

    </style>
@endsection
