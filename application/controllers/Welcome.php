<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @todo docblock
 */
class Welcome extends CI_Controller
{
	public $user        = []; /** TODO: docblock */
	public $permissions = []; /** TODO: docblock */
	public $abilities   = []; /** TODO: docblock */

	/**
	 * @todo docblock
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
	 * @todo docblock
	 */
	public function index()
	{
		$data['title'] = 'Index';
		// TODO; display the mailing actions out off the database.
		// TODO: display the organisations out off the database.
		// TODO: display the manifestation out off the database.
		// TODO: display the crowdfunds out off the database.

		return $this->blade->render('home', $data);
	}
}
