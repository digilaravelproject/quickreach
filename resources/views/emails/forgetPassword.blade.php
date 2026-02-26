<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background: white; padding: 20px; border-radius: 10px; max-width: 500px; margin: auto;">
        <h2 style="color: #333;">Bhai, Password bhul gaye?</h2>
        <p>Koi baat nahi, niche diye gaye button par click karke apna password reset kar lo.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ url('reset-password/' . $token) }}"
                style="background: #007bff; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;">
                Reset Password Karein
            </a>
        </div>

        <p>Agar aapne ye request nahi ki hai, toh is email ko ignore karein.</p>
        <hr>
        <p style="font-size: 12px; color: #777;">Yeh link 60 minutes tak valid hai.</p>
    </div>
</body>

</html>
