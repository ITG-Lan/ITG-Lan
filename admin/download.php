<?php
include '../include/database.php'; //Inkludera så att vi kan ansluta till databasen
include '../include/functions.php';
sec_session_start();
if(login_check($db) == true)
{
	/** Include PHPExcel */
	require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set document properties
	$objPHPExcel->getProperties()->setCreator("ITG Lan crew")
								 ->setTitle("ITG-Lan anmalningar");

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'ID')
	            ->setCellValue('B1', 'Namn')
	            ->setCellValue('C1', 'Mail')
	            ->setCellValue('D1', 'Klass')
	            ->setCellValue('E1', 'Klassmeddelande')
	            ->setCellValue('F1', 'Fick reda?');

	$db->query("SET NAMES 'UTF8';");
	if($result  = $db->query("SELECT  * FROM  anmalningar"))
	{
		$row_cnt = $result->num_rows;
		if($row_cnt > 0)
		{
			$startnummer = 2;
			//  Loopa ut  alla  rader i resultatet  i en  associativ array
			while ($row = $result->fetch_row())
			{
				$a = "A".(string)$startnummer;
				$b = "B".(string)$startnummer;
				$c = "C".(string)$startnummer;
				$d = "D".(string)$startnummer;
				$e = "E".(string)$startnummer;
				$f = "F".(string)$startnummer;


				$startnummer++;

				$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue($a, $row[0])
	            ->setCellValue($b, $row[1])
	            ->setCellValue($c, $row[2])
	            ->setCellValue($d, $row[3])
	            ->setCellValue($e, $row[4])
	            ->setCellValue($f, $row[5]);
			}
					// Set active sheet index to the first sheet, so Excel opens this as the first sheet
					$objPHPExcel->setActiveSheetIndex(0);

					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

					// Redirect output to a client’s web browser (Excel5)
					header('Content-Type: application/vnd.ms-excel');
					header('Content-Disposition: attachment;filename="itg-lan anmalningar.xls"');
					header('Cache-Control: max-age=0');
					// If you're serving to IE 9, then the following may be needed
					header('Cache-Control: max-age=1');

					// If you're serving to IE over SSL, then the following may be needed
					header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
					header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
					header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
					header ('Pragma: public'); // HTTP/1.0

					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
					$objWriter->save('php://output');
					$db->close();
		}
		else
		{
			echo "
          <!DOCTYPE html><html lang=\"en\"><head><meta charset=\"UTF-8\">
          <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
          <meta name=\"description\" content=\"ITG Lan Crew\">
          <meta name=\"author\" content=\"ITG-Lan\">
          <link href=\"../bootstrap.min.css\" rel=\"stylesheet\">
          </head>
          <body>
          <div class=\"col-lg-12 text-center\"><h1>
          ";
			echo("Det finns inga anmälningar att visa just nu, försök igen senare.");
			echo "<meta http-equiv=\"refresh\" content=\"2;url=output.php\">";
			echo "
          </h1></div>
          </body>
          </html>
          ";
			$db->close();
		}
	}
	exit;
}
else
{ 
	echo "
          <!DOCTYPE html><html lang=\"en\"><head><meta charset=\"UTF-8\">
          <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
          <meta name=\"description\" content=\"ITG Lan Crew\">
          <meta name=\"author\" content=\"ITG-Lan\">
          <link href=\"../bootstrap.min.css\" rel=\"stylesheet\">
          </head>
          <body>
          <div class=\"col-lg-12 text-center\"><h1>
          ";
	echo 'Du måste logga in för att se den här sidan.';
	echo "<meta http-equiv=\"refresh\" content=\"2;url=index.php\">";
	echo "
          </h1></div>
          </body>
          </html>
          ";
}
?>