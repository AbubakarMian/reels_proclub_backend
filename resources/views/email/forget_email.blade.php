
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>new Password</title>
    <style>
        /* Add your custom email styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            max-width: 100px;
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        .password {
            font-weight: bold;
            font-size: 18px;
            background-color: #f4f4f4;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow-wrap: break-word; /* Ensure long passwords wrap */
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        .copy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{!! asset('images/logo.png')!!}" alt="Company Logo">
        </div>
        <h1>New Password</h1>
        <p>Hello,</p>
        <p>You've requested a new password for your account. Here is your new password:</p>
        <p class="password" id="new-password">{!!$details['new_password']!!}</p>
        <button class="copy-button" onclick="copynewPassword()">Copy Password</button>
        <p>Please log in using this new password.</p>
        <p>If you didn't request this new password, please contact us immediately.</p>
        <p>Thank you,</p>
        <p>Reels Pro Club</p>
        <p>Contact us at <a href="mailto:info@reelsproclub.com">info@reelsproclub.com</a></p>
    </div>

    <script>
        function copynewPassword() {
            var newPassword = document.getElementById('new-password');
            var tempPasswordText = newPassword.innerText;

            // Create a new textarea element to copy the text
            var tempTextarea = document.createElement('textarea');
            tempTextarea.value = tempPasswordText;
            document.body.appendChild(tempTextarea);

            // Select and copy the text
            tempTextarea.select();
            document.execCommand('copy');

            // Remove the new textarea
            document.body.removeChild(tempTextarea);

            // Optionally, provide feedback to the user
            alert('new password copied to clipboard!');
        }
    </script>
</body>
</html>
