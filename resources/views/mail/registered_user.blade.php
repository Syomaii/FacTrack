<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Created</title>
    <style>
        /* Basic styling to ensure good appearance across email clients */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        a {
            color: #1a73e8;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Welcome, {{ Str::title($user->firstname) }} {{ Str::title($user->lastname) }}!</h1>
        <p>Your account has been created successfully.</p>

        <p><strong>Your password:</strong> 
            <span style="font-weight: bold; display: block; margin: 10px 0; font-size: 18px;">{{ $randomPassword }}</span>
        </p>

        <p><em>Please change your password upon your first login.</em></p>

        <p>Access your account here: <a href="http://localhost:8000/">FacTrack</a></p>

        <p>Yours Truly,</p>
        <p><strong>FacTrack Team</strong></p>
    </div>
</body>
</html>
