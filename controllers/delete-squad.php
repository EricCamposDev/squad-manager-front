<?php
	if( isset($_POST['id']) and !empty($_POST['id']) ){

		$opts = array('http' =>
		    array(
		        'method'  => 'DELETE',
		        'max_redirects' => '0',
        		'ignore_errors' => '1'
		    )
		);

		$context = stream_context_create($opts);
		$result = file_get_contents('http://localhost:3333/squad/' . $_POST['id'], false, $context);
		$result = json_decode($result, true);

		$alert = base64_encode("1=Equipe deletada com sucesso!");
		header("location: ../?alert=" . $alert);
	}
