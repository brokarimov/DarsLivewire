<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentComponent extends Component
{
    public $students;
    public $name;
    public $tel;
    public function render()
    {
        $this->students = Student::all();
        return view('livewire.student-component');
    }

    public function create()
    {
        // dd($this->name, $this->tel);
        if (!empty($this->name) && !empty($this->tel)) {
            Student::create([
                'name' => $this->name,
                'tel' => $this->tel,
            ]);
        }
        $this->name = '';
        $this->tel = '';
    }

    public function delete($studentId)
    {
        $student = Student::findOrFail($studentId);

        if ($student) {
            $student->delete();
        }
    }

    public function update($studentId)
    {
        $student = Student::findOrFail($studentId);
        if($student &&!empty($this->name) && !empty($this->name)){
            $student->update([
                'name' => $this->name,
                'tel' => $this->tel,
            ]);
        }
        $this->name = '';
        $this->tel = '';
    }
}
