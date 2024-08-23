<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Form</title>
</head>
<body>
    @if (count($errors) > 0)
        <div class = "alert alert-danger" >
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

    <form action="{{ route('validateForm') }}" method="POST">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <table align="center">
            <tr>
                <td>Imie</td>
                <td>
                    <input type="text" name="name" value="{{ old('name') }}">
                </td>
            </tr>
            <tr>
                <td>Nazwisko</td>
                <td>
                    <input type="text" name="surname" value="{{ old('surname') }}">
                </td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td>
                    <input type="text" name="email" value="{{ old('email') }}">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Wyślij">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
