<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donor Certificate - {{ $donation->id }}</title>
    <style>
        @page {
            margin: 0;
            size: a4 landscape;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            color: #0A192F;
            width: 100%;
            height: 100%;
        }
        .certificate-wrapper {
            position: absolute;
            top: 20px;
            bottom: 20px;
            left: 20px;
            right: 20px;
            border: 15px double #10B981;
            padding: 40px;
            text-align: center;
            background-color: #ffffff;
            box-sizing: border-box;
        }
        .header {
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 42px;
            color: #0A192F;
            margin: 0;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header p {
            color: #F59E0B;
            font-size: 16px;
            font-weight: bold;
            margin-top: 5px;
        }
        .content {
            margin-top: 20px;
            margin-bottom: 30px;
            font-size: 18px;
            line-height: 1.5;
        }
        .donor-name {
            font-size: 32px;
            font-weight: bold;
            color: #0A192F;
            border-bottom: 2px solid #10B981;
            display: inline-block;
            padding-bottom: 5px;
            margin: 15px 0;
        }
        .amount {
            font-size: 22px;
            font-weight: bold;
            color: #10B981;
        }
        .campaign-name {
            font-style: italic;
            font-weight: bold;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            left: 60px;
            right: 60px;
            text-align: center;
        }
        .signature {
            border-top: 1px solid #0A192F;
            width: 250px;
            text-align: center;
            padding-top: 10px;
            margin: 0 auto;
            display: inline-block;
        }
        .qr-code {
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: right;
        }
        .qr-code img {
            width: 80px;
            height: 80px;
        }
        .seal {
            position: absolute;
            bottom: 0px;
            left: 0px;
            color: #F59E0B;
            font-size: 40px;
        }
    </style>
</head>
<body>

    <div class="certificate-wrapper">
        <div class="header">
            <h1>Certificate of Appreciation</h1>
            <p>CharityHub Foundation</p>
        </div>

        <div class="content">
            <p>This certificate is proudly presented to</p>
            <div class="donor-name">{{ $donation->donor->name ?? 'Anonymous Donor' }}</div>
            <p>in profound recognition of your generous contribution of</p>
            <div class="amount">{{ Number::currency($donation->amount / 100, $donation->currency ?? 'GBP') }}</div>
            <p>towards the <span class="campaign-name">{{ $donation->campaign->title ?? 'General Fund' }}</span> campaign.</p>
            <p style="margin-top: 30px; font-size: 16px; color: #666;">
                Your support brings hope and lasting change. Thank you for making a difference.
            </p>
        </div>

        <div class="footer">
            <div class="seal">★</div>
            
            <div class="signature">
                <br>
                <strong>Jane Doe</strong><br>
                <span style="font-size: 12px; color: #666;">Executive Director, CharityHub</span>
            </div>

            <div class="qr-code">
                @if(isset($qrCode))
                    <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="Verification QR Code">
                @endif
                <div style="font-size: 10px; margin-top: 5px;">Scan to Verify</div>
            </div>
        </div>
    </div>

</body>
</html>
