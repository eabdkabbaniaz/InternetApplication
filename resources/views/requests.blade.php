<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table>
    <thead>
        <tr>
            <th>الوقت</th>
            <th>الطريقة</th>
            <th>المسار</th>
            <th>الرمز</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
            <tr>
                <td>{{ $request->created_at }}</td>
                <td>{{ $request->content->method() }}</td>
                <td>{{ $request->content->uri }}</td>
                <td>{{ $request->content['status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>