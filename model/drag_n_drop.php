<?php
class picture{
	public function add_picture() {

	 	$file = $_POST['file'];
	 	$name = $_POST['img'].'.jpg';

		$encodedData = str_replace(' ','+',$file);
		$decodedData = base64_decode($encodedData);

		file_put_contents('../view/css/'.$name, $decodedData);
		echo 'ok';

	}
}
$picture = new picture();
$picture->add_picture();
?>