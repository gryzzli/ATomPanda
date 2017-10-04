<?php

class PandaMail
{

function message($data)
{
	$this->message = '<html><body>'.$data.'</body></html>';
}

function to($data)
{
	$this->to = $data;
}

function address($address) { $this->to($address); }

function subject($data)
{
	$this->subject = $data;
}

function send()
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";


	mail($this->to, $this->subject, $this->message, $headers);

}





}