<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification - NDM Advisors LLP</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: #004085;
        }
        table {
            width: 100%;
            height: 100vh;
            background: linear-gradient(to right, #004085, #007bff);
            text-align: center;
        }
        .wrapper {
            padding: 30px;
        }
        .container {
            max-width: 600px;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            border-top: 6px solid #004085;
            margin: auto;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #004085;
        }
        .otp {
            font-size: 30px;
            font-weight: bold;
            background: #004085;
            display: inline-block;
            padding: 16px 30px;
            border-radius: 8px;
            margin: 20px 0;
            color: #ffffff;
            letter-spacing: 4px;
        }
        p {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .company-logo {
            max-width: 120px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <table>
        <tr>
            <td class="wrapper">
                <div class="container">
                    <!-- <img class="company-logo" src="https://your-logo-url.com/logo.png" alt="NDM Advisors LLP Logo"> -->
                    <div class="header">NDM Advisors LLP</div>
                    <p>Dear User,</p>
                    <p>Your One-Time Password (OTP) for verification is:</p>
                    <div class="otp">{{ $otp_mail_data['otp'] }}</div>
                    <p>Please use this OTP to proceed with your authentication.</p>
                    <p>If you did not request this, please ignore this email.</p>
                    <div class="footer">
                        <p>Best Regards,</p>
                        <p><strong>NDM Advisors LLP</strong></p>
                        <p>© 2025 NDM Advisors LLP. All rights reserved.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
