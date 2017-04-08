<?php defined('BASEPATH') or exit('No direct script access allowed.');

/**
 * Authencation controller.
 *
 * @author    Tim Joosten   <Topairy@gmail.com>
 * @copyright Activisme-BE  <info@activisme.be>
 * @license:  MIT license
 * @since     2017
 */
class Auth extends CI_Controller
{
    public $user        = []; /** @var array $user          The user data about the authencated user.  */
    public $permissions = []; /** @var array $permissions   The authencated user permissions.          */
    public $abilities   = []; /** @var array $abilities     The authencated user abilities.            */

    /**
     * Auth constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'form_validation', 'blade']);
        $this->load->helper(['url']);

        $this->user         = $this->session->userdata('user');
        $this->permissions  = $this->session->userdata('permissions');
        $this->abilities    = $this->session->userdata('abilities');
    }

    /**
     * Return the list of middlewares you want to be applied,
     * Here is a list of some valid options.
     *
     * admin_auth                       // As used below, simplest, will be applied to all
     * someother|except:index,list      // This will be applied to posts()
     * yet_another_one|only:index       // This will be applied to index()
     *
     * @return array
     */
    protected function middleware()
    {
        return [];
    }

    /**
     * Verify the user login against the database.
     *
     * @return boolean
     */
    public function verify()
    {
        $this->form_validation->set_rules('email', 'email', 'trim|required');
        $this->form_validation->set_rules('password', 'Wachtwoord', 'trim|required|callback_check_database');

        if ($this->form_validation->run() === false) { // Form validation fails.
            $data['title'] = 'Inloggen';

            $this->session->set_flashdata('class', 'alert alert-danger');
            $this->session->set_flashdata('message', 'De gebruikersnaam en het wachtwoord die je hebt ingevoerd komen niet overeen met ons archief. Controleer de gegevens en probeer het opnieuw.');

            return $this->blade->render('auth/login', $data);
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * [INTERNAL]: Check the given user input againstè the database.
     *
     * @param  string $password  The user given password.
     * @return boolean
     */
    public function check_database($password)
    {
        $input['email'] = $this->security->xss_clean($this->input->post('email'));
        $MySQL['user']  = Authencate::where('email', $input['email'])
            ->with(['permissions', 'abilities'])
            ->where('blocked', 'N')
            ->where('password', md5($password));

        if ($MySQL['user']->count() === 1) { // User is found with the given credentials.
            $authencation = []; // Empty userdata array.
            $permissions  = []; // Empty permissions array.
            $abilities    = []; // Empty abilities array.

            // Build up the permissions, user and abilities array.
            foreach ($MySQL['user']->get() as $user) {
                foreach ($user->permissions as $permission) {
                    array_push($permissions, $permission->name);
                }

                foreach ($user->abilities as $ability) {
                    array_push($abilities, $ability->name);
                }

                $authencation['id']       = $user->id;
                $authencation['name']     = $user->name;
                $authencation['email']    = $user->email;
                $authencation['username'] = $user->username;
            }

            $this->session->set_userdata('user', $authencation);
            $this->session->set_userdata('permissions', $permissions);
            $this->session->set_userdata('abilities', $abilities);

            return true;
        } else { // User is not found or the password doesn't match.
            $this->session->set_flashdata('class', 'alert alert-danger');
            $this->session->set_userdata('Wrong crednetials given');

            $this->form_validation->set_message('check_database', 'Foutieve login gevens.');

            return false;
        }
    }

    /**
     * View for creating a new user.
     *
     * @return blade view.
     */
    public function register()
    {
        $data['title'] = 'Registratie';
        return $this->blade->render('auth/register', $data);
    }

    /**
     * Store the new user in the database.
     *
     * @return Redirect|Response
     */
    public function store()
    {
        // BUG: MD5 is insecure. Replace it with a better hashing.

        $this->form_validation->set_rules('username', 'username', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'password', 'trim|required');
        $this->form_validation->set_rules('email', 'password', 'trim|required|is_unique[users.email]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registratie';
            return $this->blade->render('auth/register', $data);
        }

        // No errors so move on with the logic.

        $input['username'] = $this->input->post('username');
        $input['name']     = $this->input->post('name');
        $input['password'] = md5($this->input->post('password'));
        $input['email']    = $this->input->post('email');
        $input['blocked']  = 'N';
        $input['ban_id']   = 0;

        if (Authencate::create($this->security->xss_clean($input))) { // Validation fails.
            $this->session->set_flashdata('class', 'alert alert-success');
            $this->session->set_flashdata('message', 'Uw account is aangemaakt');
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }
}