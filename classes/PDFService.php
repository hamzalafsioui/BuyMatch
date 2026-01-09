<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService implements IPDFService
{
    public static function generateTicketsPDF(array $tickets): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        $html = self::buildHtml($tickets);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private static function buildHtml(array $tickets): string
    {
        $html = '<html><head><style>
            body { font-family: Arial, sans-serif; color: #333; }
            .ticket { border: 2px dashed #444; padding: 20px; margin-bottom: 30px; border-radius: 10px; background-color: #f9f9f9; }
            .header { border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; text-align: center; }
            .title { font-size: 24px; font-weight: bold; color: #1a56db; }
            .details { margin-bottom: 20px; }
            .label { font-weight: bold; color: #555; }
            .qr-placeholder { text-align: center; margin-top: 20px; padding: 10px; border: 1px solid #ccc; background: #eee; font-family: monospace; font-size: 18px; letter-spacing: 2px; }
            .footer { font-size: 12px; color: #777; text-align: center; margin-top: 10px; }
        </style></head><body>';

        foreach ($tickets as $ticket) {
            $html .= '<div class="ticket">';
            $html .= '  <div class="header"><div class="title">BuyMatch Ticket</div></div>';
            $html .= '  <div class="details">';
            $html .= '    <p><span class="label">Match:</span> ' . htmlspecialchars($ticket->homeTeamName) . ' vs ' . htmlspecialchars($ticket->awayTeamName) . '</p>';
            $html .= '    <p><span class="label">Date:</span> ' . htmlspecialchars($ticket->matchDatetime) . '</p>';
            $html .= '    <p><span class="label">Category:</span> ' . htmlspecialchars($ticket->categoryName ?? 'N/A') . '</p>';
            $html .= '    <p><span class="label">Price:</span> ' . number_format($ticket->pricePaid, 2) . ' $</p>';
            $html .= '  </div>';
            $html .= '  <div class="qr-placeholder">QR: ' . htmlspecialchars($ticket->qrCode) . '</div>';
            $html .= '  <div class="footer">Thank you for your purchase! Please present this ticket at the entrance.</div>';
            $html .= '</div>';
        }

        $html .= '</body></html>';
        return $html;
    }
}
