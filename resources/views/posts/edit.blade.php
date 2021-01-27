<h1>Edit</h1>

<form action="{{ route('post.update', $post->id) }}" method="POST">
    @csrf
    @method('POST')
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ $post->title }}">
    <label for="author">Author</label>
    <input type="text" name="author" id="author" value="{{ $post->author }}">
    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10">{{ $post->description }}</textarea>
    <button type="submit">Envoyer</button>
</form>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('message'))
    {{ session()->get('message') }}
@endif

