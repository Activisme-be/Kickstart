<?php 

class Authencation extends MY_Controller 
{
	/**
	 * Authencation constructor
	 *
	 * @return void
	 */
	public function __construct() 
	{
		parent::__construct();
	}

	/**
	 * The middleware for the controller.
	 *
	 * @return array
	 */
	public function middleware() 
	{
		return [];
	}

	/**
	 * The login view for the user.
	 *
	 * @return Blade view.
	 */
	public function login()
	{
		$data['title'] = 'Inloggen';
		$this->blade->render('auth/login', $data);
	}

	/**
	 * Base method for validation the credentials. 
	 *
	 * @return Response|Blade view
	 */
	public function verify() 
	{
		$this->form_validation->set_rules();
		$this->form_validation->set_rules();

		if ($this->form_validation->run() === false) { // Validation fails
			$data['title'] = 'Inloggen';

			$this->session->set_flashdata('class', 'alert alert-danger');
			$this->session->set_flashdata('message', 'De gebruikersnaam en het wachtwoord die je hebt ingevoerd komen niet overeen met ons archief. Controlleer de gegevens en probeer het opniew.');

			return $this->blade->render('auth/login', $data);
		}

		return redirect(base_url('backend'));
	}

	/**
	 * Check the given credentials against the database.
	 *
	 * @param  string $password The password for the user.
	 * @return Blade view|Response
	 */
	public function check_database($password) 
	{
		$input['email'] = $this->security->xss_clean($this->input->post('email'));
        $MySQL['user']  = Authencate::where('email', $input['email'])
            ->with(['permissions', 'abilities'])
            ->where('blocked', 'N')
            ->where('password', md5($password));

        if ((int) $MySQL['user']->count() === 1) {
            $authencation = []; // Empty userdata array .
            $permissions  = []; // Empty permissions array.
            $abilities    = []; // Empty abilities array.

            foreach ($MySQL['user']->get() as $user) {
                foreach ($user->permissions as $permission) {
                    array_push($permissions, $permission->name);
                }

                foreach ($user->abilities as $ability) {
                    array_push($abilities, $ability->name);
                }

                if (in_array('Admin', $permissions) || in_array('Developer', $permissions)) {
                    $authencation['id']         = $user->id;
                    $authencation['name']       = $user->name;
                    $authencation['email']      = $user->email;
                    $authencation['username']   = $user->username;

                    $this->session->set_userdata('user', $authencation);
                    $this->session->set_userdata('permissions', $permissions);
                    $this->session->set_userdata('abilities', $abilities);

                    return true;
                } else {
                    $this->session->set_flashdata('class', 'alert alert-danger');
                    $this->session->set_flashdata('message', 'U hebt geen rechten om hier in te loggen');

                    return false;
                }
            }
        } else {
            $this->session->set_flashdata('class', 'alert alert-danger');
            $this->session->set_flashdata('message', 'Wrong credentials given.');

            $this->form_validation->set_message('check_database', 'Foutieve login gegevens.');

            return false;
        }
	}

	/**
	 * Register page for the users.
	 *
	 * @return blade view
	 */
	public function register() 
	{
		$data['title'] = 'Registreer';
		$this->blade->render('auth/register', $data);
	}

	/**
	 * Store the new user in the system. 
	 *
	 * @return Response|Blade view.
	 */
	public function store() 
	{
		$this->form_validation->set_rules('name', 'Naam', 'trim|required');
		$this->form_validation->set_rules('username', 'Gebruikersnaam', 'trim|required');
		$this->form_validation->set_rules('email', 'Email adres', 'trim|required');
		$this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required');

		if ($this->form_validation->run() === false) { // Form validation fails.
			$data['title'] = 'Registreren';

			$this->session->set_flashdata('class', 'alert alert-danger');
			$this->session->set_flashdata('message', 'Wij konden de gebruiker niet aanmaken.');

			return $this->blade->render('auth/register', $data);
		}

		// No validation errors found so move on with the logic. 
		$input['name'] 		= $this->input->post('name');
		$input['username']	= $this->input->post('username');
		$input['email']		= $this->input->post('email');
		$input['password']  = md5($this->input->post('password'));

		if (Authencate::create($this->security->xss_clean($input))) {
			$this->session->set_flashdata('class', 'alert alert-success');
			$this->session->set_flashdata('message', 'The gebruiker is aangemaakt.');
		}

		return redirect($_SERVER['HTTP_REFERER']);
	}
}