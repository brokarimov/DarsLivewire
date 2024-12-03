<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Comment;
use App\Models\LikeOrDislike;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\View;
use Livewire\Component;
use Livewire\WithPagination;
use Request;
use Livewire\WithFileUploads;
class PostComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    // Form 
    public $title;
    public $description;
    public $text;
    public $category_id;
    public $photo;

    // Edit form 
    public $editFormPost = false;
    public $titleEdit;
    public $descriptionEdit;
    public $textEdit;
    public $category_idEdit;
    public $photoEdit;

    // Search 
    public $searchTitle;
    public $searchDescription;
    public $searchText;
    public $searchCategory_id;

    // Post
    public $postActive = false;

    // Form
    public $activeForm = false;
    // Active Show
    public $activeShow = false;
    // Comments
    public $comments;
    public $comment;
    public $activeComment = false;
    public $activeCommentID;
    public $childComment;

    // Like or Dislike
    public $post;
    public $likeCount;
    public $dislikeCount;
    public $userLikeStatus;

    // Bootstrap
    protected $paginationTheme = 'bootstrap';


    protected $rules = [
        'title' => 'required|string|max:255|min:3',
        'description' => 'required|string|max:500',
        'text' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'photo' => 'required|file|mimes:png,jpg,jpeg',
    ];
    public function updated($propertyname)
    {
        $this->validateOnly($propertyname);

    }
    public function mount()
    {
        $this->models = Post::orderBy('id', 'desc')->paginate(6);
    }

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

            'models' => $this->models ?? $query->orderBy('id', 'desc')->paginate(6),

            'categories' => Category::all(),

        ])->layout('components.layouts.append');
    }

    public function open()
    {
        $this->activeForm = true;
    }

    public function close()
    {
        $this->reset(['title', 'description', 'text', 'category_id','photo']);
        $this->activeForm = false;
    }

    public function save()
    {

        $validateData = $this->validate();

        if ($this->photo) {
            
            $extension = $this->photo->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
        
            
            $path = $this->photo->storeAs('image_upload', $filename, 'public');
        
            
            $validateData['photo'] = $path;
        }
        
        // dd($validateData);
        Post::create($validateData);

        $this->close();
    }
    public function searchColumps()
    {
        $this->models = Post::where('title', 'LIKE', "{$this->searchTitle}%")
            ->where('description', 'LIKE', "{$this->searchDescription}%")
            ->where('text', 'LIKE', "{$this->searchText}%")
            ->where('category_id', 'LIKE', "{$this->searchCategory_id}%")
            ->orderBy('id', 'desc')->paginate(6);
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
        if ($this->photoEdit) {
            
            $extension = $this->photoEdit->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;
        
            
            $path = $this->photoEdit->storeAs('image_upload', $filename, 'public');
        
            
            $this->photoEdit = $path;
        }
        $model->update([
            'title' => $this->titleEdit,
            'description' => $this->descriptionEdit,
            'text' => $this->textEdit,
            'category_id' => $this->category_idEdit,
            'photo' => $this->photoEdit,
        ]);

        $this->reset(['titleEdit', 'descriptionEdit', 'textEdit', 'category_idEdit', 'editFormPost', 'photoEdit']);
    }

    public function truePost()
    {
        $this->activeShow = false;
        $this->postActive = true;

    }
    public function falsePost()
    {
        $this->activeShow = false;
        $this->postActive = false;

    }

    public function categoryFilter(int $category = null)
    {
        $this->activeShow = false;

        $this->models = $category
            ? Post::where('category_id', $category)->paginate(6)
            : Post::orderBy('id', 'desc')->paginate(6);
        $this->activeComment = false;

    }

    public function show(Post $post)
    {
        $this->activeShow = true;
        $this->models = $post;
        $this->comments();
        $this->activeComment = false;
        $this->likeCount = $post->like;
        $this->dislikeCount = $post->dislike;

        $ipAddress = request()->ip();
        $existingInteraction = LikeOrDislike::where('user_ip', $ipAddress)
            ->where('post_id', $post->id)
            ->first();

        $this->userLikeStatus = $existingInteraction->value ?? null;
        $date = date('Y-m-d H:i:s');
        $view = View::where('user_ip', request()->ip())->where('post_id', $post->id)->first();
        if (!$view || $view->updated_at->diffInMinutes($date) >= 1) {
            if (!$view) {
                View::create([
                    'user_ip' => request()->ip(),
                    'post_id' => $post->id,
                ]);
                $post->views++;
                $post->save();

            } else {
                $view->updated_at = $date;
                $view->save();
                $post->views++;
                $post->save();
            }
        }
    }

    public function comments()
    {
        return $this->comments = Comment::where('parent_id', 0)->get();

    }
    public function commentCreate(Post $post)
    {
        if ($this->comment) {
            Comment::create([
                'comment' => $this->comment,
                'post_id' => $post->id,
            ]);
        }
        $this->models = $post;
        $this->comments();
        $this->comment = '';
        $this->activeComment = false;
    }

    public function CommentActive(Post $post, Comment $comment)
    {

        $this->activeComment = true;
        $this->models = $post;
        $this->activeCommentID = $comment->id;

    }
    public function CreateCommetChild(int $parentId, Post $post)
    {

        Comment::create([
            'parent_id' => $parentId,
            'comment' => $this->childComment,
            'post_id' => $post->id,
        ]);
        $this->activeComment = false;
        $this->childComment = '';
        $this->models = $post;
        $this->comments();
    }


    public function toggleInteraction(Post $post, $value)
    {
        $ipAddress = request()->ip();

        // Find existing interaction
        $existingInteraction = LikeOrDislike::where('user_ip', $ipAddress)
            ->where('post_id', $post->id)
            ->first();

        if ($existingInteraction && $existingInteraction->value == $value) {
            // Remove existing interaction
            $existingInteraction->delete();

            if ($value == 1) {
                $post->likes--;
            } else {
                $post->dislikes--;
            }

            $post->save();
            $this->userLikeStatus = null;
        } else {
            if ($existingInteraction) {
                // Update the existing interaction
                if ($value == 1) {
                    $post->dislikes--;
                    $post->likes++;
                } else {
                    $post->likes--;
                    $post->dislikes++;
                }

                $existingInteraction->update(['value' => $value]);
            } else {
                // Create a new interaction
                LikeOrDislike::create([
                    'user_ip' => $ipAddress,
                    'post_id' => $post->id,
                    'value' => $value,
                ]);

                if ($value == 1) {
                    $post->likes++;
                } else {
                    $post->dislikes++;
                }
            }

            $post->save();
            $this->userLikeStatus = $value;
        }
    }

    public function like(Post $post)
    {
        $this->toggleInteraction($post, 1);
        $this->models = $post;
    }

    public function dislike(Post $post)
    {
        $this->toggleInteraction($post, 2);
        $this->models = $post;
    }
}
