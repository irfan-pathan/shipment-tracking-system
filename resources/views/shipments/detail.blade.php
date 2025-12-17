<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipment Details</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
            color: #555;
        }

        .tracking-box {
            background: #f1f5ff;
            padding: 15px;
            border-left: 5px solid #007bff;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .tracking-box strong {
            font-size: 16px;
            color: #333;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-card {
            background: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .info-card p {
            margin: 5px 0;
            color: #444;
        }

        .timeline {
            margin-top: 20px;
            padding-left: 20px;
            border-left: 3px solid #007bff;
        }

        .timeline-item {
            margin-bottom: 20px;
            position: relative;
            padding-left: 20px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: -11px;
            top: 5px;
            width: 14px;
            height: 14px;
            background-color: #007bff;
            border-radius: 50%;
        }

        .timeline-status {
            font-weight: bold;
            color: #333;
        }

        .timeline-location {
            color: #666;
            font-size: 14px;
        }

        .timeline-date {
            font-size: 13px;
            color: #999;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }


        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Shipment Details</h2>

        <div class="tracking-box">
            <strong>Tracking Number:</strong> {{ $shipment->tracking_number }}
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>Sender</h3>
                <p><strong>{{ $shipment->sender_name }}</strong></p>
                <p>{{ $shipment->sender_address }}</p>
            </div>

            <div class="info-card">
                <h3>Receiver</h3>
                <p><strong>{{ $shipment->receiver_name }}</strong></p>
                <p>{{ $shipment->receiver_address }}</p>
            </div>
        </div>

        <h3>Status Timeline</h3>

        <div class="timeline">
            @forelse ($shipment->statusLogs as $log)
                <div class="timeline-item">
                    <div class="timeline-status">
                        {{ $log->status }}
                    </div>
                    <div class="timeline-location">
                        {{ $log->location }}
                    </div>
                    <div class="timeline-date">
                        {{ $log->created_at->format('d M Y, H:i:A') }}
                    </div>
                </div>
            @empty
                <p>No data available.</p>
            @endforelse
        </div>
        <button class="btn-back" onclick="window.location='{{ route('shipments.index') }}'">
            Back
        </button>
    </div>

</body>

</html>
