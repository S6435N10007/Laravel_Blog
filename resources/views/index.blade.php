@extends('layout')
@section('content')
    <h1 class="text-center">All Post</h1>
    <a href="{{route('create')}}" class="btn btn-primary mb-3">+ Create New Post</a>
    @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
    @endif
    <form action="{{route('search')}}" method="GET" class="mb-3">
        @csrf
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search...." name="query" value="{{ request('query') }}">
            <button type="submit" class="btn btn-secondary">Search</button>
        </div>
    </form>
    @if ($posts->isEmpty() && request('query'))
        <p class="text-center">No posts found for "{{request('query')}}".</p>
    @elseif ($posts->isEmpty())
        <p class="text-center">No posts available</p>
    @else
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h3>{{$post->title}}</h3>
                    <p>{{Str::limit($post->content,100)}}</p>
                    <a href="{{route('show',$post)}}" class="btn btn-secondary">View</a>
                    <a href="{{route('edit',$post)}}" class="btn btn-warning">Edit</a>
                    <form action="{{route('delete',$post)}}" method="POST" style="display:inline" onsubmit="return confirm('Delete {{$post->title}}. Please confirm?');">
                        @csrf
                        @method('DELETE')
                        <button tybe="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        <div class="mt-4">
            <div>{{ $posts->appends(request()->query())->links() }}</div>
        </div>
    @endif
@endsection