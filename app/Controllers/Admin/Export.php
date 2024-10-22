<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use TCPDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Export extends AuthController
{
    public function export_pdf()
    {
        $sales_order = "SELECT * FROM sales_order";
        $sales_order = $this->db->query($sales_order)->getResultArray();
    
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);
        $pdf->AddPage('L');
    
        $html = '<h2 style="text-align: center;">REPORT:</h2>
                 <table border="1" cellpadding="5" cellspacing="0" style="width: 100%;">';
        $html .= '<tr style="text-align: center; font-weight: bold; background-color: #f2f2f2;">
                    <th colspan="2" width="10%">Status</th>
                    <th colspan="2" width="15%">Reason</th>
                    <th width="10%">Customer Name</th>
                    <th width="20%">Address</th>
                    <th width="10%">No Handphone</th>
                    <th width="10%">Price</th>
                    <th width="15%">Proof</th>
                    <th colspan="2" width="10%">Date</th>
                  </tr>';
    
        foreach ($sales_order as $key => $value) {
            $date = $value['sales_order_date'];
            $date = date('d/m/Y', strtotime($date));
            
            $html .= '<tr>
                        <td style="text-align: center;" colspan="2">' . $value['sales_order_status'] . '</td>
                        <td style="text-align: center;" colspan="2">' . $value['sales_order_reason'] . '</td>
                        <td style="text-align: center;">' . $value['sales_order_customer_name'] . '</td>
                        <td style="text-align: center;">' . $value['sales_order_customer_address'] . '</td>
                        <td style="text-align: right;">' . $value['sales_order_customer_no_handphone'] . '</td>
                        <td style="text-align: right;">' . number_format($value['sales_order_price'], 2) . '</td>
                        <td style="text-align: right;">' . $value['sales_order_proof'] . '</td>
                        <td style="text-align: center;" colspan="2">' . $date . '</td>
                      </tr>';
        }
    
        $html .= '</table>';
        $pdf->writeHTML($html);
    
        $this->response->setContentType('application/pdf');
        $pdf->Output('sales-order.pdf', 'I');
    }
    

    public function export_excel()
    {
        $sales_order = "SELECT * FROM sales_order";
        $sales_order = $this->db->query($sales_order)->getResultArray();
    
        $fileName = 'sales_order.xlsx';
    
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $count = count($sales_order) + 1;
    
        // Set header Excel
        $sheet->setCellValue('A1', 'Status');
        $sheet->setCellValue('B1', 'Reason');
        $sheet->setCellValue('C1', 'Cust Name');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'No Handphone');
        $sheet->setCellValue('F1', 'Price');
        $sheet->setCellValue('G1', 'Proof');
        $sheet->setCellValue('H1', 'Date');
    
        // Set gaya untuk header (font size, bold, dan background color)
        $fontStyle = [
            'font' => ['size' => 15, 'bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'f2f2f2']
            ],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($fontStyle);
    
        // Warna berdasarkan status
        $statusColors = [
            'confirmed' => '41f518', // hijau
            'canceled' => 'd1160d',  // merah
            'customer_canceled' => 'd5f505',  // kuning
        ];
    
        // Isi data ke dalam tabel
        $i = 2;
        foreach ($sales_order as $value) {
            $date = date("d/m/Y", strtotime($value['sales_order_date']));
            $price = number_format($value['sales_order_price'], 2, ',', '.');
    
            // Isi data ke cell
            $sheet->setCellValue('A' . $i, $value['sales_order_status']);
            $sheet->setCellValue('B' . $i, $value['sales_order_reason']);
            $sheet->setCellValue('C' . $i, $value['sales_order_customer_name']);
            $sheet->setCellValue('D' . $i, $value['sales_order_customer_address']);
            $sheet->setCellValue('E' . $i, $value['sales_order_customer_no_handphone']);
            $sheet->setCellValue('F' . $i, 'Rp. ' . $price);
            $sheet->setCellValue('G' . $i, $value['sales_order_proof']);
            $sheet->setCellValue('H' . $i, $date);
    
            // Set warna untuk status
            if (isset($statusColors[$value['sales_order_status']])) {
                $sheet->getStyle('A' . $i)->getFont()->setBold(true);
                $sheet->getStyle('A' . $i)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB($statusColors[$value['sales_order_status']]);
            }
    
            $i++;
        }
    
        // Set border untuk seluruh tabel
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '090a09'],
                ],
            ],
        ];
        $sheet->getStyle('A1:H' . ($count))->applyFromArray($styleArray);
    
        // Set auto size untuk semua kolom
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Atur alignment untuk kolom tertentu
        $alignmentStyle = [
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        ];
        $rightAlignColumns = ['E', 'F', 'G'];
        foreach ($rightAlignColumns as $col) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }
        $sheet->getStyle('A:H')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
        // Header untuk export
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $fileName);
        header('Cache-Control: max-age=0');
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
}