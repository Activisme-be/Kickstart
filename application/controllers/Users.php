<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{
	public $user        = []; /** */
	public $abilities   = []; /** */
	public $permissions = []; /** */

	/**
	 * Users constructor.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library(['blade', 'form_validation', 'session']);
		$this->load->helper(['url']);

		$this->user        = $this->session->userdata('user');
		$this->permissions = $this->session->userdata('permissions');
		$this->abilities   = $this->session->userdata('abilities');

	}

	/**
	 * Get the backend users overview.
	 *
	 * @return blade view.
	 */
	public function index()
	{
		$data['title'] 	     = 'Gebruikers';
		$data['users'] 		 = Authencate::all();
		$data['permissions'] = Permissions::all();

		return $this->blade->render('users/index', $data);
	}

	/**
	 * Get the suer information by the id.
	 *
	 * @return JSON response
	 */
	public function getById()
	{
		$userId = $this->security->xss_clean($this->uri->segment(3));
		$userDb = Authencate::select(['name', 'id'])->find($userId);

		echo json_encode($userDb);
	}

	/**
	 * Block a user from the system.
	 *
	 * @return Response.
	 */
	public function block()
	{
		$this->form_validation->set_rules('', '', '');
		$this->form_validation->set_rules('', '', '');

		if ($this->form_validation->run() === false) { // Form validation fails.
			$data['title'] = 'Gebruikers';
			$data['users'] = Authencate::all();

			return $this->blade->render('users/index', $data);
		}

		// No validation errors. So move on with our logic.
		$userId = $this->security->xss_clean($this->uri->segment(3));

		$reason = Ban::create($input); // TODO: Create the input fields.
		$ban    = Authencate::find($userId)->update(['blocked' => 'N', 'ban_id' => $reason->id]);

		if ($ban && $reason) { // The user has been blocked.
			$this->session->set_flashdata('class', '');
			$this->session->set_flashdata('message', '');
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Show a user.
	 *
	 * @return blade response.
	 */
	public function show()
	{
		$userId       = $this->security->xss_clean($this->uri->segment(3));
		$data['user'] = Authencate::find($userId);

		if ((int) count($data['user']) === 1) {
			$data['title'] = $data['user']->name . '('. $data['user']->username .')';
			return $this->blade->render('users/show', $data);
		}

		return $this->blade->render('errors/html/404');
	}

	/**
	 *
	 *
	 */
	public function edit()
	{
		$data['title'] = 'Wijzig account.';
		$data['user']  = Authencate::find($this->user['id']);

		return $this->blade->render('users/edit', $data);
	}

	/**
	 *
	 *
	 */
	public function updateAccount()
	{
		$this->form_validation->set_rules('', '', '');
		$this->form_validation->set_rules('', '', '');
		$this->form_validation->set_rules('', '', '');

		if ($this->form_validation->run() === false) {

		}

		// No validation errors so move on out backend logic.
		$input['name']     = $this->input->post('name');
		$input['email']    = $this->input->post('email');
		$input['username'] = $this->input->post('password');

		if (Authencate::find($this->user['id'])->update($this->security->xss_clean($input))) {
			$this->session->set_flashdata('class', 'alert alert-success');
			$this->session->set_flashdata('message', 'Uw account gegevens zijn aangepast.');
		}
	}

	/**
	 *
	 * @return Blade view|Redirect
	 */
	public function updateSecurity()
	{
		$this->form_validation->set_rules('', '', '');

		if ($this->form_validation->run() === false) {
			$data['user']  = Authencate::find($this->user['id']);
			$data['title'] = $this->user['name'] . '(' . $this->user['username'] . ')';

			return $this->blade->render('auth/profile', $data);
		}

		// No validation errors Move on with our logic.
		$input['password'] = $this->input->post('password');

		if (Authencate::find($this->user['id'])->update($this->security->xss_clean($input))) {
			$this->session->set_flashdata('class', 'alert alert-success');
			$this->session->set_flashdata('message', 'Het wachtwoord van je account is gewijzigd.');
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Unblock a user in the system.
	 *
	 * @return Redirect
	 */
	public function unblock()
	{
		$userId = $this->security->xss_clean($this->uri->segment(3));

		if (Authencate::find($userId)->update(['ban_id' => 0, ''])) { // User is unblocked.
			$this->session->set_flashdata('class', 'alert alert-success');
			$this->session->set_flashdata('message', 'De gebruiker is actief.');
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}

	/**
	 * Delete an account in the system.
	 *
	 * @return Redirect
	 */
	public function delete()
	{
		$user = Authencate::find($this->security->xss_clean($this->uri->segment(3)));

		if ((int) count($user) === 1) {
			if ($user->delete()) {
				$this->session->set_flashdata('class', 'alert alert-success');
				$this->session->set_flashdata('message', 'De gebruiker is verwijderd.');
			}
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}
}
