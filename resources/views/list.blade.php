<!DOCTYPE html>
<html>

<head>
    <title>Uploaded Files</title>
</head>

<body>
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <h2>Uploaded Files</h2>
    <ul>
        @foreach ($files as $file)
            <li>
                {{ $file }}
                <a href="{{ route('file.download', ['fileName' => basename($file)]) }}">Download Decrypted</a>
            </li>
        @endforeach
    </ul>
</body>

</html>
