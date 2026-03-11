<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Tiket - Dies Natalis FKG UGM ke-78</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #1e293b; -webkit-text-size-adjust: 100%;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9;">
    <tr>
      <td align="center" style="padding: 40px 16px;">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; max-width: 600px; width: 100%;">

          <!-- Header -->
          <tr>
            <td style="background: linear-gradient(135deg, #d97706, #f59e0b); padding: 32px 40px; text-align: center;">
              <p style="margin: 0 0 4px 0; font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: rgba(255,255,255,0.7); font-weight: 700;">Dies Natalis FKG UGM ke-78</p>
              <h1 style="margin: 0; font-size: 24px; font-weight: 900; color: #ffffff;">Konfirmasi Pembayaran</h1>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding: 40px;">
              <!-- Greeting -->
              <p style="margin: 0 0 16px 0; font-size: 16px; color: #1e293b;">
                Halo <strong>{{ $order->nama_lengkap }}</strong>,
              </p>
              <p style="margin: 0 0 24px 0; font-size: 14px; color: #64748b; line-height: 1.6;">
                Pembayaran Anda untuk pesanan <strong style="color: #1e293b;">{{ $order->order_number }}</strong> telah kami terima dan dikonfirmasi. Berikut adalah ringkasan pesanan Anda:
              </p>

              <!-- Order Summary -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f8fafc; border-radius: 12px; margin-bottom: 24px;">
                <tr>
                  <td style="padding: 24px;">
                    <p style="margin: 0 0 12px 0; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #94a3b8;">Ringkasan Pesanan</p>

                    @foreach($order->items as $item)
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr>
                        <td style="padding: 6px 0; font-size: 14px; color: #475569;">{{ $item->event_label }}</td>
                        <td style="padding: 6px 0; font-size: 14px; color: #1e293b; font-weight: 700; text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                      </tr>
                    </table>
                    @endforeach

                    <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 12px 0;">
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tr>
                        <td style="padding: 4px 0; font-size: 14px; font-weight: 900; color: #b45309;">Total</td>
                        <td style="padding: 4px 0; font-size: 14px; font-weight: 900; color: #b45309; text-align: right;">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- Ticket Links -->
              <p style="margin: 0 0 16px 0; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #94a3b8;">Tiket Anda</p>

              @foreach($ticketLinks as $link)
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom: 8px;">
                <tr>
                  <td style="background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 16px;">
                    <p style="margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #1e293b;">{{ $link['label'] }}</p>
                    <p style="margin: 0 0 8px 0; font-size: 12px; color: #94a3b8; font-family: 'Courier New', monospace;">{{ $link['code'] }}</p>
                    <a href="{{ $link['url'] }}" style="display: inline-block; background-color: #f59e0b; color: #ffffff; padding: 8px 20px; border-radius: 8px; font-size: 13px; font-weight: 700; text-decoration: none;">
                      Lihat Tiket
                    </a>
                  </td>
                </tr>
              </table>
              @endforeach

              <!-- Info -->
              <p style="margin: 32px 0 0 0; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                Harap simpan tiket ini dengan baik. Tunjukkan QR Code tiket saat registrasi ulang di lokasi acara.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background-color: #f8fafc; padding: 24px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
              <p style="margin: 0 0 4px 0; font-size: 12px; font-weight: 700; color: #64748b;">Dies Natalis FKG UGM ke-78</p>
              <p style="margin: 0 0 4px 0; font-size: 11px; color: #94a3b8;">Jl. Denta No.1, Sekip Utara, Yogyakarta</p>
              <p style="margin: 0 0 12px 0; font-size: 11px; color: #94a3b8;">info@diesfkgugm.id | (0274) 515307</p>
              <p style="margin: 0; font-size: 10px; color: #cbd5e1;">Email ini dikirim otomatis. Mohon tidak membalas email ini.</p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>
