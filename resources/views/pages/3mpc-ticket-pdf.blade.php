<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Submission {{ $submission->submission_number }} - 3MPC Dies Natalis FKG UGM ke-78</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
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
      background: #ffffff;
      overflow: hidden;
    }

    .ticket-header {
      background: #7c3aed;
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
      background: linear-gradient(135deg, #8b5cf6 25%, transparent 25%) -10px 0,
                  linear-gradient(225deg, #8b5cf6 25%, transparent 25%) -10px 0;
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
      font-size: 16px;
      font-weight: 900;
      margin-bottom: 2px;
    }

    .header-date {
      font-size: 10px;
      color: rgba(255, 255, 255, 0.85);
    }

    .submission-badge {
      text-align: center;
      padding: 14px 24px 10px;
    }

    .submission-badge-inner {
      display: inline-block;
      background: #f5f3ff;
      border: 2px solid #8b5cf6;
      border-radius: 10px;
      padding: 8px 20px;
    }

    .submission-number {
      font-size: 18px;
      font-weight: 900;
      color: #5b21b6;
      letter-spacing: 2px;
      font-family: 'DejaVu Sans Mono', 'Courier New', monospace;
    }

    .ticket-body {
      padding: 14px 24px;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }

    .info-table td {
      padding: 5px 4px;
      vertical-align: top;
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
      font-size: 10px;
      font-weight: 700;
      color: #1e293b;
    }

    .info-value-small {
      font-size: 9px;
      font-weight: 600;
      color: #475569;
    }

    .submission-details {
      background: #f5f3ff;
      border: 1px solid #ddd6fe;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 12px;
    }

    .submission-detail-row {
      font-size: 9px;
      color: #475569;
      padding: 3px 0;
    }

    .submission-detail-row strong {
      color: #1e293b;
    }

    .timestamp-box {
      background: #ecfdf5;
      border: 2px solid #10b981;
      border-radius: 8px;
      padding: 10px 14px;
      margin-bottom: 12px;
      text-align: center;
    }

    .timestamp-title {
      font-size: 8px;
      font-weight: 900;
      color: #065f46;
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .timestamp-value {
      font-size: 12px;
      font-weight: 900;
      color: #047857;
    }

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
  @php
    $kategoriLabels = [
      'original_article' => 'Original Article',
      'case_report' => 'Case Report',
      'review' => 'Review',
    ];
  @endphp
  <div class="ticket-page">
    <!-- Header -->
    <div class="ticket-header">
      <p class="header-subtitle">Dies Natalis FKG UGM ke-78</p>
      <h1 class="header-title">BUKTI SUBMISSION - 3-MINUTE PITCH COMPETITION</h1>
      <p class="header-date">Annual Symposium 2026</p>
    </div>

    <!-- Submission Number Badge -->
    <div class="submission-badge">
      <div class="submission-badge-inner">
        <p class="submission-number">{{ $submission->submission_number }}</p>
      </div>
    </div>

    <!-- Body -->
    <div class="ticket-body">
      <!-- Details -->
      <table class="info-table">
        <tr>
          <td style="width: 100%;" colspan="2">
            <p class="info-label">Author(s)</p>
            <p class="info-value">{{ $submission->authors }}</p>
          </td>
        </tr>
        <tr>
          <td style="width: 50%;">
            <p class="info-label">Lembaga / Institusi</p>
            <p class="info-value">{{ $submission->lembaga }}</p>
          </td>
          <td style="width: 50%;">
            <p class="info-label">Kategori</p>
            <p class="info-value">{{ $kategoriLabels[$submission->kategori] ?? $submission->kategori ?? '-' }}</p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <p class="info-label">Judul</p>
            <p class="info-value">{{ $submission->judul }}</p>
          </td>
        </tr>
      </table>

      <!-- Submission Details -->
      <div class="submission-details">
        <div class="submission-detail-row"><strong>Link Abstrak:</strong> {{ $submission->abstract_link }}</div>
        @if($submission->video_link)
        <div class="submission-detail-row"><strong>Link Video:</strong> {{ $submission->video_link }}</div>
        @endif
      </div>

      <!-- Timestamp -->
      <div class="timestamp-box">
        <p class="timestamp-title">Waktu Submission</p>
        <p class="timestamp-value">
          {{ $submission->created_at->locale('id')->isoFormat('dddd, D MMMM Y') }}
          - {{ $submission->created_at->format('H:i:s') }} WIB
        </p>
      </div>

      <!-- Barcode & QR Code -->
      <div class="codes-section">
        <div class="barcode-container">
          {!! $barcode !!}
        </div>
        <div class="qr-container">
          {!! $qrCode !!}
        </div>
        <p class="qr-hint">Scan QR Code untuk verifikasi submission</p>
      </div>

      <!-- Support -->
      <div class="support-box">
        <p class="support-title">Registrations Support & Helpdesk</p>
        <p class="support-detail"><strong>Carigi Indonesia</strong></p>
        <p class="support-detail">WhatsApp: <strong>085147686127</strong></p>
        <p class="support-detail" style="font-size: 8px; color: #6b7280; margin-top: 3px;">Hubungi kami jika ada kendala atau kesulitan.</p>
      </div>
    </div>

    <!-- Footer -->
    <div class="ticket-footer">
      <p class="footer-line">&copy; 2026 Panitia Dies Natalis FKG UGM ke-78. Dokumen ini sah sebagai bukti submission.</p>
      <p class="footer-line">Harap simpan dokumen ini dengan baik.</p>
    </div>
  </div>
</body>
</html>
