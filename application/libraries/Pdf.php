<?php defined('BASEPATH') OR exit('No direct script access allowed');
// Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf{
	public function __construct(){
		require_once dirname(__FILE__).'/dompdf/autoload.inc.php';

		$options = new Options();
		$options->set('isRemoteEnabled', TRUE);
		$pdf = new DOMPDF($options);
		
		$contxt = stream_context_create([ 
		    'ssl' => [ 
		        'verify_peer' => FALSE, 
		        'verify_peer_name' => FALSE,
		        'allow_self_signed'=> TRUE
		    ] 
		]);

		$pdf->setHttpContext($contxt);
		$CI = & get_instance();
		$CI->dompdf = $pdf;
	}
}
?>