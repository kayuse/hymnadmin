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
                    <h1 class="display-2 text-white">{{$hymn->title}}</h1>
                    <p class="text-white mt-0 mb-5">{{$hymn->extra}}</p>
                    <a href="#!" class="btn btn-neutral">Hymn Number: {{$hymn->number}}</a>
                    <a href="#!" class="btn btn-info">Language: {{$hymn->language}}</a>
                    <a href="{{route('portal.hymns.edit.get',['id'=>$hymn->id])}}" class="btn btn-primary">Edit Hymn</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="col-xl-8 order-xl-1">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Edit profile </h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="#!" class="btn btn-sm btn-primary" id="addVerse">Add Verse</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('portal.hymns.edit.post',['id'=>$hymn->id])}}">
                        @csrf
                        <h6 class="heading-small text-muted mb-4">Hymn Details</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Title</label>
                                        <input type="text" id="input-username" class="form-control" name="title"
                                               placeholder="Username" value="{{$hymn->title}}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Number</label>
                                        <input type="number" id="input-email" class="form-control" name="number"
                                               placeholder="Hymn Number" value="{{$hymn->number}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Language</label>
                                        <input type="text" id="input-first-name" class="form-control" name="language"
                                               placeholder="First name" value="{{$hymn->language}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Extra</label>
                                        <input type="text" id="input-username" class="form-control" name="extra"
                                               placeholder="Username" value="{{$hymn->extra}}">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr class="my-4"/>
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Chorus</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Chorus</label>
                                        <textarea name="chorus" id="choruseditor" style="height: 200px;"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr class="my-4"/>
                        <!-- Description -->
                        <h6 class="heading-small text-muted mb-4">Verses</h6>
                        <div id="versesCtn">
                            @foreach($hymn->verses as $verse)
                                <div class="pl-lg-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Verse {{$verse->number}}</label>
                                        <textarea name="verses[]" id="verseeditor{{$verse->number}}"
                                                  style="height: 200px;"></textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group" style="float: right !important;">
                                    <a href="{{route('portal.hymns.details',['id'=>$hymn->id])}}"
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
        verseEditorCount = parseInt("{{$hymn->verses->count()}}")
        var editors = []
        ClassicEditor
            .create(document.querySelector('#choruseditor')).then(editor => {
            editor.setData(`{!! $hymn->chorus !!}`)
        }).catch(error => {
            console.error(error);
        });
        @foreach($hymn->verses as $index=>$verse)
        ClassicEditor
            .create(document.querySelector('#verseeditor{{$verse->number}}')).then(editor => {
            editor.setData(`{!! $verse->content !!}`)
        }).catch(error => {
            console.error(error);
        });
        @endforeach
            $("#addVerse").click(function () {
            verseEditorCount++;
            verseHtml = `<div class="pl-lg-4" id="verseCtn${verseEditorCount}">
                <div class="form-group">
                <label class="form-control-label">New Verse </label>
                <textarea name="verses[]" id="verseeditor${verseEditorCount}" class="verses"
            style="height: 200px;"></textarea>
                </div>
                <div>
                <a href="#!" class="btn btn-sm btn-primary removeVerse" data-id='${verseEditorCount}'>Remove Verse</a>
            </div>
             <hr/>
            </div>`;
            $("#versesCtn").append(verseHtml)
            var ceditor = ClassicEditor
                .create(document.querySelector(`#verseeditor${verseEditorCount}`)).then(editor => {
                    editor.setData('');
                    var currentEditor = {
                        key: `editor${verseEditorCount}`,
                        editor: editor
                    }
                    editors.push(currentEditor)
                }).catch(error => {
                    console.error(error);
                });


        })

    </script>
@endsection

@section('styles')
    <style>
        .ck-content {
            height: 200px !important;
        }
    </style>
@endsection
