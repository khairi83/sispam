<?php
require 'lain/SambungdbEksportCSV.php'; 
$table="aset"; // Ini adalah nama "table" yang mahu dieskport ke csv dari mysql.
 
exportMysqlToCsv($table);

function exportMysqlToCsv($table,$file = 'Halaman Luar')
{
	$csv_terminated = "\n";
	$csv_separator = ",";
	$csv_enclosed = '"';
	$csv_escaped = "\\";
	$sql_query = "select * from $table WHERE lokasi = 'Halaman Luar'";
	// Mendapatkan data dari pangkalan data
	$result = mysql_query($sql_query);
	$fields_cnt = mysql_num_fields($result);
	$schema_insert = '';
	for ($i = 0; $i < $fields_cnt; $i++)
	{
		$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
			stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
		$schema_insert .= $l;
		$schema_insert .= $csv_separator;
	} // Tamat "for"
	$out = trim(substr($schema_insert, 0, -1));
	$out .= $csv_terminated;
	// Format data
	while ($row = mysql_fetch_array($result))
	{
		$schema_insert = '';
		for ($j = 0; $j < $fields_cnt; $j++)
		{
			if ($row[$j] == '0' || $row[$j] != '')
			{
				if ($csv_enclosed == '')
				{
					$schema_insert .= $row[$j];
				} else
				{
					$schema_insert .= $csv_enclosed .
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
				}
			} else
			{
				$schema_insert .= '';
			}
			if ($j < $fields_cnt - 1)
			{
				$schema_insert .= $csv_separator;
			}
		} // Tamat "for"
		$out .= $schema_insert;
		$out .= $csv_terminated;
	} // Tamat "while"
	$filename = $file."_".date("Y-m-d_H-i",time());
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($out));
	// Output ke pelayar dengan jenis "mime" yang sesuai, Dipilih anda ;)
	header("Content-type: text/x-csv");
	//header("Content-type: text/csv");
	//header("Content-type: application/csv");
	header("Content-disposition: attachment; filename=".$filename.".csv");

	echo $out;
	exit;
}
?>