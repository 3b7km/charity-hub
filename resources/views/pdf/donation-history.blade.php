<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donation History - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 40px;
            color: #0A192F;
            font-size: 14px;
        }
        .header {
            text-align: center;
            margin-bottom: 50px;
            border-bottom: 2px solid #10B981;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #10B981;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .user-info {
            margin-bottom: 30px;
        }
        .user-info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #F9FAFB;
            color: #6B7280;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #E5E7EB;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #F3F4F6;
        }
        .amount {
            font-weight: bold;
            color: #10B981;
        }
        .total-section {
            text-align: right;
            margin-top: 30px;
            padding: 20px;
            background-color: #F9FAFB;
            border-radius: 10px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: black;
            color: #0A192F;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Donation History Report</h1>
        <p>CharityHub Foundation — Transparency Report</p>
    </div>

    <div class="user-info">
        <p><strong>Donor Name:</strong> {{ $user->name }}</p>
        <p><strong>Email Address:</strong> {{ $user->email }}</p>
        <p><strong>Report Generated:</strong> {{ $generatedAt }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Campaign</th>
                <th>Reference</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donations as $donation)
                <tr>
                    <td>{{ $donation->created_at->format('M d, Y') }}</td>
                    <td>{{ $donation->campaign->title }}</td>
                    <td style="font-size: 10px; color: #9CA3AF;">{{ $donation->id }}</td>
                    <td class="amount">{{ $donation->formatted_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p style="margin: 0; color: #6B7280; text-transform: uppercase; font-size: 10px; font-bold;">Cumulative Impact</p>
        <div class="total-amount">£{{ number_format($totalAmount / 100, 2) }}</div>
    </div>

    <div class="footer">
        <p>This is an official record of your contributions to CharityHub Foundation.</p>
        <p>© {{ date('Y') }} CharityHub. All rights reserved.</p>
    </div>
</body>
</html>
