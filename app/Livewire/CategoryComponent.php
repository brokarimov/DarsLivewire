<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryComponent extends Component
{
    use WithPagination;

    public $activeForm = false;
    public $name;
    public $searchName;
    public $editFormCategory = false;
    public $nameEdit;

    protected $paginationTheme = 'bootstrap'; 

    public function render()
    {
        
        $query = Category::query();
        if (!empty($this->searchName)) {
            $query->where('name', 'LIKE', "{$this->searchName}%");
        }

        return view('livewire.category-component', [
            'models' => $query->orderBy('id', 'desc')->paginate(10), 
        ])->layout('components.layouts.append');
    }

    public function updatingSearchName()
    {
        $this->resetPage();
    }

    public function close()
    {
        $this->activeForm = false;
    }

    public function open()
    {
        $this->activeForm = true;
    }

    public function save()
    {
        if (!empty($this->name)) {
            Category::create([
                'name' => $this->name,
            ]);
        }

        $this->name = '';
        $this->activeForm = false;
        $this->resetPage();
    }

    public function toggle(Category $model)
    {
        $model->update([
            'is_active' => !$model->is_active,
        ]);
    }
    public function searchColumps()
    {
        $this->models = Category::where('name', 'LIKE', "{$this->searchName}%")->get();
    }

    public function delete(Category $model)
    {
        $model->delete();
        $this->resetPage(); 
    }

    public function editForm(Category $model)
    {
        $this->editFormCategory = $model->id;
        $this->nameEdit = $model->name;
    }

    public function update(Category $model)
    {
        if (!empty($this->nameEdit)) {
            $model->update([
                'name' => $this->nameEdit,
            ]);
        }
        $this->editFormCategory = false;
    }
}
