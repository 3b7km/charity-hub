<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f8fafc; color: #1e293b; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
        .header { text-align: center; padding: 30px 0; }
        .logo { font-size: 24px; font-weight: bold; color: #f59e0b; }
        .card { background: #ffffff; border-radius: 12px; padding: 40px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .greeting { font-size: 20px; font-weight: 600; margin-bottom: 16px; }
        .text { font-size: 15px; color: #475569; line-height: 1.7; margin-bottom: 16px; }
        .amount-box { background: linear-gradient(135deg, #10b981, #059669); color: #fff; text-align: center; padding: 24px; border-radius: 8px; margin: 24px 0; }
        .amount-label { font-size: 12px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.9; }
        .amount-value { font-size: 36px; font-weight: 700; margin-top: 4px; }
        .footer { text-align: center; padding: 20px 0; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">♥ CharityHub</div>
        </div>
        <div class="card">
            <div class="greeting">Thank you, {{ $donorName }}!</div>
            <div class="text">
                Your generous donation to <strong>{{ $campaignTitle }}</strong> has been successfully received.
                Your contribution makes a real difference in the lives of those we serve.
            </div>
            <div class="amount-box">
                <div class="amount-label">Your Donation</div>
                <div class="amount-value">{{ $amount }}</div>
            </div>
            <div class="text">
                Date: <strong>{{ $donatedAt }}</strong>
            </div>
            <div class="text">
                Your donation certificate is attached to this email. You can also verify it using the QR code on the certificate.
            </div>
            <div class="text" style="margin-top: 24px;">
                With gratitude,<br>
                <strong>The CharityHub Team</strong>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} CharityHub. All rights reserved.
        </div>
    </div>
</body>
</html>
