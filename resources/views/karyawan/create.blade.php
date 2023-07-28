@include('template.head')
@include('template.sidebar')
<body class="g-sidenav-show bg-gray-100">
<main class="main-content position-relative border-radius-lg ">
    @include('template.navbar')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                    <div class="float-start">
                        <h4 class="pb-3">Create Task</h4>
                    </div>
                    <div class="float-end">
                        {{-- <a href="{{ route('task') }}" class="btn btn-info"> --}}
                            <i class="fa fa-arrow-left"></i> All Task
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            
                <div class="card card-body bg-light p-4">
                    <form action="{{ route('todo.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <a href="/todo" class="btn btn-secondary mr-2"><i class="fa fa-arrow-left"></i> Cancel</a>
            
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i>
                            Save
                        </button>
                    </form>
            </div>
        </div>
    </div>
    @include('template.script')
    @include('template.footer')
</main>
</body>
