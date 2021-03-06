<?php defined('BASEPATH') or exit('No direct script access allowed');

class Crowdfund extends MY_Controller 
{
	public $user        = [];
	public $abilities   = [];
	public $permissions = [];
	
	/**
	 * Crowdfund constructor
	 *
	 * @return void
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->load->library(['session', 'blade']);
		$this->load->helper(['url']);

		$this->user         = $this->session->userdata('user');
		$this->permissions  = $this->session->userdata('permissions');
		$this->abilities    = $this->session->userdata('abilities');
	}

	/**
	 * Get the crowdfund index.
	 * 
	 * @return blade view.
	 */
	public function index() 
	{
		$data['title'] = 'Crowdfund';
		return $this->blade->render('crowdfund', $data);
	}
}