@foreach($posts as $post)
    <tr id="post_{{ $post->id }}">
        <td>{{ $post->name }}</td>
        <td>{{ $post->author }}</td>
        <td>{{ $post->date }}</td>
        <td>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
            <button class="delete-btn btn btn-danger btn-sm" data-id="{{ $post->id }}">Delete</button>
        </td>
    </tr>
@endforeach
