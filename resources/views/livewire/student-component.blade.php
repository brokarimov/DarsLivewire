<div>
    <h1>Student Page</h1>

    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createModal">
        Create
    </button>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="name">Name</label>
                    <input type="text" wire:model="name" class="form-control" placeholder="Name">

                    <label for="tel" class="mt-2">Tel</label>
                    <input type="text" wire:model="tel" class="form-control" placeholder="Tel">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="create"
                        data-bs-dismiss="modal">Create</button>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Tel</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->tel }}</td>
                    <td>
                        <div class="d-flex">
                            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                data-bs-target="#updateModal{{ $student->id }}">
                                Update
                            </button>

                            <div class="modal fade" id="updateModal{{ $student->id }}" tabindex="-1"
                                aria-labelledby="updateModalLabel{{ $student->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel{{ $student->id }}">Update: {{$student->id}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="name">Name</label>
                                            <input type="text" wire:model="name" class="form-control" placeholder="Name"
                                                value="{{ $student->name }}">

                                            <label for="tel" class="mt-2">Tel</label>
                                            <input type="text" wire:model="tel" class="form-control" placeholder="Tel"
                                                value="{{ $student->tel }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"
                                                wire:click="update({{ $student->id }})"
                                                data-bs-dismiss="modal">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-danger mx-2"
                                wire:click="delete({{ $student->id }})">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>