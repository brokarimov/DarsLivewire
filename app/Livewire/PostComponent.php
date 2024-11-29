<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostComponent extends Component
{
    use WithPagination;

    // Form 
    public $title;
    public $description;
    public $text;
    public $category_id;

    // Edit form 
    public $editFormPost = false;
    public $titleEdit;
    public $descriptionEdit;
    public $textEdit;
    public $category_idEdit;

    // Search 
    public $searchTitle;
    public $searchDescription;
    public $searchText;
    public $searchCategory_id;

    
    public $activeForm = false;

    
    protected $paginationTheme = 'bootstrap';

    
    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'text' => 'required|string',
        'category_id' => 'required|exists:categories,id',
    ];

    public function render()
    {
        $query = Post::query();

        if ($this->searchTitle) {
            $query->where('title', 'LIKE', "{$this->searchTitle}%");
        }
        if ($this->searchDescription) {
            $query->where('description', 'LIKE', "{$this->searchDescription}%");
        }
        if ($this->searchText) {
            $query->where('text', 'LIKE', "{$this->searchText}%");
        }
        if ($this->searchCategory_id) {
            $query->where('category_id', $this->searchCategory_id);
        }

        return view('livewire.post-component', [
            'models' => $query->orderBy('id', 'desc')->paginate(10),
            'categories' => Category::all(),
        ]);
    }

    public function open()
    {
        $this->activeForm = true;
    }

    public function close()
    {
        $this->reset(['title', 'description', 'text', 'category_id']);
        $this->activeForm = false;
    }

    public function save()
    {
        

        Post::create([
            'title' => $this->title,
            'description' => $this->description,
            'text' => $this->text,
            'category_id' => $this->category_id,
        ]);

        $this->close();
    }
    public function searchColumps()
    {
        $this->models = Post::where('title', 'LIKE', "{$this->searchTitle}%")
        ->where('description', 'LIKE', "{$this->searchDescription}%")
        ->where('text', 'LIKE', "{$this->searchText}%")
        ->where('category_id', 'LIKE', "{$this->searchCategory_id}%")
        ->orderBy('id', 'desc')->paginate(10);
    }

    public function delete(Post $model)
    {
        $model->delete();
    }

    public function editForm(Post $model)
    {
        $this->editFormPost = $model->id;
        $this->titleEdit = $model->title;
        $this->descriptionEdit = $model->description;
        $this->textEdit = $model->text;
        $this->category_idEdit = $model->category_id;
    }

    public function update(Post $model)
    {

        $model->update([
            'title' => $this->titleEdit,
            'description' => $this->descriptionEdit,
            'text' => $this->textEdit,
            'category_id' => $this->category_idEdit,
        ]);

        $this->reset(['titleEdit', 'descriptionEdit', 'textEdit', 'category_idEdit', 'editFormPost']);
    }
}
