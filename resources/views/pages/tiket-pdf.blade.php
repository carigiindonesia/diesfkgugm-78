<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tiket - Dies Natalis FKG UGM ke-78</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #1e293b;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .ticket-page {
      width: 148mm;
      min-height: 210mm;
      position: relative;
      page-break-after: always;
      background: #ffffff;
      overflow: hidden;
    }

    .ticket-page:last-child {
      page-break-after: auto;
    }

    /* Header */
    .ticket-header {
      background: #d97706;
      color: #ffffff;
      padding: 18px 24px;
      text-align: center;
      position: relative;
    }

    .ticket-header::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      right: 0;
      height: 8px;
      background: linear-gradient(135deg, #f59e0b 25%, transparent 25%) -10px 0,
                  linear-gradient(225deg, #f59e0b 25%, transparent 25%) -10px 0;
      background-size: 16px 8px;
    }

    .header-subtitle {
      font-size: 8px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.75);
      font-weight: 700;
      margin-bottom: 3px;
    }

    .header-title {
      font-size: 18px;
      font-weight: 900;
      margin-bottom: 2px;
    }

    .header-date {
      font-size: 10px;
      color: rgba(255, 255, 255, 0.85);
    }

    /* Event Badge */
    .event-badge {
      text-align: center;
      padding: 14px 24px 10px;
    }

    .event-badge-inner {
      display: inline-block;
      background: #fffbeb;
      border: 2px solid #f59e0b;
      border-radius: 10px;
      padding: 8px 20px;
    }

    .event-name {
      font-size: 14px;
      font-weight: 900;
      color: #92400e;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    /* Ticket Code Section */
    .ticket-code-section {
      text-align: center;
      padding: 8px 24px 12px;
      border-bottom: 2px dashed #e2e8f0;
    }

    .code-label {
      font-size: 7px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .code-value {
      font-size: 20px;
      font-weight: 900;
      color: #b45309;
      letter-spacing: 2px;
      font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
    }

    /* Body */
    .ticket-body {
      padding: 14px 24px;
    }

    /* Info Grid */
    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }

    .info-table td {
      padding: 5px 4px;
      vertical-align: top;
      width: 50%;
    }

    .info-label {
      font-size: 7px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 700;
      margin-bottom: 1px;
    }

    .info-value {
      font-size: 11px;
      font-weight: 700;
      color: #1e293b;
    }

    /* Event Details Box */
    .event-details {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 12px;
    }

    .event-detail-row {
      font-size: 10px;
      color: #475569;
      padding: 3px 0;
    }

    .event-detail-row strong {
      color: #1e293b;
    }

    /* Fun Run Box */
    .funrun-box {
      background: #ecfdf5;
      border: 2px solid #10b981;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 12px;
    }

    .funrun-title {
      font-size: 9px;
      font-weight: 900;
      color: #065f46;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 6px;
    }

    .funrun-detail {
      font-size: 10px;
      color: #047857;
      padding: 2px 0;
    }

    .funrun-detail strong {
      color: #065f46;
    }

    .funrun-note {
      font-size: 8px;
      color: #6b7280;
      font-style: italic;
      margin-top: 6px;
      padding-top: 6px;
      border-top: 1px dashed #a7f3d0;
    }

    /* Codes Section */
    .codes-section {
      text-align: center;
      padding: 8px 0;
    }

    .barcode-container {
      margin-bottom: 10px;
    }

    .barcode-container img {
      max-width: 200px;
      height: 50px;
    }

    .qr-container {
      display: inline-block;
      padding: 8px;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      background: #ffffff;
    }

    .qr-container img {
      width: 100px;
      height: 100px;
    }

    .qr-hint {
      font-size: 8px;
      color: #94a3b8;
      margin-top: 4px;
    }

    /* Support Box */
    .support-box {
      background: #eff6ff;
      border: 1px solid #bfdbfe;
      border-radius: 8px;
      padding: 10px 14px;
      margin-top: 10px;
    }

    .support-title {
      font-size: 8px;
      font-weight: 700;
      color: #1e40af;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .support-detail {
      font-size: 9px;
      color: #1e3a5f;
    }

    .support-detail strong {
      color: #1e40af;
    }

    /* Footer */
    .ticket-footer {
      text-align: center;
      padding: 8px 24px 12px;
      font-size: 7px;
      color: #94a3b8;
    }

    .footer-line {
      margin-bottom: 2px;
    }
  </style>
</head>
<body>
  @foreach($ticketsData as $data)
  @php
    $ticket = $data['ticket'];
    $barcode = $data['barcode'];
    $qrCode = $data['qrCode'];
    $isFunRun = $data['isFunRun'];
    $jerseyType = $data['jerseyType'] ?? null;
    $jerseySize = $data['jerseySize'] ?? null;

    $eventDateMap = [
      'simposium' => '17 - 20 April 2026',
      'handson' => '17 - 20 April 2026',
      'funrun' => '20 April 2026',
      'pengmas' => '17 - 20 April 2026',
    ];
    $eventDate = $eventDateMap[$ticket->event_code] ?? '17 - 20 April 2026';
  @endphp
  <div class="ticket-page">
    <!-- Header -->
    <div class="ticket-header">
      <p class="header-subtitle">Dies Natalis FKG UGM ke-78</p>
      <h1 class="header-title">E-TICKET</h1>
      <p class="header-date">Annual Symposium 2026</p>
    </div>

    <!-- Event Badge -->
    <div class="event-badge">
      <div class="event-badge-inner">
        <p class="event-name">{{ $ticket->event_label }}</p>
      </div>
    </div>

    <!-- Ticket Code -->
    <div class="ticket-code-section">
      <p class="code-label">Kode Tiket</p>
      <p class="code-value">{{ $ticket->ticket_code }}</p>
    </div>

    <!-- Body -->
    <div class="ticket-body">
      <!-- Participant Info -->
      <table class="info-table">
        <tr>
          <td>
            <p class="info-label">Nama Peserta</p>
            <p class="info-value">{{ $ticket->participant_name }}</p>
          </td>
          <td>
            <p class="info-label">Lembaga / Institusi</p>
            <p class="info-value">{{ $ticket->participant_lembaga ?? '-' }}</p>
          </td>
        </tr>
        <tr>
          <td>
            <p class="info-label">Kategori</p>
            <p class="info-value">{{ ucfirst($ticket->category) }}</p>
          </td>
          <td>
            <p class="info-label">No. Pesanan</p>
            <p class="info-value">{{ $ticket->order->order_number }}</p>
          </td>
        </tr>
      </table>

      <!-- Event Details -->
      <div class="event-details">
        <div class="event-detail-row"><strong>Tanggal:</strong> {{ $eventDate }}</div>
        <div class="event-detail-row"><strong>Lokasi:</strong> Fakultas Kedokteran Gigi UGM, Yogyakarta</div>
      </div>

      <!-- Fun Run Extra Details -->
      @if($isFunRun && ($jerseyType || $jerseySize))
      <div class="funrun-box">
        <p class="funrun-title">Detail Race Kit</p>
        @if($jerseyType)
        <p class="funrun-detail"><strong>Tipe Jersey:</strong> {{ ucfirst($jerseyType) }}</p>
        @endif
        @if($jerseySize)
        <p class="funrun-detail"><strong>Ukuran Jersey:</strong> {{ $jerseySize }}</p>
        @endif
        <p class="funrun-note">* Tiket ini sebagai bukti pengambilan Race Kit di FKG UGM. Harap tunjukkan tiket ini saat pengambilan Race Kit.</p>
      </div>
      @endif

      <!-- Barcode & QR Code -->
      <div class="codes-section">
        <div class="barcode-container">
          {!! $barcode !!}
        </div>
        <div class="qr-container">
          {!! $qrCode !!}
        </div>
        <p class="qr-hint">Scan QR Code saat registrasi ulang di lokasi acara</p>
      </div>

      <!-- Support Info -->
      <div class="support-box">
        <p class="support-title">Registrations Support & Helpdesk</p>
        <p class="support-detail"><strong>Carigi Indonesia</strong></p>
        <p class="support-detail">WhatsApp: <strong>085147686127</strong></p>
        <p class="support-detail" style="margin-top: 3px; font-size: 8px; color: #6b7280;">Hubungi kami jika ada kendala atau kesulitan terkait tiket dan registrasi.</p>
      </div>
    </div>

    <!-- Footer -->
    <div class="ticket-footer">
      <p class="footer-line">&copy; 2026 Panitia Dies Natalis FKG UGM ke-78. Tiket ini sah sebagai bukti pendaftaran.</p>
      <p class="footer-line">Harap simpan tiket ini dengan baik dan tunjukkan saat registrasi ulang di lokasi.</p>
    </div>
  </div>
  @endforeach
</body>
</html>
