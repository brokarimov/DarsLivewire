<div wire:click="resetEditingCell" style="position: relative;">
    <h1>Attendance</h1>
    <input type="date" class="form-control" wire:model="date" wire:change="getDate">
    <h3 class="mt-2" style="color: blue">
        {{ $date ? \Carbon\Carbon::parse($date)->isoFormat('MMMM YYYY') : \Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}
    </h3>
    <table class="table table-striped table-bordered mt-2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                @foreach ($dates as $date)
                    <th style="text-align: center;">{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody wire:sortable="updateStudentOrder">
            @foreach ($students as $student)
                    <tr draggable="true" wire:sortable.item="{{ $student->id }}">
                        <td>{{ $student->id }}
                            <button wire:click="deleteStudent({{$student->id}})"
                                style="height: 30px; width: 15px; display: flex; align-items: center; justify-content: center;"
                                class="btn btn-danger">
                                <i class="bi bi-trash" style="margin-left: -1px;"></i>
                            </button>

                        </td>
                        <td>{{ $student->name }}</td>
                        @foreach ($dates as $date)
                                    @php
                                        $studentAttendance = $student->check($date);
                                    @endphp
                                    <td wire:click.stop="editCell({{ $student->id }}, '{{ $date }}')" style="height: 5%; width: 5%;">
                                        @if ($editingCell === "{$student->id}-{$date}")
                                            <input type="text" wire:model.lazy="status" value="{{$studentAttendance->status ?? ''}}"
                                                wire:keydown.enter="saveCell({{ $student->id }}, '{{ $date }}')" class="form-control td-input"
                                                style="height:40px; width: 100%; box-sizing: border-box;" autofocus>
                                        @else
                                            @if ($studentAttendance)
                                                <span class="{{$studentAttendance->status == '+' ? 'text-primary' : 'text-danger'}}">
                                                    {{$studentAttendance->status}}
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                        @endforeach
                    </tr>
            @endforeach
        </tbody>
    </table>

    @if ($activeForm)
        <div class="row align-items-center">
            <form wire:submit.prevent="save" class="d-flex">
                <div class="me-2">
                    <label for="studentName" class="form-label">Student Name</label>
                    <input type="text" wire:model.blur="name" id="studentName" class="form-control"
                        placeholder="Student Name">
                    @error('name')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="align-self-end">
                    <input type="submit" class="btn btn-primary ms-2" value="Submit">
                </div>
            </form>
        </div>

    @endif

    <button type="button" class="btn btn-outline-primary mt-2 mb-2"
        wire:click="{{$activeForm ? 'falseAttendance' : 'trueAttendance'}}">
        {{$activeForm ? 'Close' : 'Create'}}
    </button><br>

</div>