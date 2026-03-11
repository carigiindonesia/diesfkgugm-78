<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tiket {{ $ticket->ticket_code }} - Dies Natalis FKG UGM ke-78</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8fafc;
      color: #1e293b;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .ticket {
      width: 148mm;
      min-height: 210mm;
      margin: 0 auto;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      overflow: hidden;
    }

    .ticket-header {
      background: linear-gradient(135deg, #d97706, #f59e0b, #daa520);
      color: #ffffff;
      padding: 24px 32px;
      text-align: center;
    }

    .ticket-header .subtitle {
      font-size: 10px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 4px;
      font-weight: 700;
    }

    .ticket-header h1 {
      font-size: 22px;
      font-weight: 900;
      margin-bottom: 4px;
    }

    .ticket-header .date {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.8);
    }

    .ticket-code {
      text-align: center;
      padding: 16px 32px;
      border-bottom: 2px dashed #e2e8f0;
    }

    .ticket-code .label {
      font-size: 9px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 700;
      margin-bottom: 4px;
    }

    .ticket-code .code {
      font-size: 24px;
      font-weight: 900;
      color: #b8860b;
      letter-spacing: 2px;
      font-family: 'Courier New', monospace;
    }

    .ticket-body {
      padding: 24px 32px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 20px;
    }

    .info-item .label {
      font-size: 9px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #94a3b8;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .info-item .value {
      font-size: 13px;
      font-weight: 700;
      color: #1e293b;
    }

    .event-box {
      background: #fffbeb;
      border: 1px solid #fde68a;
      border-radius: 12px;
      padding: 16px;
      margin-bottom: 20px;
    }

    .event-box .event-row {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 12px;
      font-weight: 700;
      color: #92400e;
      margin-bottom: 4px;
    }

    .event-box .event-row:last-child {
      margin-bottom: 0;
    }

    .event-box .icon {
      width: 14px;
      height: 14px;
      flex-shrink: 0;
    }

    .codes-section {
      text-align: center;
      padding: 16px 0;
    }

    .codes-section .barcode-container {
      margin-bottom: 16px;
    }

    .codes-section .barcode-container svg {
      max-width: 100%;
      height: auto;
    }

    .codes-section .qr-container {
      display: inline-block;
      padding: 12px;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      margin-bottom: 8px;
    }

    .codes-section .qr-container svg {
      width: 120px;
      height: 120px;
    }

    .codes-section .qr-hint {
      font-size: 10px;
      color: #94a3b8;
    }

    .ticket-footer {
      text-align: center;
      padding: 16px 32px 24px;
      font-size: 9px;
      color: #94a3b8;
      letter-spacing: 1px;
    }

    @media print {
      @page {
        size: A5 portrait;
        margin: 0;
      }

      body {
        background: #ffffff;
      }

      .ticket {
        width: 100%;
        border: none;
        box-shadow: none;
      }

      .no-print {
        display: none !important;
      }
    }

    @media screen {
      .ticket {
        margin-top: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        border-radius: 16px;
      }
    }
  </style>
</head>
<body>
  <div class="ticket">
    <!-- Header -->
    <div class="ticket-header">
      <p class="subtitle">Dies Natalis FKG UGM ke-78</p>
      <h1>Annual Symposium 2026</h1>
      <p class="date">17 - 19 April 2026</p>
    </div>

    <!-- Ticket Code -->
    <div class="ticket-code">
      <p class="label">Kode Tiket</p>
      <p class="code">{{ $ticket->ticket_code }}</p>
    </div>

    <!-- Body -->
    <div class="ticket-body">
      <!-- Participant Info -->
      <div class="info-grid">
        <div class="info-item">
          <p class="label">Nama Peserta</p>
          <p class="value">{{ $ticket->order->nama_lengkap }}</p>
        </div>
        <div class="info-item">
          <p class="label">Lembaga</p>
          <p class="value">{{ $ticket->order->lembaga ?? '-' }}</p>
        </div>
        <div class="info-item">
          <p class="label">Kategori</p>
          <p class="value">{{ ucfirst($ticket->order->category) }}</p>
        </div>
        <div class="info-item">
          <p class="label">Kegiatan</p>
          <p class="value">{{ $ticket->event_label }}</p>
        </div>
      </div>

      <!-- Event Info -->
      <div class="event-box">
        <div class="event-row">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
          <span>17 - 19 April 2026</span>
        </div>
        <div class="event-row">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#92400e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          <span>Fakultas Kedokteran Gigi UGM, Yogyakarta</span>
        </div>
      </div>

      <!-- Barcode -->
      <div class="codes-section">
        <div class="barcode-container">
          {!! $barcode !!}
        </div>

        <!-- QR Code -->
        <div class="qr-container">
          {!! $qrCode !!}
        </div>
        <p class="qr-hint">Scan QR Code saat registrasi ulang di lokasi</p>
      </div>
    </div>

    <!-- Footer -->
    <div class="ticket-footer">
      &copy; 2026 Panitia Dies Natalis FKG UGM ke-78. Tiket ini sah sebagai bukti pendaftaran.
    </div>
  </div>

  <script>
    window.onload = function() {
      window.print();
    };
  </script>
</body>
</html>
