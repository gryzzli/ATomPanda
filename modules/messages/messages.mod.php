<?php

class MessagesMod extends PandaModController
{

	function index()
	{

		$this->data['message'] = $_SESSION['Panda']['Mesages']['Message'];
		$this->data['notice'] = $_SESSION['Panda']['Mesages']['Notice'];
		$this->data['error'] = $_SESSION['Panda']['Mesages']['Error'];
		$user = getinstance('PandaUser');
		if(DEBUG)
		{
			$this->data['debug'] = $_SESSION['Panda']['Mesages']['Debug'];
		}
		if(is_array($this->data['error']))
		{
			$message = implode('\n<hr/>',$this->data['error']);
			$message .= @implode('\n<hr/>',$this->data['debug']);
			$message .= '<br/><hr/>URI: '.$_SERVER['REQUEST_URI'];
			$mail = new PandaMail();
			$mail->to(ADMIN_EMAIL);
			$mail->subject('Grzybowice.pl - Błąd');
			$mail->message($message);
		}


		unset($_SESSION['Panda']['Mesages']);
	}

}