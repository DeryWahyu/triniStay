<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Transaksi - {{ $booking->booking_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .receipt-title {
            text-align: center;
            margin-bottom: 25px;
        }
        .receipt-title h2 {
            font-size: 18px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .booking-code {
            text-align: center;
            background: #f0f9ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .booking-code span {
            font-size: 10px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }
        .booking-code strong {
            font-size: 20px;
            color: #2563eb;
            letter-spacing: 2px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .info-label {
            display: table-cell;
            width: 40%;
            color: #666;
        }
        .info-value {
            display: table-cell;
            width: 60%;
            font-weight: 500;
        }
        .kos-details {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .kos-name {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .kos-address {
            color: #666;
            font-size: 11px;
        }
        .price-section {
            background: #f0fdf4;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .price-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }
        .price-label {
            display: table-cell;
            width: 60%;
        }
        .price-value {
            display: table-cell;
            width: 40%;
            text-align: right;
        }
        .total-row {
            border-top: 2px solid #22c55e;
            padding-top: 10px;
            margin-top: 10px;
        }
        .total-row .price-label,
        .total-row .price-value {
            font-size: 16px;
            font-weight: bold;
            color: #16a34a;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-approved {
            background: #dcfce7;
            color: #16a34a;
        }
        .status-completed {
            background: #dbeafe;
            color: #2563eb;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #666;
            font-size: 10px;
        }
        .footer p {
            margin-bottom: 3px;
        }
        .room-match-info {
            background: #fef3c7;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .room-match-info p {
            color: #92400e;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TriniStay</h1>
        <p>Platform Pencarian Kos Terpercaya</p>
    </div>

    <div class="receipt-title">
        <h2>Bukti Transaksi Pemesanan</h2>
    </div>

    <div class="booking-code">
        <span>Kode Pemesanan</span>
        <strong>{{ $booking->booking_code }}</strong>
    </div>

    <div class="section">
        <div class="section-title">Informasi Penyewa</div>
        <div class="info-row">
            <span class="info-label">Nama Lengkap</span>
            <span class="info-value">{{ $booking->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $booking->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Telepon</span>
            <span class="info-value">{{ $booking->user->phone ?? '-' }}</span>
        </div>
        @if($booking->sharedWithUser)
        <div class="room-match-info">
            <p><strong>Room Match:</strong> {{ $booking->sharedWithUser->name }} ({{ $booking->sharedWithUser->email }})</p>
        </div>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Detail Kos</div>
        <div class="kos-details">
            <div class="kos-name">{{ $booking->boardingHouse->name }}</div>
            <div class="kos-address">{{ $booking->boardingHouse->address }}</div>
        </div>
        <div class="info-row">
            <span class="info-label">Tipe Kos</span>
            <span class="info-value">{{ ucfirst($booking->boardingHouse->type ?? '-') }}</span>
        </div>
        @if($booking->room)
        <div class="info-row">
            <span class="info-label">Nomor Kamar</span>
            <span class="info-value">{{ $booking->room->room_number }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Periode Sewa</span>
            <span class="info-value">{{ $booking->duration }} Bulan</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Mulai</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($booking->start_date)->format('d F Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Selesai</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($booking->end_date)->format('d F Y') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Status Pemesanan</div>
        <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
                @if($booking->status == 'approved')
                <span class="status-badge status-approved">Disetujui</span>
                @elseif($booking->status == 'completed')
                <span class="status-badge status-completed">Selesai</span>
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Pemesanan</span>
            <span class="info-value">{{ $booking->created_at->format('d F Y, H:i') }} WIB</span>
        </div>
        @if($booking->payment_date)
        <div class="info-row">
            <span class="info-label">Tanggal Pembayaran</span>
            <span class="info-value">{{ \Carbon\Carbon::parse($booking->payment_date)->format('d F Y, H:i') }} WIB</span>
        </div>
        @endif
    </div>

    @php
        // Extract numeric value from duration string (e.g., "3_months", "3 bulan" -> 3)
        $durationMonths = (int) preg_replace('/[^0-9]/', '', $booking->duration);
        if ($durationMonths < 1) $durationMonths = 1;
    @endphp

    <div class="price-section">
        <div class="section-title" style="color: #16a34a; border-color: #bbf7d0;">Rincian Biaya</div>
        <div class="price-row">
            <span class="price-label">Harga per Bulan</span>
            <span class="price-value">Rp {{ number_format($booking->boardingHouse->price, 0, ',', '.') }}</span>
        </div>
        <div class="price-row">
            <span class="price-label">Durasi Sewa</span>
            <span class="price-value">{{ $durationMonths }} Bulan</span>
        </div>
        @if($booking->sharedWithUser)
        <div class="price-row">
            <span class="price-label">Subtotal ({{ $durationMonths }} x Rp {{ number_format($booking->boardingHouse->price, 0, ',', '.') }})</span>
            <span class="price-value">Rp {{ number_format($booking->boardingHouse->price * $durationMonths, 0, ',', '.') }}</span>
        </div>
        <div class="price-row">
            <span class="price-label">Pembagian Room Match (50%)</span>
            <span class="price-value">- Rp {{ number_format(($booking->boardingHouse->price * $durationMonths) / 2, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="price-row total-row">
            <span class="price-label">TOTAL BAYAR</span>
            <span class="price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini merupakan bukti transaksi yang sah.</p>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p style="margin-top: 10px;">© {{ date('Y') }} TriniStay - Platform Pencarian Kos Terpercaya</p>
    </div>
</body>
</html>
