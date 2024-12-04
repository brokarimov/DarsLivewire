<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceComponent extends Component
{
    public $students;
    public $models;
    public $date;
    public $dates = [];
    public $activeForm = false;
    public $name;
    public $editingCell = null;
    public $status;

    protected $rules = [
        'name' => 'required|max:255',
    ];
    public function updated($propertyname)
    {
        $this->validateOnly($propertyname);
    }
    public function mount()
    {
        $this->students = Student::all();
        $this->models = Attendance::all();
        $this->getDate();
    }

    public function render()
    {
        return view('livewire.attendance-component')->layout('components.layouts.append');
    }

    public function updatedDate()
    {

        $this->getDate();
    }

    public function getDate()
    {
        if (!$this->date) {
            $startOfMonth = Carbon::parse(today())->startOfMonth();
            $endOfMonth = Carbon::parse(today())->endOfMonth();
        }

        $startOfMonth = Carbon::parse($this->date)->startOfMonth();
        $endOfMonth = Carbon::parse($this->date)->endOfMonth();

        $this->dates = [];
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $this->dates[] = $date->format('Y-m-d');
        }

    }


    public function trueAttendance()
    {
        $this->activeForm = true;
    }

    public function falseAttendance()
    {
        $this->activeForm = false;
    }
    public function save()
    {
        $validateData = $this->validate();
        if ($this->name) {
            Student::create($validateData);
        }
        $this->reset('name');
        $this->mount();
        $this->activeForm = false;
    }

    public function editCell($studentId, $date)
    {
        $this->editingCell = "$studentId-$date";
    }

    public function saveCell($studentId, $date)
    {

        Attendance::updateOrCreate(
            ['student_id' => $studentId, 'date' => $date],
            ['status' => $this->status]
        );
        $this->status = '';
        $this->editingCell = null;

        $attendances = Attendance::where('status', '')->get();
       
        if($attendances){
            foreach($attendances as $attendance){
                $attendance->delete();
            }
        }
        
    }
    public function resetEditingCell()
    {
        $this->editingCell = null;
    }

    public function deleteStudent(Student $student)
    {
        $student->delete();
        $this->mount();
    }

}
