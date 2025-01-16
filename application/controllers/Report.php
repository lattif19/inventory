<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* 
*/
class Report extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata('logged')) {
            redirect('login');
        }

		$this->dbMaster = $this->load->database('default', TRUE);
		$this->dbTrx = $this->load->database('trx', TRUE);
        $this->dbMaximo = $this->load->database('maximo', TRUE);
        $this->dbSo = $this->load->database('trxSo', TRUE);
		$this->load->model('ModelReport');
		$this->load->library('excel');
	}

    function issue_run_report(){
        $data['issuereport'] = $this->dbTrx->query("select trx_wo_detail.item_number, item_balances_monitoring_integrasi.location, trx_wo_detail.binnum, trx_wo_detail.issuedqty as qtyIssue,  item_balances.qty as qtyBalances, item_balances_monitoring_integrasi.qty as qtyBarcode, item_balances_monitoring_integrasi.qtyMaximo, item_balances_monitoring_integrasi.selisih from trx.trx_wo_detail, inventory.item_balances_monitoring_integrasi,inventory.item_balances where trx_wo_detail.item_number = item_balances.item_number and trx_wo_detail.item_number = item_balances_monitoring_integrasi.item_number and trx_wo_detail.item_number in (select item_balances_monitoring_integrasi.item_number from inventory.item_balances_monitoring_integrasi) group by trx_wo_detail.item_number")->result();

        $this->load->view('report/run_issue', $data);
    }

	function run_report(){
		$data['issuereport'] = $this->dbTrx->query("select *, trx_wo_detail.description as description_name_trx, location.name as loc_name, inventory.shipper.name as shipper_name from trx.trx_wo, trx.trx_wo_detail, inventory.location, inventory.shipper where trx_wo.trx_id = trx_wo_detail.trx_id and location.location_id = trx_wo_detail.location_id and shipper.shipper_barcode = trx_wo.shipper_id")->result();

		$this->load->view('report/run_report', $data);

	}

     //    function getdata($date="2017-03-20",$date1="2017-03-21"){
  //    // $date = $this->input->post('date');
  //    //    $date1 = $this->input->post('date1');

  //       $data['query']=$this->dbTrx->query("SELECT * FROM trx_wo, trx_wo_detail WHERE trx_wo.trx_id = trx_wo_detail.trx_id and trx_wo_detail.timestamp>='$date' AND trx_wo_detail.timestamp<='$date1' group by trx_wo.trx_code")->result();

  //       // header('Content-Type', 'application/json');
     //    // echo json_encode($data);
        // // // $data['query'] = $this->ModelReport->getReportIssue();
        // $this->load->view('report/issue', $data);


  //   }

    function ss_receive(){
        $date = $this->input->post('date');
        $date1 = $this->input->post('date1');

        $data['so_day_report']=$this->dbTrx->query("SELECT * FROM trx_po, trx_po_detail WHERE trx_po.trx_id = trx_po_detail.trx_id and trx_po_detail.timestamp>='$date' AND trx_po_detail.timestamp<='$date1'")->result();

        $this->load->view('report/so_day_report', $data);
        // var_dump($data);
    }

    function getdata_receive(){
    	$date = $this->input->post('date');
        $date1 = $this->input->post('date1');

        $data['query']=$this->dbTrx->query("SELECT * FROM trx_po, trx_po_detail WHERE trx_po.trx_id = trx_po_detail.trx_id and trx_po_detail.timestamp>='$date' AND trx_po_detail.timestamp<='$date1' group by trx_po.trx_code")->result();

        // header('Content-Type', 'application/json');
	    echo json_encode($data);
		// $this->load->view('report/issue', $data);


    }

	function receiving()
	{
		$data['content'] = 'report/r_receiving';
		$data['judul'] = 'Report';
		$data['sub_judul'] = 'Receiving';
		$data['class'] = 'report';
		$data['class'] = 'Report Receiving';
        $data['query']      = $this->ModelReport->getReportReceiving();
        $data['data']      = $this->dbMaster->query("select * from location");
		$this->load->view('v_home', $data);
	}

	function reportreceiving($trx_id)
	{
        $objPHPExcel = new PHPExcel();

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

		//border
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				), 
			);

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $styleColor = array( 'fill' => 
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f2ac05')
            )
        );

        $maxWidth = 200;
        $maxHeight = 100;
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
        $objDrawing->setPath($logo);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setwidth(100); // logo height
        $objDrawing->setHeight($maxHeight);
        // This is the "magic" formula
        $offsetX =$maxWidth - $objDrawing->getWidth();
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); 

		//$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($styleArray);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('User');

        $this->excel->getActiveSheet()->getStyle("A6:M7")->applyFromArray($style);
        $this->excel->getActiveSheet()->getStyle("A6:M7")->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle("A6:M6")->applyFromArray($styleColor);
       // $this->excel->getActiveSheet()->setName('User');
		//$this->excel->getActiveSheet()->setPath($logo);  //setOffsetY has no effect
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('C1', 'PT Sumber Segara Primadaya');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Jl. Lingkar Timur Karang Kandri');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Kecamatan Kesugihan - Cilacap - Indonesia');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Tel. 62.282. 538 863 Fax. 62.282. 538 863');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Receiving (PO)');
        $this->excel->getActiveSheet()->setCellValue('A6', 'ID');
        $this->excel->getActiveSheet()->setCellValue('B6', 'Transaction Number');
        $this->excel->getActiveSheet()->setCellValue('C6', 'Month');
        $this->excel->getActiveSheet()->setCellValue('D6', 'Year');
        $this->excel->getActiveSheet()->setCellValue('E6', 'Shipper');
        $this->excel->getActiveSheet()->setCellValue('F6', 'Issue Type');
        $this->excel->getActiveSheet()->setCellValue('G6', 'Status');
        $this->excel->getActiveSheet()->setCellValue('H6', 'Date');
        $this->excel->getActiveSheet()->setCellValue('I6', 'Name');
        $this->excel->getActiveSheet()->setCellValue('J6', 'IP Address');
        $this->excel->getActiveSheet()->setCellValue('K6', 'Note');
        $this->excel->getActiveSheet()->setCellValue('L6', 'PO Number');
        $this->excel->getActiveSheet()->setCellValue('M6', 'Company ID');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A5:M5');
        $this->excel->getActiveSheet()->mergeCells('A1:A4');
        $this->excel->getActiveSheet()->getColumnDimensionByColumn('A')->setWidth('20');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('M'); $col++){ //set column dimension 
       	$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
        //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
        //$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
            //retrive contries table data
            $rs = $this->dbTrx->query("select * from trx_po where trx_id ='$trx_id'");
            $exceldata="";
       		foreach ($rs->result_array() as $row){
            $exceldata[] = $row;

        }
            //Fill data
            $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A7');
            $this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
            //$this->excel->getActiveSheet()->getColumnDimension('A4')->setAutoSize(true);  
            $filename="receiving(PO)_".date('Y-m-d H-i-s').".xls"; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
	}

    function ss(){
        $date = $this->input->post('date');
        $date1 = $this->input->post('date1');

        $data['so_day_report']=$this->dbTrx->query("SELECT * FROM trx_wo, trx_wo_detail WHERE trx_wo.trx_id = trx_wo_detail.trx_id and trx_wo_detail.timestamp>='$date' AND trx_wo_detail.timestamp<='$date1'")->result();

        $this->load->view('report/so_day_report', $data);
        // var_dump($data);
    }

    function getdata(){
        $date = $this->input->post('date');
        $date1 = $this->input->post('date1');

        $data['query']=$this->dbTrx->query("SELECT * FROM trx_wo, trx_wo_detail WHERE trx_wo.trx_id = trx_wo_detail.trx_id and trx_wo_detail.timestamp>='$date' AND trx_wo_detail.timestamp<='$date1' group by trx_wo.trx_code")->result();

        // header('Content-Type', 'application/json');
        echo json_encode($data);
        // $this->load->view('report/issue', $data);

    }

	function issue()
	{
		$data['content'] = 'report/r_issue';
		$data['judul'] = 'Report';
		$data['sub_judul'] = 'Issue';
		$data['class'] = 'report';
		$data['class'] = 'Report Issue';
		$data['query'] = $this->ModelReport->getReportIssue();
		$this->load->view('v_home', $data);
	}

    function detail_report_issue($trx_id)
    {
        $data['content'] = 'report/r_detail_issue';
        $data['judul'] = 'Report';
        $data['sub_judul'] = 'Issue';
        $data['class'] = 'report';
        $data['class'] = 'Report Issue';
        $dataItem = $this->ModelReport->getDetailReportIssue($trx_id);
        $data['query'] = $this->addArrayItemDetailMaximoToArrayItem($dataItem);


        $dataDetailItem = $this->ModelReport->getDetailReportIssue($trx_id);
        foreach ($dataDetailItem as $key => $value) {
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['trx_code'] = $value->trx_code;
            $data['name'] = $value->name;
            $data['shipper_barcode'] = $value->shipper_barcode;
        }

        // var_dump($data['query']);
        $this->load->view('report/r_detail_issue', $data);
    }

	function reportissue($trx_id)
	{
        $objPHPExcel = new PHPExcel();        

		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

		//border
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array('argb' => '00000000')
                    ), 
                ), 
            );

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );

        $styleColor = array( 'fill' => 
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f2ac05')
                )
            );


        $maxWidth = 120;
        $maxHeight = 100;
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
        $objDrawing->setPath($logo);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setwidth(80); // logo height
        $objDrawing->setHeight($maxHeight);
        // This is the "magic" formula
        $offsetX =$maxWidth - $objDrawing->getWidth();
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); 


		//$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($styleArray);
        //name the worksheet
        $this->excel->getActiveSheet()->getStyle("A6:M7")->applyFromArray($style);
        $this->excel->getActiveSheet()->getStyle("A6:M7")->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle("A6:M6")->applyFromArray($styleColor);
       // $this->excel->getActiveSheet()->setName('User');
        //$this->excel->getActiveSheet()->setPath($logo);  //setOffsetY has no effect
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('C1', 'PT Sumber Segara Primadaya');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Jl. Lingkar Timur Karang Kandri');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Kecamatan Kesugihan - Cilacap - Indonesia');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Tel. 62.282. 538 863 Fax. 62.282. 538 863');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Issue (WO)');
        $this->excel->getActiveSheet()->setCellValue('A6', 'ID');
        $this->excel->getActiveSheet()->setCellValue('B6', 'Transaction Number');
        $this->excel->getActiveSheet()->setCellValue('C6', 'Month');
        $this->excel->getActiveSheet()->setCellValue('D6', 'Year');
        $this->excel->getActiveSheet()->setCellValue('E6', 'Shipper');
        $this->excel->getActiveSheet()->setCellValue('F6', 'Issue Type');
        $this->excel->getActiveSheet()->setCellValue('G6', 'Status');
        $this->excel->getActiveSheet()->setCellValue('H6', 'Date');
        $this->excel->getActiveSheet()->setCellValue('I6', 'Name');
        $this->excel->getActiveSheet()->setCellValue('J6', 'IP Address');
        $this->excel->getActiveSheet()->setCellValue('K6', 'Note');
        $this->excel->getActiveSheet()->setCellValue('L6', 'WO Number');
        $this->excel->getActiveSheet()->setCellValue('M6', 'Issue To');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A5:M5');
        $this->excel->getActiveSheet()->mergeCells('A1:A4');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('#333');
        for($col = ord('A'); $col <= ord('M'); $col++){ //set column dimension 
        $this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
        //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
        //$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
            //retrive contries table data
            $rs = $this->dbTrx->query("select * from trx_wo where trx_id ='$trx_id'");
            $exceldata="";
       		foreach ($rs->result_array() as $row){
            $exceldata[] = $row;

        }
            //Fill data
            $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A7');
            $this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
            //$this->excel->getActiveSheet()->getColumnDimension('A4')->setAutoSize(true);  
            $filename="Issue(WO)_".date('Y-m-d H-i-s').".xls"; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
	}

	function vendor()
	{
		$data['content']	= 'report/r_vendor';
		$data['judul'] 		= 'Report';
		$data['sub_judul'] 	= 'Vendor';
		$data['class'] 		= 'report';
		$data['class'] 		= 'Report Return To Vendor';
		$data['reportVendor'] = $this->ModelReport->getReportVendor();
		$this->load->view('v_home', $data);
	}

	function reportvendor($trx_id)
	{

        $objPHPExcel = new PHPExcel();

        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

        //border
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
                    ), 
                ), 
            );

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $styleColor = array( 'fill' => 
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f2ac05')
            )
        );

        $maxWidth = 120;
        $maxHeight = 100;
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
        $objDrawing->setPath($logo);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setwidth(120); // logo height
        $objDrawing->setHeight($maxHeight);
        // This is the "magic" formula
        $offsetX =$maxWidth - $objDrawing->getWidth();
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); 

        //$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($styleArray);
        //name the worksheet
        $this->excel->getActiveSheet()->getStyle("A6:L7")->applyFromArray($style);
        $this->excel->getActiveSheet()->getStyle("A6:L7")->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle("A6:L6")->applyFromArray($styleColor);
        $this->excel->getActiveSheet()->setTitle('User');
       // $this->excel->getActiveSheet()->setName('User');
		$logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
		//$this->excel->getActiveSheet()->fromArray($logo);  //setOffsetY has no effect
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('C1', 'PT Sumber Segara Primadaya');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Jl. Lingkar Timur Karang Kandri');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Kecamatan Kesugihan - Cilacap - Indonesia');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Tel. 62.282. 538 863 Fax. 62.282. 538 863');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Return To Vendor (PO)');
        $this->excel->getActiveSheet()->setCellValue('A6', 'ID');
        $this->excel->getActiveSheet()->setCellValue('B6', 'Transaction Number');
        $this->excel->getActiveSheet()->setCellValue('C6', 'Month');
        $this->excel->getActiveSheet()->setCellValue('D6', 'Year');
        $this->excel->getActiveSheet()->setCellValue('E6', 'Shipper');
        $this->excel->getActiveSheet()->setCellValue('F6', 'Issue Type');
        $this->excel->getActiveSheet()->setCellValue('G6', 'Status');
        $this->excel->getActiveSheet()->setCellValue('H6', 'Date');
        $this->excel->getActiveSheet()->setCellValue('I6', 'Name');
        $this->excel->getActiveSheet()->setCellValue('J6', 'IP Address');
        $this->excel->getActiveSheet()->setCellValue('K6', 'Note');
        $this->excel->getActiveSheet()->setCellValue('L6', 'PO Number');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A5:L5');
        $this->excel->getActiveSheet()->mergeCells('A1:A4');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A5:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('L'); $col++){ //set column dimension 
       	$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
        //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
        //$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
            //retrive contries table data
            $rs = $this->dbTrx->query("select * from trx_po_return where trx_id ='$trx_id'");
            $exceldata="";
       		foreach ($rs->result_array() as $row){
            $exceldata[] = $row;

        	}
            //Fill data
            $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A7');
            $this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
            //$this->excel->getActiveSheet()->getColumnDimension('A4')->setAutoSize(true);  
            $filename="Return To Vendor(PO)_".date('Y-m-d H-i-s').".xls"; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
	}

	function warehouse()
	{
		$data['content'] = 'report/r_warehouse';
		$data['judul'] = 'Report';
		$data['sub_judul'] = 'Warehouse';
		$data['class'] = 'report';
		$data['class'] = 'Report Return To Warehouse';
		$data['reportWarehouse'] = $this->ModelReport->getReportWarehouse();
		$this->load->view('v_home', $data);
	}

	function reportwarehouse($trx_id)
	{
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);

        //border
        $styleArray = array( 'borders' => 
            array( 'allborders' => 
                array( 
                    'style' => PHPExcel_Style_Border::BORDER_THIN, 
                    'color' => array('argb' => '00000000')
                    ), 
                ), 
            );

        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );

        $styleColor = array( 'fill' => 
            array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'f2ac05')
                )
            );
        
        $maxWidth = 120;
        $maxHeight = 100;
        
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('Logo');
        $objDrawing->setDescription('Logo');
        $logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
        $objDrawing->setPath($logo);  //setOffsetY has no effect
        $objDrawing->setCoordinates('A1');
        $objDrawing->setwidth(120); // logo height
        $objDrawing->setHeight($maxHeight);
        // This is the "magic" formula
        $offsetX =$maxWidth - $objDrawing->getWidth();
        $objDrawing->setOffsetX($offsetX);
        $objDrawing->setWorksheet($this->excel->getActiveSheet()); 

        //$this->excel->getActiveSheet()->getStyle(chr($col))->applyFromArray($styleArray);
        //name the worksheet
        $this->excel->getActiveSheet()->getStyle("A6:N7")->applyFromArray($style);
        $this->excel->getActiveSheet()->getStyle("A6:N7")->applyFromArray($styleArray);
        $this->excel->getActiveSheet()->getStyle("A6:N6")->applyFromArray($styleColor);
        $this->excel->getActiveSheet()->setTitle('User');
       // $this->excel->getActiveSheet()->setName('User');
        $logo = 'assets/dist/img/logo.png'; // Provide path to your logo file
        //$this->excel->getActiveSheet()->fromArray($logo);  //setOffsetY has no effect
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('C1', 'PT Sumber Segara Primadaya');
        $this->excel->getActiveSheet()->setCellValue('C2', 'Jl. Lingkar Timur Karang Kandri');
        $this->excel->getActiveSheet()->setCellValue('C3', 'Kecamatan Kesugihan - Cilacap - Indonesia');
        $this->excel->getActiveSheet()->setCellValue('C4', 'Tel. 62.282. 538 863 Fax. 62.282. 538 863');
        $this->excel->getActiveSheet()->setCellValue('A5', 'Return To Warehouse (WO)');
        $this->excel->getActiveSheet()->setCellValue('A6', 'ID');
        $this->excel->getActiveSheet()->setCellValue('B6', 'Transaction Number');
        $this->excel->getActiveSheet()->setCellValue('C6', 'Month');
        $this->excel->getActiveSheet()->setCellValue('D6', 'Year');
        $this->excel->getActiveSheet()->setCellValue('E6', 'Shipper');
        $this->excel->getActiveSheet()->setCellValue('F6', 'Issue Type');
        $this->excel->getActiveSheet()->setCellValue('G6', 'Status');
        $this->excel->getActiveSheet()->setCellValue('H6', 'Date');
        $this->excel->getActiveSheet()->setCellValue('I6', 'Name');
        $this->excel->getActiveSheet()->setCellValue('J6', 'IP Address');
        $this->excel->getActiveSheet()->setCellValue('K6', 'Note');
        $this->excel->getActiveSheet()->setCellValue('L6', 'WO Number');
        $this->excel->getActiveSheet()->setCellValue('M6', 'Issue');
        $this->excel->getActiveSheet()->setCellValue('N6', 'Trx Reff Code');
        //merge cell A1 until C1
        $this->excel->getActiveSheet()->mergeCells('A5:N5');
        //set aligment to center for that merged cell (A1 to C1)
        $this->excel->getActiveSheet()->getStyle('A5:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A5')->getFont()->setSize(18);
        $this->excel->getActiveSheet()->getStyle('A5')->getFill()->getStartColor()->setARGB('#333');
       	for($col = ord('A'); $col <= ord('N'); $col++){ //set column dimension 
       	$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
        //change the font size
        $this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
        $this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
            //retrive contries table data
            $rs = $this->dbTrx->query("select * from trx_wo_return where trx_id ='$trx_id'");
            $exceldata="";
       		foreach ($rs->result_array() as $row){
            $exceldata[] = $row;

        	}
            //Fill data
            $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A7');
            $this->excel->getActiveSheet()->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('F7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('G7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('J7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                
            //$this->excel->getActiveSheet()->getColumnDimension('A4')->setAutoSize(true);  
            $filename="Return To Warehouse(WO)_".date('Y-m-d H-i-s').".xls"; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name

            header('Cache-Control: max-age=0'); //no cache

            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5'); 
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
	}

	function stockopname()
	{
		$data['content'] = 'report/r_stockopname';
		$data['judul'] = 'Report';
		$data['sub_judul'] = 'Stock Opname';
		$data['class'] = 'report';
		$data['class'] = 'Report Stockopname';
		$data['reportStockopname'] = $this->ModelReport->getReportStockopname();
		$this->load->view('v_home', $data);
	}

    function reportstockopname($trx_id)
    {
        $data['title'] = "Stock Opname-".date('d-m-y');
        $data['query'] = $this->dbSo->query("select * from trx_so, trx_so_detail where trx_so.trx_so_id = trx_so_detail.trx_so_id and trx_so.trx_so_id = '$trx_id'");
        foreach ($data['query']->result() as $key => $value) {
            $data['trx_so_code'] = $value->trx_so_code;
            $data['trx_so_date'] = $value->trx_so_date;
        }
        $this->load->view('report/vr_stockopname', $data, FALSE);
    }

	function compare_stockopname()
	{
		$data['content'] = 'report/r_compare';
		$data['judul'] = 'Report';
		$data['sub_judul'] = 'Compare';
		$data['class'] = 'report';
		$data['class'] = 'compare';
		$reportCompare = $this->dbSo->query("select * from so_detail_summary, so where so.id_so = so_detail_summary.id_so")->result();
        $data['reportCompare'] = $this->addArrayItemDetailMaximoToArrayItem($reportCompare);
		$this->load->view('v_home', $data);
	}

    function adjustment()
    {
        $data['content']      = 'report/r_adjustment';
        $data['judul']        = 'Report';
        $data['sub_judul']    = 'Adjustment';
        $data['class']        = 'report';
        $data['class']        = 'adjustment_r';
        $data['reportAdj']    = $this->dbTrx->query("select * from trx.trx_adjustment, inventory.location where location.location_id = trx.trx_adjustment.location_id")->result();
        $this->load->view('v_home', $data);
    }

    function borrow_tools()
    {
        $data['content']    = 'report/r_borrow_tools';
        $data['judul']      = 'Report';
        $data['sub_judul']  = 'Borrow';
        $data['class']      = 'report';
        $data['class']      = 'borrow_r';
        $this->load->view('v_home', $data);
    }

    function borrow_items()
    {
        $data['content']    = 'report/r_borrow_items';
        $data['judul']      = 'Report';
        $data['sub_judul']  = 'Borrow';
        $data['class']      = 'report';
        $data['class']      = 'borrow_r';
        $this->load->view('v_home', $data);
    }

    function borrow_services()
    {
        $data['content']    = 'report/r_borrow_services';
        $data['judul']      = 'Report';
        $data['sub_judul']  = 'Borrow';
        $data['class']      = 'report';
        $data['class']      = 'borrow_r';
        $this->load->view('v_home', $data);
    }

    function detail_report_receive($trx_id) {
        $data = $this->dbTrx->query("select * from trx.trx_po, inventory.shipper where shipper.shipper_barcode = trx_po.shipper_id")->result();
        foreach ($data as $key => $value) {
            // $data['filename'] = "Report Receiving -".$value->trx_timestamp;
            $data['trx_code'] = $value->trx_code;
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['name'] = $value->name;
            $data['shipper_barcode'] = $value->shipper_barcode;
        }
        // $data['title'] = "Report Receiving -".$data;
        $item = $this->dbTrx->query("select * from trx_po as a, trx_po_detail as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
        $data['dataItem'] =$this->addArrayItemDetailMaximoToArrayItem($item); 
     
        // var_dump($data['dataItem']);
        // var_dump($data);

       
        $this->load->view('receiving/report_receiving', $data);
    }

    function detail_report_vendor($trx_id) {
        $data = $this->dbTrx->query("select * from trx.trx_po_return, inventory.shipper where shipper.shipper_barcode = trx_po_return.shipper_id")->result();
        foreach ($data as $key => $value) {
            // $data['filename'] = "Report Receiving -".$value->trx_timestamp;
            $data['trx_code'] = $value->trx_code;
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['name'] = $value->name;
            $data['shipper_barcode'] = $value->shipper_barcode;
        }
        // $data['title'] = "Report Receiving -".$data;
        $item = $this->dbTrx->query("select * from trx_po_return as a, trx_po_detail_return as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
        $data['dataItem'] =$this->addArrayItemDetailMaximoToArrayItem($item); 
       
        $this->load->view('report/report_vendor', $data);
    }

    function detail_report_warehouse($trx_id) {
        $data = $this->dbTrx->query("select * from trx.trx_wo_return, inventory.shipper where shipper.shipper_barcode = trx_po.shipper_id")->result();
        foreach ($data as $key => $value) {
            // $data['filename'] = "Report Receiving -".$value->trx_timestamp;
            $data['trx_code'] = $value->trx_code;
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['name'] = $value->name;
            $data['shipper_barcode'] = $value->shipper_barcode;
        }
        // $data['title'] = "Report Receiving -".$data;
        $item = $this->dbTrx->query("select * from trx_wo_return as a, trx_wo_detail_return as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
        $data['dataItem'] =$this->addArrayItemDetailMaximoToArrayItem($item); 
            
        $this->load->view('report/report_warehouse', $data);
    }

    function detail_report_adjustment($trx_id) {
        $data = $this->dbTrx->query("select * from trx.trx_adjustment, inventory.location where location.location_id = trx_adjustment.location_id")->result();
        foreach ($data as $key => $value) {
            $data['trx_code'] = $value->trx_code;
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['name'] = $value->name;
        }
        $item = $this->dbTrx->query("select * from trx_adjustment as a, trx_adjustment_detail as b where a.trx_id = b.trx_id and a.trx_id='$trx_id'")->result();
        $data['dataItem'] =$this->addArrayItemDetailMaximoToArrayItem($item); 

       
        $this->load->view('report/r_detail_adjustment', $data);
    }

    function print_issue($trx_id){
        $dataIssue = $this->dbTrx->query("select * from trx_wo, trx_wo_detail where trx_wo.trx_id=trx_wo_detail.trx_id and trx_wo.trx_id='$trx_id'");
        foreach ($dataIssue->result() as $key => $value) {
            $data['wonum'] = $value->wonum;
            $data['trx_timestamp'] = $value->trx_timestamp;
            $data['trx_code'] =$value->trx_code;
        }

        $detailIssuePrint = $this->dbTrx->query("select * from inventory.shipper, trx.trx_wo where shipper.shipper_barcode = trx_wo.shipper_id and trx_wo.trx_id = '$trx_id'")->result();

        foreach ($detailIssuePrint as $key => $value) {
            $data['name_shipper'] =$value->name;
            $data['issuer'] =$value->enterby;
        }

        $dataItem = $this->dbTrx->query("select * from trx_wo_detail where trx_id = '$trx_id'")->result();
        $data['issue']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
        $this->load->view('issue/print_issue', $data);
        // $html=$this->load->view('issue/print_issue_pdf', $data, true);
        // $pdfFilePath= "asda.pdf";
        // $this->load->library('M_pdf');
        // $style=file_get_contents(base_url().'/assets/print-style.css');
        // $pdf = $this->m_pdf->load();
        // $pdf->AddPage('P',
        // 0, // margin_left
        // 0, // margin right
        // 60, // margin top
        // 30); // margin footer
        // $script = "window.print();";
        // $pdf->SetJS($script);
        // $pdf->WriteHTML($style,1);
        // $pdf->WriteHTML($html,2);
        // $pdf->Output();
        // $pdf->Output($pdfFilePath, 'F'); // save to file because we can


        
    }


    function curdate($trx_id){
        $query = $this->dbTrx->query("select CURDATE(), CURTIME() from trx_wo where trx_wo.trx_id = '$trx_id'")->result();
        echo $query[0]->trx_timestamp;
    }

    function print_receiving($trx_id){
        $dataIssue = $this->dbTrx->query("select * from trx_po");
        foreach ($dataIssue->result() as $key => $value) {
            $data['ponum'] = $value->ponum;
            $data['trx_timestamp'] =$value->trx_timestamp;
            $data['trx_code'] =$value->trx_code;
        }

        $detailIssuePrint = $this->dbTrx->query("select * from inventory.shipper, trx.trx_po where shipper.shipper_barcode = trx_po.shipper_id and trx_po.trx_id = '$trx_id'")->result();

        foreach ($detailIssuePrint as $key => $value) {
            $data['name_shipper'] =$value->name;
            $data['company_id']   =$this->getDataCompanyFromMaximo($value->company_id)->COMPANY;
        }

        // $dataItem = $this->dbTrx->query("select * from trx_po, trx_po_detail where trx_po.trx_id = trx_po_detail.trx_id and trx_po.trx_id = '$trx_id' and DATE(trx_po_detail.trx_timestamp) = CURDATE()")->result();
        $data['dataItem'] =  $this->dbTrx->query("select * from trx_po_detail where trx_id = '$trx_id'")->result();
        // $dataItem = $this->dbTrx->query("select * from trx_po_detail where trx_id = '$trx_id'")->result();
        // $data['issue']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
       
        $this->load->view('receiving/print_receiving', $data);
    }

    function print_rtrn_vendor($trx_id){
        $dataIssue = $this->dbTrx->query("select * from trx_po_return");
        foreach ($dataIssue->result() as $key => $value) {
            $data['ponum'] = $value->ponum;
            $data['trx_timestamp'] =$value->trx_timestamp;
            $data['trx_code'] =$value->trx_code;
        }

        $detailIssuePrint = $this->dbTrx->query("select * from inventory.shipper, trx.trx_po_return where shipper.shipper_barcode = trx_po_return.shipper_id and trx_po_return.trx_id = '$trx_id'")->result();

        foreach ($detailIssuePrint as $key => $value) {
            $data['name_shipper'] =$value->name;
            $data['company_id']   =$this->getDataCompanyFromMaximo($value->company_id)->COMPANY;
        }

        // $dataItem = $this->dbTrx->query("select * from trx_po, trx_po_detail where trx_po.trx_id = trx_po_detail.trx_id and trx_po.trx_id = '$trx_id' and DATE(trx_po_detail.trx_timestamp) = CURDATE()")->result();
        // $data['dataItem'] =  $this->dbTrx->query("select * from trx_po_detail_return where trx_id = '$trx_id'")->result();
        $dataItem = $this->dbTrx->query("select * from trx_po_detail_return where trx_id = '$trx_id'")->result();
        $data['dataItem']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
        $this->load->view('rtrn_vendor/print_rtrn_vendor', $data);
    }

    function print_rtrn_warehouse($trx_id){
        $dataIssue = $this->dbTrx->query("select * from trx_wo_return");
        foreach ($dataIssue->result() as $key => $value) {
            $data['wonum'] = $value->wonum;
            $data['trx_timestamp'] =$value->trx_timestamp;
            $data['trx_code'] =$value->trx_code;
        }

        $detailIssuePrint = $this->dbTrx->query("select * from inventory.shipper, trx.trx_wo_return where shipper.shipper_barcode = trx_wo_return.shipper_id and trx_wo_return.trx_id = '$trx_id'")->result();

        foreach ($detailIssuePrint as $key => $value) {
            $data['name_shipper'] =$value->name;
            $data['company_id']   =$this->getDataCompanyFromMaximo($value->company_id)->COMPANY;
        }

        // $dataItem = $this->dbTrx->query("select * from trx_po, trx_po_detail where trx_po.trx_id = trx_po_detail.trx_id and trx_po.trx_id = '$trx_id' and DATE(trx_po_detail.trx_timestamp) = CURDATE()")->result();
        // $data['dataItem'] =  $this->dbTrx->query("select * from trx_wo_detail_return where trx_id = '$trx_id'")->result();
        $dataItem = $this->dbTrx->query("select * from trx_wo_detail_return where trx_id = '$trx_id'")->result();
        $data['issue']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
       
        $this->load->view('rtrn_warehouse/print_rtrn_warehouse', $data);
    }


    function receiving_non_po($trx_id){
        $dataIssue = $this->dbTrx->query("select * from trx_po");
        foreach ($dataIssue->result() as $key => $value) {
            $data['ponum'] = $value->ponum;
            $data['trx_timestamp'] =$value->trx_timestamp;
            $data['trx_code'] =$value->trx_code;
            $data['enterby'] =$value->enterby;
        }

        $detailIssuePrint = $this->dbTrx->query("select * from inventory.shipper, trx.trx_po, trx.trx_po_detail where shipper.shipper_barcode = trx_po.shipper_id and trx_po.trx_id = trx_po_detail.trx_id and trx_po_detail.trx_detail_id = '$trx_id'")->result();

        foreach ($detailIssuePrint as $key => $value) {
            $data['name'] =$value->name;
            $data['company_id']   =$this->getDataCompanyFromMaximo($value->company_id)->COMPANY;
        }

        // $dataItem = $this->dbTrx->query("select * from trx_po, trx_po_detail where trx_po.trx_id = trx_po_detail.trx_id and trx_po.trx_id = '$trx_id' and DATE(trx_po_detail.trx_timestamp) = CURDATE()")->result();
        $dataItem = $this->dbTrx->query("SELECT * FROM trx_po_detail,trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=1 and trx_po_detail.trx_id='$trx_id'")->result();
        $data['non_po']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
        $this->load->view('receiving_non_po/print_receiving', $data);
    }

    function getDataItemFromMaximo($trx_id)
    {
        $itemDataIssue = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'")->result();
        return $itemDataIssue[0];
    }

    function getDataCompanyFromMaximo($trx_id)
    {
        $companyItem = $this->dbMaximo->query("select * from VIEWCOMPANIES where COMPANY ='$trx_id'")->result();
        return $companyItem[0];
    }

	function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
		$i=0;
		foreach ($dataItemDescription as $key){
			$j=$i++;
            $dataItemDescription[$j]->DESCRIPTION = $this->getDataItemFromMaximo($key->item_number)->DESCRIPTION;
            // $dataItemDescription[$j]->NAME = $this->getDataCompanyFromMaximo($key->company_id)->NAME;
		}
		return $dataItemDescription;
	}


    function abc()
      $dataItem = $this->dbTrx->query("SELECT * FROM trx_po_detail,trx_po where trx_po.trx_id=trx_po_detail.trx_id and trx_po_detail.trx_status!=1 and trx_po_detail.trx_id='1234'")->result();
        $data['non_po']=$this->addArrayItemDetailMaximoToArrayItem($dataItem);
        var_dump($data);
        // $this->load->view('receiving_non_po/print_receiving', $data);
    }

    function getDataItemFromMaximo1($trx_id)
    {
        $itemDataIssue = $this->dbMaximo->query("select * from VIEWITEM where ITEMNUM ='$trx_id'")->result();
        return $itemDataIssue[0];
    }

   
    function addArrayItemDetailMaximoToArrayItem($dataItemDescription){
        $i=0;
        foreach ($dataItemDescription as $key){
            $j=$i++;
            $dataItemDescription[$j]->DESCRIPTION = $this->getDataItemFromMaximo1($key->item_number)->DESCRIPTION;
            // $dataItemDescription[$j]->NAME = $this->getDataCompanyFromMaximo($key->company_id)->NAME;
        }
        return $dataItemDescription;
    }


	
}