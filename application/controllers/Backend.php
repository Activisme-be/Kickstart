<?php defined('BASEPATH') or exit('No direct script access allowed'); 

class Backend extends MY_Controller 
{
	public $user        = []; /** */
	public $permissions = []; /** */
	public $abilities   = []; /** */ 
	/**
	 * Backend Constructor
	 *
	 * @return void
	 */
	public function __construct() 
	{
		parent::__construct(); 
		$this->load->library(['blade', 'form_validation', 'session']); 
		$this->load->helper(['url']);

		$this->user         = $this->session->userdata('user');
		$this->permissions  = $this->session->userdata('permissions');
		$this->abilities    = $this->session->userdata('abilities');
	}

	/**
	 * Backend controller middleware.
	 * 
	 * @return array
	 */
	protected function middleware() 
	{
		return ['auth']; // TODO: Register the middleware.
	}

	/**
	 * Get the index view for the index.
	 *
	 * @return Blade view.
	 */
	public function index() 
	{ 
		$data['title'] = 'Backend';
		return $this->blade->render('backend', $data);
	}
}
