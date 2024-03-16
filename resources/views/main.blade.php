@extends('layouts.header')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <h1>Введите URL XML-файла</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <form class="mb-4" method="post">
                    @csrf
                    <div class="form-group row align-items-end">
                        <div class="col-sm-9">
                            <label for="url" class="form-label">URL</label>
                            <input type="text" class="form-control" id="url" name="url">
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </form>
                <div class="mt-4 mb-4">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">URL</th>
                            <th scope="col">Дата создания</th>
                            <th scope="col">Дата обновления</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($feeds) && !empty($feeds))
                            @foreach($feeds as $key => $feed)
                                <tr>
                                    <th scope="row">{{$key + 1}}</th>
                                    <td><a href="{{$feed->url}}" target="_blank">{{$feed->url}}</a></td>
                                    <td>{{$feed->created_at}}</td>
                                    <td>{{$feed->updated_at}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
