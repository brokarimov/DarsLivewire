<div>
    @if (!$activeShow && !$postActive)
        <button type="button" class="btn btn-outline-primary" wire:click="{{$postActive ? 'falsePost' : 'truePost'}}">
            {{$postActive ? 'Admin Page' : 'User Page'}}
        </button><br>
    @else
        <a type="button" class="btn btn-outline-primary" href="/post" wire:navigate>
            Admin Page
        </a><br>
    @endif

    @if ($postActive == false)
        <h1>Post Page</h1>

        <button type="button" class="btn btn-outline-primary" wire:click="{{$activeForm ? 'close' : 'open'}}">
            {{$activeForm ? 'Close' : 'Create'}}
        </button>
        @if ($activeForm)
            <div class="row mt-2">
                <div class="col-4">
                    <form wire:submit.prevent="save">
                        <label for="">Title</label>
                        <input type="text" wire:model.blur="title" placeholder="Title" class="form-control mt-2">
                        @error('title')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Description</label>
                        <input type="text" wire:model.blur="description" placeholder="Description" class="form-control mt-2">
                        @error('description')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Text</label>
                        <input type="text" wire:model.blur="text" placeholder="Text" class="form-control mt-2">
                        @error('text')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Category</label>
                        <select wire:model.onchange="category_id" class="form-control mt-2">
                            <option value="">Choose Category</option>

                            @foreach ($categories as $category)
                                @if ($category->is_active == 1)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Photo</label>
                        <input type="file" wire:model.blur="photo" class="form-control">
                        @error('photo')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <button type="submit" class="btn btn-primary mt-2">Create</button>
                    </form>
                </div>
            </div>
        @endif
        @if (!$activeForm)
            <table class="table table-striped table-bordered mt-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Text</th>
                        <th>Photo</th>
                        <th>Options</th>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>
                            <input type="text" class="form-control" wire:model="searchTitle" wire:keydown="searchColumps"
                                placeholder="Search Title">
                        </th>
                        <th>
                            <select wire:model="searchCategory_id" wire:change="searchColumps" class="form-control">
                                <option value="">Choose Category</option>
                                @foreach ($categories as $category)
                                    @if ($category->is_active == 1)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </th>
                        <th>
                            <input type="text" class="form-control" wire:model="searchDescription" wire:keydown="searchColumps"
                                placeholder="Search Description">
                        </th>
                        <th>
                            <input type="text" class="form-control" wire:model="searchText" wire:keydown="searchColumps"
                                placeholder="Search Text">
                        </th>
                        <th>#</th>
                        <th>#</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($models as $model)
                        @if ($model->categories->is_active == 1)
                            @if ($editFormPost != $model->id)
                                <tr>
                                    <td>{{$model->id}}</td>
                                    <td class="truncate-cell">
                                        {{$model->title}}
                                    </td>
                                    <td>
                                        {{$model->categories->name}}
                                    </td>
                                    <td class="truncate-cell">
                                        {{$model->description}}
                                    </td>
                                    <td class="truncate-cell">
                                        {{$model->text}}
                                    </td>
                                    <td><img src="{{ asset('storage/' . $model->photo) }}" alt="" width="100px">
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <button class="btn btn-danger" wire:click="delete({{$model->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-warning" wire:click="editForm({{$model->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-pen" viewBox="0 0 16 16">
                                                    <path
                                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @if ($editFormPost == $model->id)
                                <tr>
                                    <td>{{$model->id}}</td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="titleEdit" placeholder="Title">
                                    </td>
                                    <td>
                                        <select class="form-control" wire:model="category_idEdit">
                                            <option value="">Choose Category</option>
                                            @foreach ($categories as $category)
                                                @if ($category->is_active == 1)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="descriptionEdit" placeholder="Description">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="textEdit" placeholder="Name">
                                    </td>
                                    <td>
                                        <input type="file" wire:model="photoEdit" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" wire:click="update({{$model->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-pen" viewBox="0 0 16 16">
                                                <path
                                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endif



                    @endforeach
                </tbody>
            </table>

        @endif
        {{ $models->links() }}


    @else

        <h1>Post Page cards</h1>
        <div class="row">
            <div class="col-3">
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active-category">
                            <a wire:click="categoryFilter({{null}})">Barchasi</a>
                        </li>
                        @forelse ($categories as $category)
                            @if ($category->is_active == 1)
                                <li class="list-group-item active-category">
                                    <a wire:click="categoryFilter({{$category->id}})">{{$category->name}}</a>
                                </li>
                            @endif
                        @empty
                            <li class="list-group-item">No active categories available.</li>
                        @endforelse


                    </ul>
                </div>
            </div>
            @if ($activeShow == false)
                    <div class="col-9">
                        <div class="row">
                            @foreach ($models as $model)
                                @if ($model->categories->is_active == 1)
                                <div class="col-4 mt-2 mb-2">
                                    <div class="card" style="width: 18rem;">

                                        <div class="card-body">
                                        <img class="card-img-top" src="{{ asset('storage/' . $model->photo) }}" alt="Card image cap" >
                                            <h5 class="card-title">{{$model->title}}</h5>
                                            <p class="card-text truncate-cell">
                                                {{$model->description}}
                                            </p>
                                            <a wire:click="show({{$model->id}})" class="btn btn-primary">More...</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                               
                            @endforeach
                        </div>
                        <div>
                            {{$models->links()}}
                        </div>
                    </div>
                </div>

            @else
                <div class="col-9">
                    <div class="row">
                        <div class="col-8">
                            <p><i class="bi bi-eye"></i> {{$models->views}}</p>
                            <img src="{{ asset('storage/' . $models->photo) }}" alt="" width="600px">
                            <h1>{{$models->title}}</h1>
                            <h3>{{$models->description}}</h3>
                            <p>{{$models->text}}</p>
                            <div>
    <button wire:click="like({{$models->id}})" class="btn {{ $userLikeStatus == 1 ? 'btn-primary' : 'btn-outline-primary' }} me-2">
        {{ $models->likes }} <i class="bi bi-hand-thumbs-up"></i>
    </button>

    <button wire:click="dislike({{$models->id}})" class="btn {{ $userLikeStatus == 2 ? 'btn-primary' : 'btn-outline-primary' }}">
        {{ $models->dislikes}} <i class="bi bi-hand-thumbs-down"></i>
    </button>
</div>

                            <textarea class="form-control mb-2 mt-2" wire:model="comment" placeholder="Comment"></textarea>
                            <input type="submit" wire:click="commentCreate({{$models->id}})" class="btn btn-primary mb-2">
                        </div>
                        <div class="col-4">
                            @php

function children($data, $models, $activeComment, $activeCommentID)
{
    if ($data->children->count() > 0) {
        echo '<ul>';
        foreach ($data->children as $child) {
            echo "<li>
                    {$child->comment}
                    <button class='btn-reply' wire:click='CommentActive({$models->id}, {$child->id})'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-reply' viewBox='0 0 16 16'>
                            <path d='M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.7 8.7 0 0 0-1.921-.306 7 7 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028zM7.8 10.386q.103 0 .223.006c.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96z' />
                        </svg>
                    </button>
                </li>";

            
            if ($activeComment && $activeCommentID == $child->id) {
                echo "<div class='row'>
                        <div class='col-8'>
                            <input type='text' wire:model='childComment' class='form-control' placeholder='Reply'>
                        </div>
                        <div class='col-4'>
                            <button wire:click='CreateCommetChild({$child->id}, {$models->id})' class='btn btn-primary'>Submit</button>
                        </div>
                    </div>";
            }

            
            children($child, $models, $activeComment, $activeCommentID);
        }
        echo '</ul>';
    }
}






                            @endphp
                            @foreach ($comments as $comment)
                                @if ($comment->post_id == $models->id)
                                    <li>
                                        {{$comment->comment}}
                                        <button class="btn-reply" wire:click="CommentActive({{$models->id}}, {{$comment->id}})">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-reply" viewBox="0 0 16 16">
                                                <path
                                                    d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.7 8.7 0 0 0-1.921-.306 7 7 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028zM7.8 10.386q.103 0 .223.006c.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96z" />
                                            </svg>
                                        </button>
                                    </li>

                                    @if ($activeComment && $activeCommentID == $comment->id)
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" wire:model="childComment" class="form-control" placeholder="Reply">

                                            </div>
                                            <div class="col-4">
                                                <input type="submit" wire:click="CreateCommetChild({{$comment->id}},{{$models->id}})" class="btn btn-primary">

                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        children($comment, $models, $activeComment,$activeCommentID);  // Recursively render children comments if any
                                    @endphp
                                @endif
                            @endforeach

                            <div>
                            </div>

                        </div>
                    </div>
            @endif

    @endif
    </div>