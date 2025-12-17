<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipments</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            background: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-form input {
            flex: 1;
            padding: 10px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .search-form button {
            padding: 10px 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background-color: #007bff;
            color: #ffffff;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
        }

        table tr {
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background-color: #f1f5ff;
        }

        table a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        table a:hover {
            text-decoration: underline;
        }

        .status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
        }

        .status.pending {
            background-color: #ffc107;
            color: #000;
        }

        .status.delivered {
            background-color: #28a745;
        }

        .status.in-transit {
            background-color: #17a2b8;
        }

        .dataTables_filter input {
            padding: 6px;
            margin-left: 8px;
            margin-bottom: 20px;
        }

        .dataTables_length select {
            padding: 4px;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-error alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif


    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Shipments</h2>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#shipmentModal">
                + Add Shipment
            </button>
        </div>

        <table id="shipmentsTable" class="display">
            <thead>
                <tr>
                    <th>Tracking Number</th>
                    <th>Receiver</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($shipments as $shipment)
                    <tr>
                        <td>
                            <a href="{{ route('shipments.detail', $shipment->id) }}">
                                {{ $shipment->tracking_number }}
                            </a>
                        </td>
                        <td>{{ $shipment->receiver_name }}</td>
                        <td>{{ $shipment->receiver_address }}</td>
                        <td>
                            <form method="POST" action="{{ route('shipments.updateStatus', $shipment->id) }}">
                                @csrf
                                <input type="hidden" name="shipment_id" value="{{ $shipment->id }}">
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="Pending" {{ $shipment->status == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="In Transit"
                                        {{ $shipment->status == 'In Transit' ? 'selected' : '' }}>
                                        In Transit
                                    </option>
                                    <option value="Delivered" {{ $shipment->status == 'Delivered' ? 'selected' : '' }}>
                                        Delivered
                                    </option>
                                </select>
                            </form>
                        </td>

                        <td>{{ $shipment->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="shipmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Add Shipment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('shipments.store') }}">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @csrf

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tracking Number</label>
                                <input type="text" name="tracking_number" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Pending">Pending</option>
                                    <option value="In Transit">In Transit</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Sender Name</label>
                                <input type="text" name="sender_name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Receiver Name</label>
                                <input type="text" name="receiver_name" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Sender Address</label>
                                <textarea name="sender_address" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Receiver Address</label>
                                <textarea name="receiver_address" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save Shipment
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any())
        <script>
            const modal = new bootstrap.Modal(document.getElementById('shipmentModal'));
            modal.show();
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#shipmentsTable').DataTable({
                pageLength: 10,
                lengthChange: true,
                ordering: true,
                searching: true,
                language: {
                    search: "Search Tracking:"
                }
            });
        });
    </script>
</body>

</html>
