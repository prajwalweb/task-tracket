@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Task Tracket</div>

                    <div class="card-body">
                        <div class="container mt-2">
                            <div class="row">
                                <form action="{{ route('tasks.index') }}" method="GET">
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Due Date</strong>
                                            <input type="date" name="due_date" placeholder="Due Date" class="form-control" value="{{ request()->get('due_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <div class="form-group">
                                            <strong>Task category</strong>
                                            <select name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ request()->get('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary ml-3">Search</button>
                                </form>
                            </div>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-right mb-2">
                                        <a class="btn btn-success" href="{{ route('tasks.create') }}"> Create Task</a>
                                    </div>
                                </div>
                            </div>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Task Title</th>
                                        <th>Task Description</th>
                                        <th>Task Due Date</th>
                                        <th>Task Category</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $tasks)
                                        <tr {{ $tasks->due_date < date('Y-m-d') ? 'class=table-danger' : '' }}>
                                            <td>{{ $tasks->title }}</td>
                                            <td>{{ $tasks->description }}</td>
                                            <td>{{ $tasks->due_date }}</td>
                                            <td>{{ $tasks->category->name }}</td>
                                            <td>
                                                <form action="{{ route('tasks.destroy', $tasks->id) }}" method="Post">
                                                    <a class="btn btn-primary" href="{{ route('tasks.edit', $tasks->id) }}">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
