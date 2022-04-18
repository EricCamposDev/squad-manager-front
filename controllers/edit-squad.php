<?php
	if( isset($_POST['name']) and !empty($_POST['name']) ){

		$squad = [
			'name' => $_POST['squad_name'],
			'members' => []
		];

		if( isset($_POST['name'][0]) and !empty($_POST['name'][0])){
			for($c = 0; $c < count($_POST['name']); $c++){
				array_unshift($squad['members'],[
					'name' => $_POST['name'][$c],
					'email' => $_POST['email'][$c],
					'phone' => $_POST['phone'][$c],
				]);
			}
		}

		$opts = array('http' =>
		    array(
		        'method'  => 'PUT',
		        'header'  => 'Content-type: application/json',
		        'content' => json_encode($squad)
		    )
		);

		$context = stream_context_create($opts);

		$result = file_get_contents('http://localhost:3333/squad/' . $_POST['id'], false, $context);
		$result = json_decode($result, true);


		if( $result['error'] == true ){

			$alert = base64_encode("0=Falha ao editar equipe, infelizmente o nedb está com problemas ao atualizar um time, tanto na forma async quanto na comum, por isso recomendo que exclua e crie novamente.");

			header("location: ../?alert=" . $alert);
		}else{

			$alert = base64_encode("1=Equipe editada com sucesso!");
			header("location: ../?alert=" . $alert);
		}
		
	}	
?>