<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhaka Pharmacy - Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        :root {
            --primary-color: #0088cc;
            --secondary-color: #4caf50;
            --border-color: #e5e7eb;
            --text-muted: #6b7280;
        }

        body {
            background-color: #f9fafb;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        .invoice-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 850px;
        }

        .logo {
            height: 48px;
            width: auto;
        }

        .invoice-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .invoice-number {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .divider {
            height: 1px;
            background-color: var(--border-color);
            margin: 2rem 0;
        }

        .label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
        }

        .table th {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            border-bottom-width: 1px;
            padding-bottom: 1rem;
        }

        .table td {
            padding: 1rem 0;
            vertical-align: top;
        }

        .table-item-title {
            font-weight: 500;
            color: #111827;
        }

        .table-item-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .status-badge {
            background-color: #eff6ff;
            color: var(--primary-color);
            padding: 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-badge svg {
            width: 20px;
            height: 20px;
        }

        .footer-text {
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Print Styles */
        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .invoice-card {
                box-shadow: none;
                margin: 0;
                padding: 1rem;
                max-width: 100%;
            }

            .status-badge {
                border: 1px solid var(--primary-color);
                background-color: transparent !important;
                -webkit-print-color-adjust: exact;
            }

            .table th, .table td {
                background-color: transparent !important;
                -webkit-print-color-adjust: exact;
            }

            /* Ensure page breaks don't occur within elements */
            tr, .status-badge, .footer-text {
                page-break-inside: avoid;
            }

            /* Force background colors in printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-card">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/logo-FTu8Sj6qokDFxedFZLSwjrDBrqHJ7k.png" alt="Dhaka Pharmacy Logo" class="logo">
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">#INV-2024-0123</div>
                </div>
            </div>

            <div class="divider"></div>

            <!-- Billing Info -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="label">Bill From</div>
                    <div class="fw-medium">Dhaka Pharmacy</div>
                    <div class="text-muted">
                        123 Medical Center Road<br>
                        Mirpur, Dhaka<br>
                        Bangladesh
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="label">Bill To</div>
                    <div class="fw-medium">John Smith</div>
                    <div class="text-muted">
                        456 Patient Street<br>
                        Dhaka, 1216<br>
                        Bangladesh
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="label">Invoice Date</div>
                    <div>February 21, 2024</div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="label">Due Date</div>
                    <div>March 21, 2024</div>
                </div>
                <div class="col-md-4">
                    <div class="label">Order ID</div>
                    <div>DPW25022145192</div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="table-responsive mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 40%">Item</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="table-item-title">Somazole Mups 40</div>
                                <div class="table-item-subtitle">6.5 x 5 pack</div>
                            </td>
                            <td>3</td>
                            <td>৳ 450.00</td>
                            <td class="text-end">৳ 1,350.00</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="table-item-title">Inosit 500</div>
                                <div class="table-item-subtitle">2.5 strip</div>
                            </td>
                            <td>2</td>
                            <td>৳ 320.00</td>
                            <td class="text-end">৳ 640.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Summary -->
            <div class="row justify-content-end mb-4">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Subtotal</div>
                        <div>৳ 1,990.00</div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Delivery Charge</div>
                        <div>৳ 80.00</div>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-muted">Discount</div>
                        <div>-৳ 100.00</div>
                    </div>
                    <div class="divider"></div>
                    <div class="d-flex justify-content-between fw-medium">
                        <div>Total</div>
                        <div>৳ 1,970.00</div>
                    </div>
                </div>
            </div>

            <!-- Status and Footer -->
            <div class="status-badge mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                    <path d="M3 9V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4"></path>
                </svg>
                Package has been prepared and is ready for dispatch
            </div>

            <div class="footer-text">
                Thank you for choosing Dhaka Pharmacy. For any queries, please contact us at support@dhakapharmacy.com
            </div>
        </div>
    </div>
</body>
</html>
