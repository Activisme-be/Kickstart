<?php defined('BASEPATH') or exit('No direct script access allowed');

class Volunteer extends MY_controller
{
    public $user        = []; /** @var array $user         The authencated user information. */
    public $permissions = []; /** @var array $permissions  The authencated user permissions. */
    public $abilities   = []; /** @var array $abilities    The authencated user abilities    */

    /**
     * Volunteer constructor.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['blade', 'session', 'form_validation']);
        $this->load->helper(['url']);

        $this->user        = $this->session->userdata('user');
        $this->abilities   = $this->session->userdata('abilities');
        $this->permissions = $this->session->userdata('permissions');
    }

    /**
     * The middleware for the controller.
     *
     * @return array
     */
    protected function middleware()
    {
        return []; // TODO: register auth middleware for delete and index.
    }

    public function index()
    {
        $data['title']      = 'Index';
        $data['volunteers'] = Volunteers::all();
        
        return $this->blade->render('volunteers/index', $data);
    }

    public function new()
    {
        $data['title'] = 'Word vrijwilliger.';
        return $this->blade->render('volunteers/new', $data);
    }

    /**
     * Store a new volunteer in the system.
     *
     * @return Redirect | Blade view.
     */
    public function store()
    {
        $this->form_validation->set_rules();
        $this->form_validation->set_rules();

        if ($this->form_validation->run() === false) { // form validation fails.
            $data['title']      = 'Vrijwilligers';
            return $this->blade->render('volunteers/new', $data);
        }

        // No validation errors found. Move on with the logic.
        $input['name']        = $this->input->post('name');
        $input['email']       = $this->input->post('email');
        $input['information'] = $this->input->post('information');

        if (Volunteers::create($this->security->xss_clean($input))) { // Record has been inserted.
            $this->session->set_flashdata('class', 'alert alert-success');
            $this->session->set_flashdata('message', 'Wij danken je voor je intresse.');
        }

        return redirect(back());
    }

    /**
     * Delete a volunteer in the system.
     *
     * @return Blade view | Redirect
     */
    public function delete()
    {
        $paramId       = $this->uri->segment(3);
        $volunteer     = Volunteers::find($this->security->xss_clean($paramId));
        $sessionOutput = $this->session;

        if ((int) count($volunteer) === 0) { // Volunteer is not found.
            $sessionOutput->set_flashdata('class', 'alert alert-danger');
            $sessionOutput->set_flashdata('message', 'Wij konden geen vrijwilliger vinden met de id:' . $paramId);
        } else { // Volunteer is found
            if ($volunteer->delete()) { // Volunteer is deleted.
                $sessionOutput->set_flashdata('class', 'alert alert-success');
                $sessionOutput->set_flashdata('message', 'De vrijwilliger is verwijderd in het systeem.');
            }
        }

        return redirect($_SERVER['HTTP_REFERER']);
    }
}