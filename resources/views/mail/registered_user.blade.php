<!DOCTYPE html>
<html>
<head>
    <title>Account Created</title>
</head>
<body>
    <h1>Welcome, {{ Str::title($user->firstname) }} {{ Str::title($user->lastname) }}!</h1>
    <p>Your account has been created successfully.</p>
    <p>Your password is: <strong>{{ $randomPassword }}</strong></p>
    <p>Please change your password upon your first login. Visit the link here<a href="http://localhost:8000/"></a></p>
    <p>Yours Truly,</p>
    <p>FacTrack</p>
</body>
</html>