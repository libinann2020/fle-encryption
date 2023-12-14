<!DOCTYPE html>
<html>

<head>
    <title>File Encryption</title>
</head>

<body>
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('file.upload') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <button type="submit">Upload & Encrypt</button>
    </form>

</body>

</html>
