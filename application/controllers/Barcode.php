<?php
/**
* 
*/
class Barcode extends CI_Controller
{
    public function index()
    {
        var_dump(extension_loaded('gd'));
    }
    
    private function set_barcodee($code)
    {
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');

        try {
            $barcodeOptions = array('text' => $code);
            $rendererOptions = array(
                                'imageType'          =>'png', 
                                'horizontalPosition' => 'center', 
                                'verticalPosition'   => 'middle'
                                );
            Zend_Barcode::factory('code39', 'image', $barcodeOptions, $rendererOptions)->render();
        } catch (Exception $e) {
            // Log any exceptions
            file_put_contents('error_log.txt', $e->getMessage());
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }

    public function set_barcodee_1($code)
    {
        $this->load->library('Zend');
        $this->zend->load('Zend/Barcode');
        
        $barcodeOptions = [
            'text' => $code,
            'barHeight' => 35, 
            'drawText' => FALSE, 
            'withQuietZones' => FALSE,
            'barWidth' => 100, 
        ];
        $rendererOptions = [];

        // Render barcode dan simpan ke buffer
        $barcodeImage = Zend_Barcode::factory('code128', 'image', $barcodeOptions, $rendererOptions);
        $barcodeImage->render();

        // Ambil output gambar dari buffer
        $imageData = ob_get_contents();

        // Pastikan buffer dibersihkan
        ob_end_clean();

        // Set header HTTP untuk output gambar
        header('Content-Type: image/png');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        
        // Output gambar ke browser
        echo $imageData;

        // Simpan file gambar
        file_put_contents('barcode_' . $code . '.png', $imageData);

        exit; // Keluar untuk mencegah output tambahan
    }
    
    public function get_barcodee($code)
    {
        $this->set_barcodee($code);
    }
}
?>