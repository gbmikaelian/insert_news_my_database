@extends('layouts.app')

@section('content')
    <div class="container-fluid ">

        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Փոփոխել նորությունը</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{url('/admin/article/')}}" class="form-horizontal form-news" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="title">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="title" class="form-control" id="title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="description">Description</label>
                                <div class="col-sm-10">
                                    <textarea name="description" rows="6" class="form-control"
                                              id="description"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="old_image_path" id="old_image_path">

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="link">Link</label>
                                <div class="col-sm-10">
                                    <input type="text" name="link" class="form-control" id="link">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2" for="image">Image</label>
                                <div class="col-sm-10">
                                    <img id="image" class="image" width="200" src="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2 image_change" for="file"></label>
                                <div class="col-sm-10">
                                    <input type="file" data-buttonBefore="true" data-input="false" class="filestyle" name="file" id="file">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 m-auto">
                <a class="btn btn-success" href="{{url('admin/article/create')}}">Sincronization</a>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>

            @endif
            <div class="col-md-12">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        {{--<th>Link</th>--}}
                        <th>Description</th>
                        <th>Image path</th>
                        <th>PubDate</th>
                        <th>Edit</th>
                        <th>Delete</th>

                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        {{--<th>Link</th>--}}
                        <th>Description</th>
                        <th>Image path</th>
                        <th>PubDate</th>
                        <th>edit</th>
                        <th>Delete</th>
                    </tr>
                    </tfoot>
                    <tbody>


                    @foreach($articles as $article)
                        <tr data-id="{{$article->id}}" data-image_path="{{$article->image['image_name']}}"
                            data-link="{{$article->link}}">
                            <td class="title">{{$article->title}}</td>
                            <td class="description">{{strip_tags($article->description)}}</td>
                            <td><a href="{{$article->link}}"><img width="200"
                                                                  src="{{asset('images/uploads/'.$article->image['image_name'])}}"
                                                                  alt=""></a></td>
                            <td>{{$article->pubDate}}</td>
                            <td data-toggle="modal" data-target="#myModal" class="text-center text-success update"><i
                                        class="fa fa-pencil" aria-hidden="true"></i></td>
                            <td class="text-center text-danger delete">
                                <form method="POST" action="{{url('admin/article/'.$article->id)}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </form>


                            </td>

                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
