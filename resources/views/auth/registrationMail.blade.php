<!doctype html>
<html lang="en">
<head>
    <title>{{$data['title']}}</title>
</head>
<body>

    <table>
        <tr>
            <th>
                Name
            </th>
            <TH>{{$data['name']}}</TH>
        </tr>

        <tr>
            <th>
                Email
            </th>
            <TH>{{$data['email']}}</TH>
        </tr>

        <tr>
            <th>
                Password
            </th>
            <TH>{{$data['password']}}</TH>
        </tr>
    </table>
<a href="{{$data['url']}}"> Click here to login</a>
</body>
</html>
