@include('template.head')
<body class="g-sidenav-show bg-gray-100">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @include('template.sidebar')
    <main class="main-content position-relative border-radius-lg ">
    @include('template.navbar')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="float-start">
                    <h4 class="pb-3 ">My Tasks</h4>
                </div>
                <div class="float-end">
                    <a href="{{ route('todo.create') }}" class="btn btn-info">
                        <i class="fa fa-plus-circle"></i> Create Task
                    </a>
                </div>
                <div class="clearfix"></div>
        @foreach ($todo as $task)
        <div class="container-fluid">
        <div class="container-fluid">
        <div class="container-fluid">
            <div class="card mt-3 col-md-12" style="word-break: break-all;">
                <h5 class="card-header">
                    @if ($task->status === 'Todo')
                        {{ $task->title }}
                    @else
                        <del>{{ $task->title }}</del>
                    @endif

                    <span class="badge rounded-pill bg-warning text-dark">
                        {{ $task->created_at->diffForHumans() }}
                    </span>
                </h5>

                <div class="card-body">
                    <div class="card-text">
                        <div class="float-start">
                            @if ($task->status === 'Todo')
                                {{ $task->description }}
                            @else
                                <del>{{ $task->description }}</del>
                            @endif
                            <br>

                            @if ($task->status === 'Todo')
                                <span class="badge rounded-pill bg-info text-white">
                                    Todo
                                </span>
                            @else
                                <span class="badge rounded-pill bg-success text-white">
                                    Done
                                </span>
                            @endif


                            <small>Last Updated - {{ $task->updated_at->diffForHumans() }} </small>
                        </div>
                        <div class="float-end">
                            <a href="{{ route('todo.edit', $task->id) }}" class="btn btn-success">
                            <i class="fa fa-edit"></i>
                            </a>

                            <form action="{{ route('todo.destroy', $task->id) }}" style="display: inline" method="POST" onsubmit="return confirm('Are you sure to delete ?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if (count($todo) === 0)
        <div class="alert alert-danger p-2">
            No Task Found. Please Create one task
            <br>
            <br>
            <a href="{{ route('todo.create') }}" class="btn btn-info">
                <i class="fa fa-plus-circle"></i> Create Task
            </a>
        </div>
    @endif
    @include('template.script')
    @include('template.footer')
</main>
</body>
