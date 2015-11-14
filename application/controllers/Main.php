<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        /* ------------------ */
		$this->load->vars(array('home_page' => FALSE));
        $this->load->library('grocery_CRUD');

    }
    
	public function index()
	{
		$this->load->vars(array('home_page' => TRUE));
		$this->load->view('our_template.php');
	}

    public function attendees()
    {
    $this->grocery_crud->set_table('tblattendees');
    $this->grocery_crud->columns('FirstName','LastName','Email','Organization','Notes','MemberDate','Events','Count');
    $this->grocery_crud->set_relation_n_n('Events', 'tbleventsattendees', 'tblevents', 'tblAttendees_ID', 'tblEvents_ID', 'Event');
    $this->grocery_crud->set_relation('Organization', 'tblorganizations', 'OrgName');
    $this->grocery_crud->set_relation('MemberStatus', 'tblmemberstatus', 'Status');
    $this->grocery_crud->order_by('LastName, FirstName');
    $this->grocery_crud
    	->display_as('FirstName','First Name')
    	->display_as('LastName','Last Name')
 		->display_as('MemberDate','Membership Date')
 		->display_as('MemberStatus','Membership Status')
 		->display_as('Events','Events Attended')
 		->display_as('Count','Event Count');
 	$this->grocery_crud->callback_column('Count',array($this, '_callback_get_counter'));
	$this->grocery_crud->callback_before_insert(array($this,'_default_status'));
	$this->state = $this->grocery_crud->getState();
	if(in_array($this->grocery_crud->getState(), array('list','ajax_list','success'))) {
		$this->db
			->select('tblattendees.ID, (SELECT COUNT(*) FROM tbleventsattendees WHERE tbleventsattendees.tblAttendees_ID=tblattendees.ID) AS event_count', false);
	}
    $output = $this->grocery_crud->render();
	$this->_example_output($output);
    }
    
	function _default_status($post_array) {
	if (empty($post_array['MemberStatus'])) $post_array['MemberStatus'] = 2;
	return $post_array;
	}        

    public function events()
    {
    $this->grocery_crud->set_table('tblevents');
    $this->grocery_crud->columns('Event','EventDate','Count');
    $this->grocery_crud->order_by('EventDate', 'desc');
    $this->grocery_crud
    	->display_as('Event','Event Name')
    	->display_as('EventDate', 'Event Date')
    	->display_as('Count','Attendee Count');
    $this->grocery_crud->callback_column('Count',array($this, '_callback_get_counter'));
    $this->state = $this->grocery_crud->getState();
	if(in_array($this->grocery_crud->getState(), array('list','ajax_list','success'))) {
		$this->db
			->select('tblevents.ID, (SELECT COUNT(*) FROM tbleventsattendees WHERE tbleventsattendees.tblEvents_ID=tblevents.ID) AS event_count', false);
	}
    $output = $this->grocery_crud->render();
    $this->_example_output($output);
    }

    public function organizations()
    {
    $this->grocery_crud->set_table('tblorganizations');
    $this->grocery_crud->columns('OrgName','Count');
    $this->grocery_crud->order_by('OrgName', 'asc');
    $this->grocery_crud
    	->display_as('OrgName','Organization Name')
    	->display_as('Count', 'Attendee Count');
    $this->grocery_crud->callback_column('Count',array($this, '_callback_get_counter'));
    $this->state = $this->grocery_crud->getState();
	if(in_array($this->grocery_crud->getState(), array('list','ajax_list','success'))) {
		$this->db
			->select('tblorganizations.ID, (SELECT COUNT(*) FROM tblattendees WHERE tblorganizations.ID=tblattendees.Organization) AS event_count', false);
	}
    $output = $this->grocery_crud->render();
    $this->_example_output($output);
    }

    public function memberstatus()
    {
    $this->grocery_crud->set_table('tblmemberstatus');
    $this->grocery_crud->columns('Status','Count');
    $this->grocery_crud->order_by('Status', 'asc');
    $this->grocery_crud->callback_column('Count',array($this, '_callback_get_counter'));
    $this->state = $this->grocery_crud->getState();
	if(in_array($this->grocery_crud->getState(), array('list','ajax_list','success'))) {
		$this->db
			->select('tblmemberstatus.ID, (SELECT COUNT(*) FROM tblattendees WHERE tblmemberstatus.ID=tblattendees.MemberStatus) AS event_count', false);
	}
    $output = $this->grocery_crud->render();
    $this->_example_output($output);
    }

    public function eventcounts()
    {
    $this->grocery_crud->set_table('EventsAttended');
    $this->grocery_crud->set_primary_key('ID');
    $this->grocery_crud->columns('FirstName','LastName','Status','Events');
    $this->grocery_crud->display_as('FirstName','First Name')->display_as('LastName','Last Name');
    $this->grocery_crud->order_by('Events','desc');
    $this->grocery_crud->unset_operations(); 
    $output = $this->grocery_crud->render();
    $this->_example_output($output);
    }
	
	// Callback function
	public function _callback_get_counter($value, $row) {
    return $row->event_count;
	}

    function _example_output($output = null)
    {
        $this->load->view('our_template.php',$output);
    }

}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
