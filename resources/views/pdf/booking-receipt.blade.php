<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Transaksi - {{ $booking->booking_code }}</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #1f2937;
            background: #fff;
        }
        .container {
            padding: 0;
        }
        /* Header with gradient */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
            padding: 30px 40px;
            color: white;
            position: relative;
        }
        .header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: #fff;
            border-radius: 30px 30px 0 0;
        }
        .header-content {
            display: table;
            width: 100%;
        }
        .logo-section {
            display: table-cell;
            vertical-align: middle;
        }
        .logo-section h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 3px;
            letter-spacing: 1px;
        }
        .logo-section p {
            font-size: 11px;
            opacity: 0.9;
        }
        .receipt-info {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }
        .receipt-info .receipt-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            margin-bottom: 3px;
        }
        .receipt-info .receipt-number {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        /* Content */
        .content {
            padding: 30px 40px;
        }
        /* Status Banner */
        .status-banner {
            text-align: center;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .status-approved {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border: 1px solid #86efac;
        }
        .status-completed {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border: 1px solid #93c5fd;
        }
        .status-banner .status-icon {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .status-banner .status-text {
            font-size: 14px;
            font-weight: bold;
            color: #166534;
        }
        .status-completed .status-text {
            color: #1e40af;
        }
        .status-banner .status-date {
            font-size: 10px;
            color: #4b5563;
            margin-top: 3px;
        }
        /* Section styling */
        .section {
            margin-bottom: 20px;
        }
        .section-header {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .section-title {
            display: table-cell;
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .section-line {
            display: table-cell;
            vertical-align: middle;
            padding-left: 15px;
        }
        .section-line::after {
            content: '';
            display: block;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, transparent);
        }
        /* Card styling */
        .card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .card-highlight {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border: 1px solid #93c5fd;
        }
        .kos-name {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        .kos-type {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .kos-type-putra {
            background: #dbeafe;
            color: #1e40af;
        }
        .kos-type-putri {
            background: #fce7f3;
            color: #be185d;
        }
        .kos-type-campur {
            background: #f3e8ff;
            color: #7c3aed;
        }
        .kos-address {
            color: #6b7280;
            font-size: 10px;
            line-height: 1.4;
        }
        /* Info rows */
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            padding: 6px 0;
            color: #6b7280;
            width: 40%;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            padding: 6px 0;
            font-weight: 500;
            color: #1f2937;
            vertical-align: top;
        }
        /* Room info */
        .room-badge {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 12px;
        }
        /* Room Match info */
        .room-match-card {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fbbf24;
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 10px;
        }
        .room-match-title {
            font-size: 10px;
            font-weight: bold;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .room-match-content {
            color: #78350f;
            font-size: 11px;
        }
        /* Price section */
        .price-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px solid #86efac;
            border-radius: 12px;
            padding: 20px;
        }
        .price-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #86efac;
        }
        .price-header-title {
            font-size: 12px;
            font-weight: bold;
            color: #166534;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .price-grid {
            display: table;
            width: 100%;
        }
        .price-row {
            display: table-row;
        }
        .price-label {
            display: table-cell;
            padding: 5px 0;
            color: #4b5563;
        }
        .price-value {
            display: table-cell;
            padding: 5px 0;
            text-align: right;
            font-weight: 500;
        }
        .price-divider {
            border-top: 2px dashed #86efac;
            margin: 12px 0;
        }
        .total-row {
            margin-top: 10px;
        }
        .total-label {
            display: table-cell;
            font-size: 14px;
            font-weight: bold;
            color: #166534;
            padding: 8px 0;
        }
        .total-value {
            display: table-cell;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #166534;
            padding: 8px 0;
        }
        /* Footer */
        .footer {
            margin-top: 30px;
            padding: 20px 40px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        .footer-content {
            text-align: center;
        }
        .footer-text {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 5px;
        }
        .footer-brand {
            font-size: 11px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 10px;
        }
        .qr-placeholder {
            text-align: center;
            margin-top: 15px;
            padding: 10px;
            background: #fff;
            border: 1px dashed #d1d5db;
            border-radius: 8px;
        }
        .qr-placeholder p {
            font-size: 9px;
            color: #9ca3af;
        }
        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 100px;
            right: 30px;
            font-size: 60px;
            color: rgba(59, 130, 246, 0.05);
            font-weight: bold;
            transform: rotate(-30deg);
            z-index: -1;
        }
    </style>
</head>
<body>
    @php
        // Set timezone to Indonesia (WIB)
        $timezone = 'Asia/Jakarta';
        $now = \Carbon\Carbon::now($timezone);
        
        // Parse duration to get label and months
        $durationLabel = $booking->duration_label ?? $booking->duration;
        $durationMonths = match($booking->duration) {
            '1_month' => 1,
            '3_months' => 3,
            '6_months' => 6,
            '1_year' => 12,
            default => (int) preg_replace('/[^0-9]/', '', $booking->duration) ?: 1,
        };
        
        // Get correct prices from booking
        $pricePerPeriod = $booking->price_per_period ?? $booking->total_price;
        $totalPrice = $booking->total_price;
        
        // Calculate monthly price for display
        $monthlyPrice = $durationMonths > 0 ? round($pricePerPeriod / $durationMonths) : $pricePerPeriod;
        
        // For Room Match, use room_match_price from boarding house
        $isRoomMatch = $booking->is_shared && $booking->sharedWithUser;
        
        if ($isRoomMatch && $booking->boardingHouse->room_match_price) {
            $roomMatchTotalPrice = $booking->boardingHouse->room_match_price;
            $pricePerPerson = round($roomMatchTotalPrice / 2);
        }
    @endphp

    <div class="watermark">TRINISTAY</div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="logo-section">
                    <h1>🏠 TriniStay</h1>
                    <p>Platform Pencarian Kos Terpercaya</p>
                </div>
                <div class="receipt-info">
                    <div class="receipt-label">Kode Transaksi</div>
                    <div class="receipt-number">{{ $booking->booking_code }}</div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Status Banner -->
            <div class="status-banner {{ $booking->status == 'completed' ? 'status-completed' : 'status-approved' }}">
                <div class="status-icon">
                    @if($booking->status == 'completed')
                        ✅
                    @else
                        ✓
                    @endif
                </div>
                <div class="status-text">
                    @if($booking->status == 'completed')
                        Transaksi Selesai
                    @else
                        Pemesanan Disetujui
                    @endif
                </div>
                <div class="status-date">
                    Tanggal Transaksi: {{ $booking->created_at->translatedFormat('d F Y') }}
                </div>
            </div>

            <!-- Kos Details -->
            <div class="section">
                <div class="section-header">
                    <span class="section-title">Detail Kos</span>
                    <span class="section-line"></span>
                </div>
                <div class="card card-highlight">
                    <span class="kos-type kos-type-{{ $booking->boardingHouse->type ?? 'campur' }}">
                        Kos {{ ucfirst($booking->boardingHouse->type ?? 'Campur') }}
                    </span>
                    <div class="kos-name">{{ $booking->boardingHouse->name }}</div>
                    <div class="kos-address">📍 {{ $booking->boardingHouse->address }}</div>
                </div>
                
                <div class="card">
                    <div class="info-grid">
                        @if($booking->room)
                        <div class="info-row">
                            <span class="info-label">Nomor Kamar</span>
                            <span class="info-value">
                                <span class="room-badge">Kamar {{ $booking->room->room_number }}</span>
                            </span>
                        </div>
                        @endif
                        <div class="info-row">
                            <span class="info-label">Durasi Sewa</span>
                            <span class="info-value">{{ $durationLabel }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Periode Sewa</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($booking->start_date)->timezone($timezone)->translatedFormat('d M Y') }} 
                                — 
                                {{ \Carbon\Carbon::parse($booking->end_date)->timezone($timezone)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Renter Info -->
            <div class="section">
                <div class="section-header">
                    <span class="section-title">Informasi Penyewa</span>
                    <span class="section-line"></span>
                </div>
                <div class="card">
                    <div class="info-grid">
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
                            <span class="info-value">{{ $booking->user->phone_number ?? '-' }}</span>
                        </div>
                    </div>

                    @if($isRoomMatch)
                    <div class="room-match-card">
                        <div class="room-match-title">👥 Room Match Partner</div>
                        <div class="room-match-content">
                            <strong>{{ $booking->sharedWithUser->name }}</strong><br>
                            {{ $booking->sharedWithUser->email }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Price Section -->
            <div class="section">
                <div class="section-header">
                    <span class="section-title">Rincian Pembayaran</span>
                    <span class="section-line"></span>
                </div>
                <div class="price-card">
                    <div class="price-header">
                        <div class="price-header-title">💰 Rincian Biaya</div>
                    </div>
                    
                    <div class="price-grid">
                        @if($isRoomMatch)
                            <div class="price-row">
                                <span class="price-label">Harga Kamar (Room Match)</span>
                                <span class="price-value">Rp {{ number_format($roomMatchTotalPrice ?? ($pricePerPeriod * 2), 0, ',', '.') }}</span>
                            </div>
                            <div class="price-row">
                                <span class="price-label">Bagian Anda (50%)</span>
                                <span class="price-value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div class="price-row">
                                <span class="price-label">Harga Sewa ({{ $durationLabel }})</span>
                                <span class="price-value">Rp {{ number_format($pricePerPeriod, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="price-divider"></div>
                    
                    <div class="price-grid total-row">
                        <span class="total-label">TOTAL DIBAYAR</span>
                        <span class="total-value">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <p class="footer-text">Dokumen ini merupakan bukti transaksi yang sah dan dicetak secara digital.</p>
                <p class="footer-text">Simpan dokumen ini sebagai bukti pembayaran Anda.</p>
                <p class="footer-text" style="margin-top: 10px;">
                    📅 Dicetak pada: {{ $now->translatedFormat('d F Y') }}
                </p>
                <p class="footer-brand">© {{ date('Y') }} TriniStay — Platform Pencarian Kos Terpercaya</p>
            </div>
        </div>
    </div>
</body>
</html>
